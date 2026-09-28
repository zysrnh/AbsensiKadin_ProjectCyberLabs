import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'screens/login_screen.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();

  // Lock orientasi portrait
  SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown,
  ]);

  // System UI overlay style
  SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
    statusBarColor: Color(0xFF0B2A4A),
    statusBarIconBrightness: Brightness.light,
    systemNavigationBarColor: Color(0xFF0B2A4A),
    systemNavigationBarIconBrightness: Brightness.light,
  ));

  runApp(const KadinScannerApp());
}

class KadinScannerApp extends StatelessWidget {
  const KadinScannerApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'KADIN Scanner',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        useMaterial3: true,
        colorScheme: const ColorScheme.dark(
          primary: Color(0xFFD4A843),
          secondary: Color(0xFFD4A843),
          surface: Color(0xFF0B2A4A),
          onPrimary: Color(0xFF0B2A4A),
          onSecondary: Color(0xFF0B2A4A),
          onSurface: Colors.white,
        ),
        scaffoldBackgroundColor: const Color(0xFF0B2A4A),
        appBarTheme: const AppBarTheme(
          backgroundColor: Color(0xFF0B2A4A),
          foregroundColor: Colors.white,
          elevation: 0,
        ),
        fontFamily: 'Roboto',
      ),
      home: const LoginScreen(),
    );
  }
}
