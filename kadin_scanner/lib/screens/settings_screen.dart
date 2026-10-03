import 'dart:ui';
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
          backgroundColor: Color(0xFF10B981),
          behavior: SnackBarBehavior.floating,
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
              : 'Server merespons status ${response.statusCode}';
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _isTesting = false;
          _testSuccess = false;
          _testResult = 'Gagal terhubung ke server.\nPeriksa koneksi WiFi atau IP.\n\nError: $e';
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
      backgroundColor: const Color(0xFF090D16),
      appBar: AppBar(
        backgroundColor: const Color(0xFF0F172A).withValues(alpha: 0.8),
        foregroundColor: Colors.white,
        centerTitle: false,
        title: const Text(
          'Pengaturan Scanner',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),
        ),
        elevation: 0,
      ),
      body: ListView(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
        children: [
          // ── Akun Info ──
          _buildGlassSection(
            title: 'Petugas Presensi',
            icon: Icons.badge_outlined,
            child: Column(
              children: [
                _buildInfoTile('Nama', _userName),
                _buildInfoTile('Email', _userEmail),
              ],
            ),
          ),
          const SizedBox(height: 18),

          // ── Server URL ──
          _buildGlassSection(
            title: 'Konfigurasi Server API',
            icon: Icons.dns_outlined,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                TextFormField(
                  controller: _urlController,
                  keyboardType: TextInputType.url,
                  style: const TextStyle(color: Colors.white, fontSize: 13),
                  decoration: InputDecoration(
                    hintText: 'http://192.168.x.x:8000',
                    hintStyle: TextStyle(color: Colors.white.withValues(alpha: 0.35)),
                    filled: true,
                    fillColor: const Color(0xFF1E293B).withValues(alpha: 0.5),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide(color: Colors.white.withValues(alpha: 0.1)),
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide(color: Colors.white.withValues(alpha: 0.1)),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: Color(0xFF38BDF8)),
                    ),
                  ),
                ),
                const SizedBox(height: 6),
                Text(
                  'Masukkan IP LAN Wi-Fi laptop jika scan menggunakan HP fisik',
                  style: TextStyle(color: Colors.white.withValues(alpha: 0.45), fontSize: 11),
                ),
                const SizedBox(height: 16),
                Row(
                  children: [
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: _isTesting ? null : _testConnection,
                        icon: _isTesting
                            ? const SizedBox(
                                width: 14,
                                height: 14,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Color(0xFF38BDF8),
                                ),
                              )
                            : const Icon(Icons.wifi_find, size: 16),
                        label: Text(_isTesting ? 'Testing...' : 'Tes Koneksi'),
                        style: OutlinedButton.styleFrom(
                          foregroundColor: const Color(0xFF38BDF8),
                          side: const BorderSide(color: Color(0xFF38BDF8)),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
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
                                width: 14,
                                height: 14,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Colors.white,
                                ),
                              )
                            : const Icon(Icons.save_outlined, size: 16),
                        label: const Text('Simpan'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF2563EB),
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
                          ),
                          elevation: 0,
                        ),
                      ),
                    ),
                  ],
                ),
                if (_testResult != null) ...[
                  const SizedBox(height: 14),
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(12),
                    decoration: BoxDecoration(
                      color: _testSuccess == true
                          ? const Color(0xFF10B981).withValues(alpha: 0.12)
                          : const Color(0xFFEF4444).withValues(alpha: 0.12),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: _testSuccess == true
                            ? const Color(0xFF10B981).withValues(alpha: 0.4)
                            : const Color(0xFFEF4444).withValues(alpha: 0.4),
                      ),
                    ),
                    child: Text(
                      _testResult!,
                      style: TextStyle(
                        color: _testSuccess == true
                            ? const Color(0xFF86EFAC)
                            : const Color(0xFFFCA5A5),
                        fontSize: 12,
                        height: 1.35,
                      ),
                    ),
                  ),
                ],
              ],
            ),
          ),
          const SizedBox(height: 18),

          // ── Tentang ──
          _buildGlassSection(
            title: 'Tentang Aplikasi',
            icon: Icons.info_outline,
            child: Column(
              children: [
                _buildInfoTile('Aplikasi', 'Wonderful Scanner'),
                _buildInfoTile('Versi', '1.0.0 (2026 Edition)'),
                _buildInfoTile('Sistem', 'Presensi QR Wonderful 2026'),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildGlassSection({
    required String title,
    required IconData icon,
    required Widget child,
  }) {
    return ClipRRect(
      borderRadius: BorderRadius.circular(20),
      child: BackdropFilter(
        filter: ImageFilter.blur(sigmaX: 16, sigmaY: 16),
        child: Container(
          padding: const EdgeInsets.all(18),
          decoration: BoxDecoration(
            color: const Color(0xFF0F172A).withValues(alpha: 0.65),
            borderRadius: BorderRadius.circular(20),
            border: Border.all(color: Colors.white.withValues(alpha: 0.1)),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Icon(icon, color: const Color(0xFF38BDF8), size: 18),
                  const SizedBox(width: 8),
                  Text(
                    title,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 14,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 14),
              child,
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildInfoTile(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 5),
      child: Row(
        children: [
          SizedBox(
            width: 80,
            child: Text(
              label,
              style: TextStyle(
                color: Colors.white.withValues(alpha: 0.55),
                fontSize: 12,
              ),
            ),
          ),
          Expanded(
            child: Text(
              value.isEmpty ? '-' : value,
              style: const TextStyle(
                color: Colors.white,
                fontSize: 13,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
