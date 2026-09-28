import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../services/api_service.dart';

class SettingsScreen extends StatefulWidget {
  const SettingsScreen({super.key});

  @override
  State<SettingsScreen> createState() => _SettingsScreenState();
}

class _SettingsScreenState extends State<SettingsScreen> {
  final _urlController = TextEditingController();
  bool _isSaving = false;
  bool _isTesting = false;
  String? _testResult;
  bool? _testSuccess;
  String _userName = '';
  String _userEmail = '';

  @override
  void initState() {
    super.initState();
    _loadSettings();
  }

  Future<void> _loadSettings() async {
    final url = await ApiService.getBaseUrl();
    final name = await ApiService.getUserName();
    final prefs = await SharedPreferences.getInstance();
    final email = prefs.getString('user_email') ?? '-';

    if (mounted) {
      setState(() {
        _urlController.text = url;
        _userName = name;
        _userEmail = email;
      });
    }
  }

  Future<void> _saveUrl() async {
    final url = _urlController.text.trim();
    if (url.isEmpty) return;

    setState(() => _isSaving = true);
    await ApiService.setBaseUrl(url);

    if (mounted) {
      setState(() => _isSaving = false);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('URL Server berhasil disimpan'),
          backgroundColor: Color(0xFF22C55E),
          duration: Duration(seconds: 2),
        ),
      );
    }
  }

  Future<void> _testConnection() async {
    setState(() {
      _isTesting = true;
      _testResult = null;
      _testSuccess = null;
    });

    // Simpan URL dulu
    await ApiService.setBaseUrl(_urlController.text.trim());

    try {
      final baseUrl = await ApiService.getBaseUrl();
      final uri = Uri.parse('$baseUrl/up');
      final response = await http.get(uri).timeout(const Duration(seconds: 5));

      if (mounted) {
        setState(() {
          _isTesting = false;
          _testSuccess = response.statusCode == 200;
          _testResult = response.statusCode == 200
              ? 'Koneksi berhasil! Server aktif.'
              : 'Server merespons dengan status ${response.statusCode}';
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _isTesting = false;
          _testSuccess = false;
          _testResult = 'Gagal terhubung ke server.\nPastikan URL benar dan server aktif.\n\nError: $e';
        });
      }
    }
  }

  @override
  void dispose() {
    _urlController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0B2A4A),
      appBar: AppBar(
        backgroundColor: const Color(0xFF0B2A4A),
        foregroundColor: Colors.white,
        title: const Text(
          'Pengaturan',
          style: TextStyle(fontWeight: FontWeight.w700),
        ),
        elevation: 0,
      ),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          // ── Akun Info ──
          _buildSection(
            title: 'Akun Login',
            icon: Icons.person,
            child: Column(
              children: [
                _buildInfoTile('Nama', _userName),
                _buildInfoTile('Email', _userEmail),
              ],
            ),
          ),
          const SizedBox(height: 24),

          // ── Server URL ──
          _buildSection(
            title: 'Konfigurasi Server',
            icon: Icons.dns,
            child: Column(
              children: [
                TextFormField(
                  controller: _urlController,
                  keyboardType: TextInputType.url,
                  style: const TextStyle(color: Colors.white, fontSize: 14),
                  decoration: InputDecoration(
                    hintText: 'http://192.168.1.1:8000',
                    hintStyle: TextStyle(color: Colors.white.withAlpha(77)),
                    filled: true,
                    fillColor: Colors.white.withAlpha(26),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(6),
                      borderSide: BorderSide(color: Colors.white.withAlpha(51)),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(6),
                      borderSide: BorderSide(color: Colors.white.withAlpha(51)),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(6),
                      borderSide: const BorderSide(color: Color(0xFFD4A843)),
                    ),
                  ),
                ),
                const SizedBox(height: 4),
                Align(
                  alignment: Alignment.centerLeft,
                  child: Text(
                    'Masukkan IP LAN laptop atau domain server',
                    style: TextStyle(color: Colors.white.withAlpha(102), fontSize: 11),
                  ),
                ),
                const SizedBox(height: 12),
                Row(
                  children: [
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: _isTesting ? null : _testConnection,
                        icon: _isTesting
                            ? const SizedBox(
                                width: 16,
                                height: 16,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Color(0xFFD4A843),
                                ),
                              )
                            : const Icon(Icons.wifi_find, size: 18),
                        label: Text(_isTesting ? 'Testing...' : 'Tes Koneksi'),
                        style: OutlinedButton.styleFrom(
                          foregroundColor: const Color(0xFFD4A843),
                          side: const BorderSide(color: Color(0xFFD4A843)),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(6),
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: ElevatedButton.icon(
                        onPressed: _isSaving ? null : _saveUrl,
                        icon: _isSaving
                            ? const SizedBox(
                                width: 16,
                                height: 16,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Color(0xFF0B2A4A),
                                ),
                              )
                            : const Icon(Icons.save, size: 18),
                        label: const Text('Simpan'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFFD4A843),
                          foregroundColor: const Color(0xFF0B2A4A),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(6),
                          ),
                          elevation: 0,
                        ),
                      ),
                    ),
                  ],
                ),
                if (_testResult != null) ...[
                  const SizedBox(height: 12),
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: _testSuccess == true
                          ? const Color(0xFF0D3320)
                          : const Color(0xFF3B1212),
                      borderRadius: BorderRadius.circular(6),
                      border: Border.all(
                        color: _testSuccess == true
                            ? const Color(0xFF22C55E)
                            : const Color(0xFFEF4444),
                      ),
                    ),
                    child: Text(
                      _testResult!,
                      style: TextStyle(
                        color: _testSuccess == true
                            ? const Color(0xFF86EFAC)
                            : const Color(0xFFFCA5A5),
                        fontSize: 13,
                      ),
                    ),
                  ),
                ],
              ],
            ),
          ),
          const SizedBox(height: 24),

          // ── Tentang ──
          _buildSection(
            title: 'Tentang Aplikasi',
            icon: Icons.info_outline,
            child: Column(
              children: [
                _buildInfoTile('Aplikasi', 'KADIN Scanner'),
                _buildInfoTile('Versi', '1.0.0'),
                _buildInfoTile('Sistem', 'Presensi QR Kadin Indonesia 2026'),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSection({
    required String title,
    required IconData icon,
    required Widget child,
  }) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white.withAlpha(13),
        borderRadius: BorderRadius.circular(8),
        border: Border.all(color: Colors.white.withAlpha(26)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Icon(icon, color: const Color(0xFFD4A843), size: 20),
              const SizedBox(width: 8),
              Text(
                title,
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          child,
        ],
      ),
    );
  }

  Widget _buildInfoTile(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 6),
      child: Row(
        children: [
          SizedBox(
            width: 90,
            child: Text(
              label,
              style: TextStyle(
                color: Colors.white.withAlpha(153),
                fontSize: 13,
              ),
            ),
          ),
          Expanded(
            child: Text(
              value.isEmpty ? '-' : value,
              style: const TextStyle(
                color: Colors.white,
                fontSize: 14,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
