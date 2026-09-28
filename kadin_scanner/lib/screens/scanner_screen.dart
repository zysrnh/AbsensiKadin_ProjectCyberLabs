import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import '../services/api_service.dart';
import 'login_screen.dart';
import 'settings_screen.dart';

class ScannerScreen extends StatefulWidget {
  const ScannerScreen({super.key});

  @override
  State<ScannerScreen> createState() => _ScannerScreenState();
}

class _ScannerScreenState extends State<ScannerScreen> {
  MobileScannerController? _cameraController;
  bool _isProcessing = false;
  String _userName = 'Admin';
  final List<Map<String, dynamic>> _scanHistory = [];

  @override
  void initState() {
    super.initState();
    _initCamera();
    _loadUserName();
  }

  void _initCamera() {
    _cameraController = MobileScannerController(
      detectionSpeed: DetectionSpeed.normal,
      facing: CameraFacing.back,
      torchEnabled: false,
    );
  }

  Future<void> _loadUserName() async {
    final name = await ApiService.getUserName();
    if (mounted) {
      setState(() => _userName = name);
    }
  }

  @override
  void dispose() {
    _cameraController?.dispose();
    super.dispose();
  }

  /// Handler ketika QR Code terdeteksi
  Future<void> _onDetect(BarcodeCapture capture) async {
    if (_isProcessing) return;

    final barcode = capture.barcodes.firstOrNull;
    if (barcode == null || barcode.rawValue == null) return;

    final qrToken = barcode.rawValue!.trim();
    if (qrToken.isEmpty) return;

    setState(() => _isProcessing = true);

    // Getar HP sebagai feedback scan
    HapticFeedback.mediumImpact();

    final result = await ApiService.verifyScan(qrToken);

    if (!mounted) return;

    _showResultDialog(result);
  }

  /// Tampilkan dialog hasil scan
  void _showResultDialog(Map<String, dynamic> result) {
    final status = result['status'] as String? ?? 'error';
    final message = result['message'] as String? ?? '';
    final participant = result['participant'] as Map<String, dynamic>?;

    Color bgColor;
    Color borderColor;
    Color textColor;
    IconData iconData;
    String title;

    switch (status) {
      case 'success':
        bgColor = const Color(0xFF0D3320);
        borderColor = const Color(0xFF22C55E);
        textColor = const Color(0xFF86EFAC);
        iconData = Icons.check_circle;
        title = 'BERHASIL';
        break;
      case 'already_attended':
        bgColor = const Color(0xFF3D2E06);
        borderColor = const Color(0xFFEAB308);
        textColor = const Color(0xFFFDE68A);
        iconData = Icons.info;
        title = 'SUDAH HADIR';
        break;
      default:
        bgColor = const Color(0xFF3B1212);
        borderColor = const Color(0xFFEF4444);
        textColor = const Color(0xFFFCA5A5);
        iconData = Icons.cancel;
        title = 'TIDAK DITEMUKAN';
    }

    // Tambah ke history
    _scanHistory.insert(0, {
      'status': status,
      'title': title,
      'participant': participant,
      'message': message,
      'time': DateTime.now().toIso8601String(),
    });

    // Batasi history max 50
    if (_scanHistory.length > 50) {
      _scanHistory.removeRange(50, _scanHistory.length);
    }

    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (ctx) => Dialog(
        backgroundColor: Colors.transparent,
        insetPadding: const EdgeInsets.symmetric(horizontal: 28),
        child: Container(
          padding: const EdgeInsets.all(28),
          decoration: BoxDecoration(
            color: bgColor,
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: borderColor, width: 2),
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Icon(iconData, color: borderColor, size: 56),
              const SizedBox(height: 16),
              Text(
                title,
                style: TextStyle(
                  color: borderColor,
                  fontSize: 22,
                  fontWeight: FontWeight.w800,
                  letterSpacing: 2,
                ),
              ),
              const SizedBox(height: 16),

              // Info peserta
              if (participant != null) ...[
                _buildInfoRow('Nama', participant['name'] ?? '-', textColor),
                _buildInfoRow('Instansi', participant['company'] ?? '-', textColor),
                _buildInfoRow('Jabatan', participant['position'] ?? '-', textColor),
                if (participant['time'] != null)
                  _buildInfoRow('Waktu', participant['time'], textColor),
                if (participant['qr_token'] != null)
                  _buildInfoRow('Token', participant['qr_token'], textColor),
              ] else ...[
                // Tampilkan pesan error biasa (strip HTML tags)
                Text(
                  _stripHtml(message),
                  textAlign: TextAlign.center,
                  style: TextStyle(color: textColor, fontSize: 14, height: 1.5),
                ),
              ],

              const SizedBox(height: 24),

              SizedBox(
                width: double.infinity,
                height: 48,
                child: ElevatedButton(
                  onPressed: () {
                    Navigator.pop(ctx);
                    setState(() => _isProcessing = false);
                  },
                  style: ElevatedButton.styleFrom(
                    backgroundColor: borderColor,
                    foregroundColor: bgColor,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(6),
                    ),
                    elevation: 0,
                  ),
                  child: const Text(
                    'SCAN LAGI',
                    style: TextStyle(
                      fontWeight: FontWeight.w700,
                      fontSize: 15,
                      letterSpacing: 1.5,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildInfoRow(String label, String value, Color textColor) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 80,
            child: Text(
              label,
              style: TextStyle(
                color: textColor.withAlpha(153),
                fontSize: 13,
              ),
            ),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              value,
              style: TextStyle(
                color: textColor,
                fontSize: 14,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }

  String _stripHtml(String html) {
    return html.replaceAll(RegExp(r'<[^>]*>'), '');
  }

  void _toggleFlash() {
    _cameraController?.toggleTorch();
  }

  void _switchCamera() {
    _cameraController?.switchCamera();
  }

  Future<void> _handleLogout() async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: const Color(0xFF112D4E),
        title: const Text('Logout', style: TextStyle(color: Colors.white)),
        content: const Text(
          'Yakin ingin keluar dari akun?',
          style: TextStyle(color: Colors.white70),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(ctx, false),
            child: const Text('Batal', style: TextStyle(color: Colors.white54)),
          ),
          TextButton(
            onPressed: () => Navigator.pop(ctx, true),
            child: const Text('Keluar', style: TextStyle(color: Color(0xFFEF4444))),
          ),
        ],
      ),
    );

    if (confirm == true) {
      await ApiService.logout();
      if (mounted) {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const LoginScreen()),
        );
      }
    }
  }

  void _showHistory() {
    showModalBottomSheet(
      context: context,
      backgroundColor: const Color(0xFF0B2A4A),
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(8)),
      ),
      builder: (ctx) => DraggableScrollableSheet(
        initialChildSize: 0.6,
        maxChildSize: 0.9,
        minChildSize: 0.3,
        expand: false,
        builder: (_, scrollController) => Column(
          children: [
            // Handle bar
            Container(
              width: 40,
              height: 4,
              margin: const EdgeInsets.symmetric(vertical: 12),
              decoration: BoxDecoration(
                color: Colors.white24,
                borderRadius: BorderRadius.circular(2),
              ),
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 20),
              child: Row(
                children: [
                  const Icon(Icons.history, color: Color(0xFFD4A843), size: 20),
                  const SizedBox(width: 8),
                  const Text(
                    'Riwayat Scan',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 18,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  const Spacer(),
                  Text(
                    '${_scanHistory.length} scan',
                    style: const TextStyle(color: Colors.white38, fontSize: 13),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 8),
            Divider(color: Colors.white.withAlpha(26)),
            Expanded(
              child: _scanHistory.isEmpty
                  ? Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.qr_code_scanner, color: Colors.white.withAlpha(51), size: 48),
                          const SizedBox(height: 12),
                          Text(
                            'Belum ada scan',
                            style: TextStyle(color: Colors.white.withAlpha(102), fontSize: 14),
                          ),
                        ],
                      ),
                    )
                  : ListView.separated(
                      controller: scrollController,
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      itemCount: _scanHistory.length,
                      separatorBuilder: (_, __) => Divider(
                        color: Colors.white.withAlpha(13),
                        height: 1,
                      ),
                      itemBuilder: (_, index) {
                        final item = _scanHistory[index];
                        final participant = item['participant'] as Map<String, dynamic>?;
                        final status = item['status'] as String;

                        Color dotColor;
                        switch (status) {
                          case 'success':
                            dotColor = const Color(0xFF22C55E);
                            break;
                          case 'already_attended':
                            dotColor = const Color(0xFFEAB308);
                            break;
                          default:
                            dotColor = const Color(0xFFEF4444);
                        }

                        final time = DateTime.tryParse(item['time'] ?? '');
                        final timeStr = time != null
                            ? '${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}:${time.second.toString().padLeft(2, '0')}'
                            : '-';

                        return ListTile(
                          contentPadding: const EdgeInsets.symmetric(horizontal: 4, vertical: 4),
                          leading: Container(
                            width: 10,
                            height: 10,
                            decoration: BoxDecoration(
                              color: dotColor,
                              shape: BoxShape.circle,
                            ),
                          ),
                          title: Text(
                            participant?['name'] ?? item['title'] ?? '-',
                            style: const TextStyle(
                              color: Colors.white,
                              fontSize: 14,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                          subtitle: Text(
                            participant != null
                                ? '${participant['company'] ?? '-'} • ${participant['position'] ?? '-'}'
                                : _stripHtml(item['message'] ?? ''),
                            style: TextStyle(
                              color: Colors.white.withAlpha(102),
                              fontSize: 12,
                            ),
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                          ),
                          trailing: Text(
                            timeStr,
                            style: TextStyle(
                              color: Colors.white.withAlpha(77),
                              fontSize: 12,
                              fontFamily: 'monospace',
                            ),
                          ),
                        );
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0B2A4A),
      body: Stack(
        children: [
          // Camera preview
          if (_cameraController != null)
            MobileScanner(
              controller: _cameraController!,
              onDetect: _onDetect,
            ),

          // Overlay scanline
          _buildScanOverlay(),

          // Top bar
          Positioned(
            top: 0,
            left: 0,
            right: 0,
            child: Container(
              padding: EdgeInsets.only(
                top: MediaQuery.of(context).padding.top + 8,
                bottom: 12,
                left: 16,
                right: 16,
              ),
              color: const Color(0xFF0B2A4A).withAlpha(204),
              child: Row(
                children: [
                  Container(
                    width: 36,
                    height: 36,
                    decoration: BoxDecoration(
                      color: const Color(0xFFD4A843),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: const Icon(
                      Icons.qr_code_scanner,
                      color: Color(0xFF0B2A4A),
                      size: 20,
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'KADIN Scanner',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 16,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                        Text(
                          'Login: $_userName',
                          style: TextStyle(
                            color: Colors.white.withAlpha(153),
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ),
                  // Flash button
                  IconButton(
                    onPressed: _toggleFlash,
                    icon: const Icon(Icons.flash_on, color: Color(0xFFD4A843)),
                    tooltip: 'Flash',
                  ),
                  // Switch camera
                  IconButton(
                    onPressed: _switchCamera,
                    icon: const Icon(Icons.cameraswitch, color: Colors.white70),
                    tooltip: 'Ganti Kamera',
                  ),
                ],
              ),
            ),
          ),

          // Bottom bar
          Positioned(
            bottom: 0,
            left: 0,
            right: 0,
            child: Container(
              padding: EdgeInsets.only(
                bottom: MediaQuery.of(context).padding.bottom + 16,
                top: 16,
                left: 24,
                right: 24,
              ),
              color: const Color(0xFF0B2A4A).withAlpha(204),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  _buildBottomButton(
                    icon: Icons.history,
                    label: 'Riwayat',
                    badge: _scanHistory.isNotEmpty ? _scanHistory.length.toString() : null,
                    onTap: _showHistory,
                  ),
                  _buildBottomButton(
                    icon: Icons.settings,
                    label: 'Pengaturan',
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (_) => const SettingsScreen()),
                      );
                    },
                  ),
                  _buildBottomButton(
                    icon: Icons.logout,
                    label: 'Keluar',
                    color: const Color(0xFFEF4444),
                    onTap: _handleLogout,
                  ),
                ],
              ),
            ),
          ),

          // Processing indicator
          if (_isProcessing)
            Container(
              color: Colors.black54,
              child: const Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    CircularProgressIndicator(color: Color(0xFFD4A843)),
                    SizedBox(height: 16),
                    Text(
                      'Memverifikasi...',
                      style: TextStyle(color: Colors.white, fontSize: 16),
                    ),
                  ],
                ),
              ),
            ),
        ],
      ),
    );
  }

  Widget _buildBottomButton({
    required IconData icon,
    required String label,
    String? badge,
    Color color = const Color(0xFFD4A843),
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Stack(
            clipBehavior: Clip.none,
            children: [
              Icon(icon, color: color, size: 26),
              if (badge != null)
                Positioned(
                  right: -8,
                  top: -4,
                  child: Container(
                    padding: const EdgeInsets.symmetric(horizontal: 4, vertical: 1),
                    decoration: BoxDecoration(
                      color: const Color(0xFFEF4444),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Text(
                      badge,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 9,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ),
            ],
          ),
          const SizedBox(height: 4),
          Text(
            label,
            style: TextStyle(
              color: color.withAlpha(204),
              fontSize: 11,
            ),
          ),
        ],
      ),
    );
  }

  /// Overlay frame kotak scanner
  Widget _buildScanOverlay() {
    return LayoutBuilder(
      builder: (context, constraints) {
        final scanAreaSize = constraints.maxWidth * 0.7;
        final top = (constraints.maxHeight - scanAreaSize) / 2 - 20;
        final left = (constraints.maxWidth - scanAreaSize) / 2;

        return Stack(
          children: [
            // Dark overlay di luar kotak scan
            ColorFiltered(
              colorFilter: ColorFilter.mode(
                const Color(0xFF0B2A4A).withAlpha(178),
                BlendMode.srcOut,
              ),
              child: Stack(
                children: [
                  Container(
                    decoration: const BoxDecoration(
                      color: Colors.black,
                      backgroundBlendMode: BlendMode.dstOut,
                    ),
                  ),
                  Positioned(
                    top: top,
                    left: left,
                    child: Container(
                      width: scanAreaSize,
                      height: scanAreaSize,
                      decoration: BoxDecoration(
                        color: Colors.black,
                        borderRadius: BorderRadius.circular(4),
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // Corner brackets
            Positioned(
              top: top,
              left: left,
              child: _buildCorner(0),
            ),
            Positioned(
              top: top,
              right: left,
              child: _buildCorner(1),
            ),
            Positioned(
              bottom: constraints.maxHeight - top - scanAreaSize,
              left: left,
              child: _buildCorner(2),
            ),
            Positioned(
              bottom: constraints.maxHeight - top - scanAreaSize,
              right: left,
              child: _buildCorner(3),
            ),

            // Instruction text
            Positioned(
              bottom: constraints.maxHeight - top - scanAreaSize - 40,
              left: 0,
              right: 0,
              child: const Text(
                'Arahkan kamera ke QR Code peserta',
                textAlign: TextAlign.center,
                style: TextStyle(
                  color: Colors.white70,
                  fontSize: 14,
                ),
              ),
            ),
          ],
        );
      },
    );
  }

  /// Corner bracket untuk frame scanner
  Widget _buildCorner(int position) {
    const size = 24.0;
    const thickness = 3.0;
    const color = Color(0xFFD4A843);

    BorderSide side(bool show) =>
        show ? const BorderSide(color: color, width: thickness) : BorderSide.none;

    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        border: Border(
          top: side(position == 0 || position == 1),
          bottom: side(position == 2 || position == 3),
          left: side(position == 0 || position == 2),
          right: side(position == 1 || position == 3),
        ),
      ),
    );
  }
}
