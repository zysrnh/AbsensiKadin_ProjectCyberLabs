import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static const String _baseUrlKey = 'base_url';
  static const String _defaultBaseUrl = 'http://127.0.0.1:8000';

  /// Ambil base URL dari SharedPreferences
  static Future<String> getBaseUrl() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_baseUrlKey) ?? _defaultBaseUrl;
  }

  /// Simpan base URL ke SharedPreferences
  static Future<void> setBaseUrl(String url) async {
    final prefs = await SharedPreferences.getInstance();
    // Hapus trailing slash
    if (url.endsWith('/')) {
      url = url.substring(0, url.length - 1);
    }
    await prefs.setString(_baseUrlKey, url);
  }

  /// Login menggunakan akun admin yang sudah ada di web
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final baseUrl = await getBaseUrl();
    final uri = Uri.parse('$baseUrl/api/login');

    try {
      final response = await http.post(
        uri,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      ).timeout(const Duration(seconds: 10));

      final data = jsonDecode(response.body) as Map<String, dynamic>;

      if (response.statusCode == 200 && data['success'] == true) {
        // Simpan data login ke SharedPreferences
        final prefs = await SharedPreferences.getInstance();
        await prefs.setBool('is_logged_in', true);
        await prefs.setString('user_name', data['user']['name'] ?? '');
        await prefs.setString('user_email', data['user']['email'] ?? '');
        return data;
      } else {
        return {
          'success': false,
          'message': data['message'] ?? 'Login gagal.',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'message': 'Tidak dapat terhubung ke server.\nPastikan URL server benar dan server aktif.\n\nError: $e',
      };
    }
  }

  /// Logout — hapus data lokal
  static Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('is_logged_in', false);
    await prefs.remove('user_name');
    await prefs.remove('user_email');
  }

  /// Cek apakah user sudah login
  static Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getBool('is_logged_in') ?? false;
  }

  /// Ambil nama user yang login
  static Future<String> getUserName() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('user_name') ?? 'Admin';
  }

  /// Verifikasi QR Code scan ke backend
  static Future<Map<String, dynamic>> verifyScan(String qrToken) async {
    final baseUrl = await getBaseUrl();
    final uri = Uri.parse('$baseUrl/api/scan/verify');

    try {
      final response = await http.post(
        uri,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: jsonEncode({
          'qr_token': qrToken,
        }),
      ).timeout(const Duration(seconds: 10));

      final data = jsonDecode(response.body) as Map<String, dynamic>;

      // Tentukan status berdasarkan HTTP code
      if (response.statusCode == 200) {
        return {
          'success': true,
          'status': 'success',
          'message': data['message'] ?? 'Absensi berhasil.',
          'participant': data['participant'],
        };
      } else if (response.statusCode == 409) {
        return {
          'success': false,
          'status': 'already_attended',
          'message': data['message'] ?? 'Peserta sudah absen.',
          'participant': data['participant'],
        };
      } else if (response.statusCode == 404) {
        return {
          'success': false,
          'status': 'not_found',
          'message': data['message'] ?? 'QR Code tidak terdaftar.',
        };
      } else {
        return {
          'success': false,
          'status': 'error',
          'message': data['message'] ?? 'Terjadi kesalahan server.',
        };
      }
    } catch (e) {
      return {
        'success': false,
        'status': 'error',
        'message': 'Gagal terhubung ke server.\nPastikan perangkat dan server dalam jaringan yang sama.\n\nError: $e',
      };
    }
  }
}
