import 'package:flutter_test/flutter_test.dart';
import 'package:kadin_scanner/main.dart';

void main() {
  testWidgets('App renders login screen', (WidgetTester tester) async {
    await tester.pumpWidget(const KadinScannerApp());
    // Verify login screen loads
    expect(find.text('Wonderful Scanner'), findsOneWidget);
    expect(find.text('MASUK'), findsOneWidget);
  });
}
