import 'dart:ui';
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

class _ScannerScreenState extends State<ScannerScreen> with SingleTickerProviderStateMixin {
  MobileScannerController? _cameraController;
  bool _isProcessing = false;
  String _userName = 'Admin';
  final List<Map<String, dynamic>> _scanHistory = [];

  // Smooth Laser Scanner Animation
  late AnimationController _laserController;
  late Animation<double> _laserAnimation;

  @override
  void initState() {
    super.initState();
    _initCamera();
    _loadUserName();

    _laserController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 2200),
    )..repeat(reverse: true);

    _laserAnimation = Tween<double>(begin: 0.05, end: 0.95).animate(
      CurvedAnimation(parent: _laserController, curve: Curves.easeInOut),
    );
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
    _laserController.dispose();
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

    HapticFeedback.mediumImpact();

    final result = await ApiService.verifyScan(qrToken);

    if (!mounted) return;

    _showResultDialog(result);
  }

  /// Tampilkan dialog hasil scan (Glassmorphic)
  void _showResultDialog(Map<String, dynamic> result) {
    final status = result['status'] as String? ?? 'error';
    final message = result['message'] as String? ?? '';
    final participant = result['participant'] as Map<String, dynamic>?;

    Color accentColor;
    IconData iconData;
    String title;

    switch (status) {
      case 'success':
        accentColor = const Color(0xFF10B981);
        iconData = Icons.check_circle_outline;
        title = 'PRESENSI BERHASIL';
        break;
      case 'already_attended':
        accentColor = const Color(0xFFF59E0B);
        iconData = Icons.info_outline;
        title = 'SUDAH PERNAH HADIR';
        break;
      default:
        accentColor = const Color(0xFFEF4444);
        iconData = Icons.highlight_off;
        title = 'TIDAK TERDAFTAR';
    }

    _scanHistory.insert(0, {
      'status': status,
      'title': title,
      'participant': participant,
      'message': message,
      'time': DateTime.now().toIso8601String(),
    });

    if (_scanHistory.length > 50) {
      _scanHistory.removeRange(50, _scanHistory.length);
    }

    showGeneralDialog(
      context: context,
      barrierDismissible: true,
      barrierLabel: 'ResultDialog',
      transitionDuration: const Duration(milliseconds: 250),
      pageBuilder: (ctx, anim1, anim2) {
        return const SizedBox.shrink();
      },
      transitionBuilder: (ctx, anim1, anim2, child) {
        final curvedVal = Curves.easeOutBack.transform(anim1.value);
        return Transform.scale(
          scale: curvedVal,
          child: Opacity(
            opacity: anim1.value,
            child: Dialog(
              backgroundColor: Colors.transparent,
              elevation: 0,
              insetPadding: const EdgeInsets.symmetric(horizontal: 24),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(24),
                child: BackdropFilter(
                  filter: ImageFilter.blur(sigmaX: 20, sigmaY: 20),
                  child: Container(
                    padding: const EdgeInsets.all(24),
                    decoration: BoxDecoration(
                      color: const Color(0xFF0F172A).withValues(alpha: 0.85),
                      borderRadius: BorderRadius.circular(24),
                      border: Border.all(
                        color: accentColor.withValues(alpha: 0.4),
                        width: 1.5,
                      ),
                      boxShadow: [
                        BoxShadow(
                          color: accentColor.withValues(alpha: 0.25),
                          blurRadius: 30,
                          spreadRadius: -4,
                        ),
                      ],
                    ),
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        // Status Icon
                        Container(
                          width: 58,
                          height: 58,
                          decoration: BoxDecoration(
                            color: accentColor.withValues(alpha: 0.12),
                            shape: BoxShape.circle,
                            border: Border.all(color: accentColor.withValues(alpha: 0.3)),
                          ),
                          child: Icon(iconData, color: accentColor, size: 32),
                        ),
                        const SizedBox(height: 14),
                        Text(
                          title,
                          style: TextStyle(
                            color: accentColor,
                            fontSize: 14,
                            fontWeight: FontWeight.w800,
                            letterSpacing: 1.2,
                          ),
                        ),
                        const SizedBox(height: 16),

                        // Participant details
                        if (participant != null) ...[
                          Container(
                            width: double.infinity,
                            padding: const EdgeInsets.all(16),
                            decoration: BoxDecoration(
                              color: Colors.white.withValues(alpha: 0.04),
                              borderRadius: BorderRadius.circular(16),
                              border: Border.all(color: Colors.white.withValues(alpha: 0.08)),
                            ),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  participant['name'] ?? '-',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 16,
                                    fontWeight: FontWeight.w700,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  '${participant['company'] ?? '-'} • ${participant['position'] ?? '-'}',
                                  style: TextStyle(
                                    color: Colors.white.withValues(alpha: 0.65),
                                    fontSize: 12,
                                  ),
                                ),
                                const SizedBox(height: 12),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                                      decoration: BoxDecoration(
                                        color: accentColor.withValues(alpha: 0.15),
                                        borderRadius: BorderRadius.circular(8),
                                      ),
                                      child: Text(
                                        participant['time'] ?? 'Tercatat',
                                        style: TextStyle(
                                          color: accentColor,
                                          fontSize: 11,
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                    Text(
                                      participant['qr_token'] ?? '',
                                      style: TextStyle(
                                        color: Colors.white.withValues(alpha: 0.4),
                                        fontSize: 11,
                                        fontFamily: 'monospace',
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ] else ...[
                          Text(
                            _stripHtml(message),
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              color: Colors.white.withValues(alpha: 0.75),
                              fontSize: 13,
                              height: 1.4,
                            ),
                          ),
                        ],
                        const SizedBox(height: 22),

                        // Dismiss button
                        SizedBox(
                          width: double.infinity,
                          height: 44,
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.pop(ctx);
                              setState(() => _isProcessing = false);
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: accentColor,
                              foregroundColor: Colors.white,
                              elevation: 0,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(12),
                              ),
                            ),
                            child: const Text(
                              'LANJUT SCANNING',
                              style: TextStyle(
                                fontSize: 12,
                                fontWeight: FontWeight.w800,
                                letterSpacing: 0.8,
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
          ),
        );
      },
    ).then((_) {
      if (mounted) {
        setState(() => _isProcessing = false);
      }
    });
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
        backgroundColor: const Color(0xFF0F172A),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20),
          side: BorderSide(color: Colors.white.withValues(alpha: 0.1)),
        ),
        title: const Text('Keluar dari Akun', style: TextStyle(color: Colors.white, fontSize: 16, fontWeight: FontWeight.bold)),
        content: Text(
          'Yakin ingin logout dari scanner?',
          style: TextStyle(color: Colors.white.withValues(alpha: 0.7), fontSize: 13),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(ctx, false),
            child: Text('Batal', style: TextStyle(color: Colors.white.withValues(alpha: 0.6))),
          ),
          ElevatedButton(
            onPressed: () => Navigator.pop(ctx, true),
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFFEF4444),
              foregroundColor: Colors.white,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
            ),
            child: const Text('Keluar'),
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

  /// History Bottom Sheet (Glassmorphic)
  void _showHistory() {
    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.transparent,
      isScrollControlled: true,
      builder: (ctx) => DraggableScrollableSheet(
        initialChildSize: 0.65,
        maxChildSize: 0.92,
        minChildSize: 0.35,
        builder: (_, scrollController) => ClipRRect(
          borderRadius: const BorderRadius.vertical(top: Radius.circular(28)),
          child: BackdropFilter(
            filter: ImageFilter.blur(sigmaX: 20, sigmaY: 20),
            child: Container(
              color: const Color(0xFF090D16).withValues(alpha: 0.88),
              child: Column(
                children: [
                  // Handle bar
                  Container(
                    width: 38,
                    height: 4,
                    margin: const EdgeInsets.symmetric(vertical: 12),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.2),
                      borderRadius: BorderRadius.circular(2),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 4),
                    child: Row(
                      children: [
                        const Icon(Icons.history, color: Color(0xFF38BDF8), size: 20),
                        const SizedBox(width: 8),
                        const Text(
                          'Riwayat Presensi',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 16,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                        const Spacer(),
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                          decoration: BoxDecoration(
                            color: Colors.white.withValues(alpha: 0.06),
                            borderRadius: BorderRadius.circular(10),
                          ),
                          child: Text(
                            '${_scanHistory.length} data',
                            style: TextStyle(color: Colors.white.withValues(alpha: 0.6), fontSize: 11),
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 8),
                  Divider(color: Colors.white.withValues(alpha: 0.08), height: 1),
                  Expanded(
                    child: _scanHistory.isEmpty
                        ? Center(
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.qr_code_scanner, color: Colors.white.withValues(alpha: 0.2), size: 48),
                                const SizedBox(height: 12),
                                Text(
                                  'Belum ada riwayat pemindaian',
                                  style: TextStyle(color: Colors.white.withValues(alpha: 0.4), fontSize: 13),
                                ),
                              ],
                            ),
                          )
                        : ListView.separated(
                            controller: scrollController,
                            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                            itemCount: _scanHistory.length,
                            separatorBuilder: (_, __) => Divider(
                              color: Colors.white.withValues(alpha: 0.05),
                              height: 1,
                            ),
                            itemBuilder: (_, index) {
                              final item = _scanHistory[index];
                              final participant = item['participant'] as Map<String, dynamic>?;
                              final status = item['status'] as String;

                              Color dotColor;
                              switch (status) {
                                case 'success':
                                  dotColor = const Color(0xFF10B981);
                                  break;
                                case 'already_attended':
                                  dotColor = const Color(0xFFF59E0B);
                                  break;
                                default:
                                  dotColor = const Color(0xFFEF4444);
                              }

                              final time = DateTime.tryParse(item['time'] ?? '');
                              final timeStr = time != null
                                  ? '${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}:${time.second.toString().padLeft(2, '0')}'
                                  : '-';

                              return ListTile(
                                contentPadding: const EdgeInsets.symmetric(horizontal: 4, vertical: 2),
                                leading: Container(
                                  width: 8,
                                  height: 8,
                                  decoration: BoxDecoration(
                                    color: dotColor,
                                    shape: BoxShape.circle,
                                    boxShadow: [
                                      BoxShadow(color: dotColor.withValues(alpha: 0.6), blurRadius: 6),
                                    ],
                                  ),
                                ),
                                title: Text(
                                  participant?['name'] ?? item['title'] ?? '-',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 13,
                                    fontWeight: FontWeight.w600,
                                  ),
                                ),
                                subtitle: Text(
                                  participant != null
                                      ? '${participant['company'] ?? '-'} • ${participant['position'] ?? '-'}'
                                      : _stripHtml(item['message'] ?? ''),
                                  style: TextStyle(
                                    color: Colors.white.withValues(alpha: 0.55),
                                    fontSize: 11,
                                  ),
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                                trailing: Text(
                                  timeStr,
                                  style: TextStyle(
                                    color: Colors.white.withValues(alpha: 0.4),
                                    fontSize: 11,
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
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF090D16),
      body: Stack(
        children: [
          // 1. Live Camera Preview
          if (_cameraController != null)
            MobileScanner(
              controller: _cameraController!,
              onDetect: _onDetect,
            ),

          // 2. Futuristic Scan Overlay with Animated Laser Beam
          _buildScanOverlay(),

          // 3. Glassmorphic Top Bar (Clean floating Wonderful Orb Logo, No Border)
          Positioned(
            top: 0,
            left: 0,
            right: 0,
            child: ClipRRect(
              child: BackdropFilter(
                filter: ImageFilter.blur(sigmaX: 16, sigmaY: 16),
                child: Container(
                  padding: EdgeInsets.only(
                    top: MediaQuery.of(context).padding.top + 8,
                    bottom: 12,
                    left: 16,
                    right: 12,
                  ),
                  decoration: BoxDecoration(
                    color: const Color(0xFF0F172A).withValues(alpha: 0.75),
                    border: Border(
                      bottom: BorderSide(color: Colors.white.withValues(alpha: 0.08)),
                    ),
                  ),
                  child: Row(
                    children: [
                      // Clean Logo (No border)
                      Image.asset(
                        'assets/images/app_logo.png',
                        width: 32,
                        height: 32,
                        fit: BoxFit.contain,
                      ),
                      const SizedBox(width: 10),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Text(
                              'Wonderful Scanner',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 15,
                                fontWeight: FontWeight.w800,
                                letterSpacing: 0.3,
                              ),
                            ),
                            Text(
                              'Petugas: $_userName',
                              style: TextStyle(
                                color: Colors.white.withValues(alpha: 0.6),
                                fontSize: 11,
                              ),
                            ),
                          ],
                        ),
                      ),
                      // Flash Button
                      IconButton(
                        onPressed: _toggleFlash,
                        icon: const Icon(Icons.flash_on, color: Color(0xFF38BDF8), size: 20),
                        tooltip: 'Flash',
                      ),
                      // Switch Camera Button
                      IconButton(
                        onPressed: _switchCamera,
                        icon: Icon(Icons.cameraswitch, color: Colors.white.withValues(alpha: 0.75), size: 20),
                        tooltip: 'Ganti Kamera',
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),

          // 4. Glassmorphic Bottom Dock Bar
          Positioned(
            bottom: 24,
            left: 24,
            right: 24,
            child: ClipRRect(
              borderRadius: BorderRadius.circular(24),
              child: BackdropFilter(
                filter: ImageFilter.blur(sigmaX: 20, sigmaY: 20),
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                  decoration: BoxDecoration(
                    color: const Color(0xFF0F172A).withValues(alpha: 0.75),
                    borderRadius: BorderRadius.circular(24),
                    border: Border.all(color: Colors.white.withValues(alpha: 0.12)),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: 0.4),
                        blurRadius: 20,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceAround,
                    children: [
                      _buildBottomButton(
                        icon: Icons.history,
                        label: 'Riwayat',
                        badge: _scanHistory.isNotEmpty ? '${_scanHistory.length}' : null,
                        color: const Color(0xFF38BDF8),
                        onTap: _showHistory,
                      ),
                      _buildBottomButton(
                        icon: Icons.tune,
                        label: 'Server',
                        color: Colors.white.withValues(alpha: 0.8),
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
                        color: const Color(0xFFF87171),
                        onTap: _handleLogout,
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),

          // Processing Indicator
          if (_isProcessing)
            Container(
              color: Colors.black.withValues(alpha: 0.6),
              child: const Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    CircularProgressIndicator(
                      strokeWidth: 3,
                      color: Color(0xFF38BDF8),
                    ),
                    SizedBox(height: 16),
                    Text(
                      'Memverifikasi Tiket...',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 14,
                        fontWeight: FontWeight.w600,
                      ),
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
    Color color = Colors.white,
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      behavior: HitTestBehavior.opaque,
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Stack(
              clipBehavior: Clip.none,
              children: [
                Icon(icon, color: color, size: 22),
                if (badge != null)
                  Positioned(
                    right: -10,
                    top: -4,
                    child: Container(
                      padding: const EdgeInsets.symmetric(horizontal: 5, vertical: 1.5),
                      decoration: BoxDecoration(
                        color: const Color(0xFF2563EB),
                        borderRadius: BorderRadius.circular(10),
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
                color: color,
                fontSize: 11,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }

  /// Overlay frame scanner with smooth animated laser beam
  Widget _buildScanOverlay() {
    return LayoutBuilder(
      builder: (context, constraints) {
        final scanAreaSize = constraints.maxWidth * 0.72;
        final top = (constraints.maxHeight - scanAreaSize) / 2 - 24;
        final left = (constraints.maxWidth - scanAreaSize) / 2;

        return Stack(
          children: [
            // Dark vignette mask outside viewfinder
            ColorFiltered(
              colorFilter: ColorFilter.mode(
                const Color(0xFF090D16).withValues(alpha: 0.72),
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
                        borderRadius: BorderRadius.circular(18),
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // Subtle scan box border
            Positioned(
              top: top,
              left: left,
              child: Container(
                width: scanAreaSize,
                height: scanAreaSize,
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(18),
                  border: Border.all(
                    color: Colors.white.withValues(alpha: 0.15),
                    width: 1,
                  ),
                ),
              ),
            ),

            // 4 Minimalist HUD Corner Brackets
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

            // Smooth Animated Laser Scanning Beam
            AnimatedBuilder(
              animation: _laserAnimation,
              builder: (context, child) {
                final beamTop = top + (scanAreaSize * _laserAnimation.value);
                return Positioned(
                  top: beamTop,
                  left: left + 6,
                  right: left + 6,
                  child: Column(
                    children: [
                      // Gradient trail glow
                      Container(
                        height: 14,
                        decoration: BoxDecoration(
                          gradient: LinearGradient(
                            begin: Alignment.topCenter,
                            end: Alignment.bottomCenter,
                            colors: [
                              Colors.transparent,
                              const Color(0xFF38BDF8).withValues(alpha: 0.25),
                            ],
                          ),
                        ),
                      ),
                      // Core laser line
                      Container(
                        height: 2,
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(1),
                          gradient: const LinearGradient(
                            colors: [
                              Colors.transparent,
                              Color(0xFF38BDF8),
                              Color(0xFF67E8F9),
                              Color(0xFF38BDF8),
                              Colors.transparent,
                            ],
                          ),
                          boxShadow: [
                            BoxShadow(
                              color: const Color(0xFF38BDF8).withValues(alpha: 0.8),
                              blurRadius: 8,
                              spreadRadius: 1,
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                );
              },
            ),

            // Instruction Text
            Positioned(
              bottom: constraints.maxHeight - top - scanAreaSize - 44,
              left: 0,
              right: 0,
              child: Center(
                child: Container(
                  padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
                  decoration: BoxDecoration(
                    color: const Color(0xFF0F172A).withValues(alpha: 0.7),
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: Colors.white.withValues(alpha: 0.1)),
                  ),
                  child: Text(
                    'Arahkan kamera ke QR Code tiket peserta',
                    style: TextStyle(
                      color: Colors.white.withValues(alpha: 0.8),
                      fontSize: 12,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),
              ),
            ),
          ],
        );
      },
    );
  }

  /// Modern corner bracket untuk frame scanner
  Widget _buildCorner(int position) {
    const size = 20.0;
    const thickness = 2.5;
    const color = Color(0xFF38BDF8);

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
