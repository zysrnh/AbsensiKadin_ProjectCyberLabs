<?php

namespace App\Services;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    /**
     * Parse template pesan dengan data peserta
     */
    public static function parseTemplate(string $template, Participant $participant): string
    {
        $replacements = [
            '{nama}' => $participant->name,
            '{instansi}' => $participant->company ?? '-',
            '{jabatan}' => $participant->position ?? '-',
            '{kode_tiket}' => $participant->qr_token,
            '{link_tiket}' => route('participants.card', $participant->qr_token),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    /**
     * Kirim pesan WhatsApp via Twilio REST API
     */
    public static function send(string $toPhone, string $message, ?string $mediaUrl = null): array
    {
        $sid = Setting::get('twilio_sid') ?: env('TWILIO_SID');
        $token = Setting::get('twilio_token') ?: env('TWILIO_AUTH_TOKEN');
        $from = Setting::get('twilio_from') ?: env('TWILIO_WHATSAPP_FROM', '+14155238886');

        if (!$sid || !$token) {
            return [
                'success' => false,
                'message' => 'Twilio SID atau Auth Token belum dikonfigurasi di Pengaturan WA.',
            ];
        }

        // Format nomor target ke format WhatsApp Twilio (whatsapp:+628xxx)
        $cleanPhone = preg_replace('/[^0-9]/', '', $toPhone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        } elseif (str_starts_with($cleanPhone, '8')) {
            $cleanPhone = '62' . $cleanPhone;
        }

        $to = "whatsapp:+" . $cleanPhone;
        $fromNumber = str_starts_with($from, 'whatsapp:') ? $from : "whatsapp:" . (str_starts_with($from, '+') ? $from : "+{$from}");

        $endpoint = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        $postData = [
            'From' => $fromNumber,
            'To' => $to,
            'Body' => $message,
        ];

        // Jika ada lampiran gambar QR
        if ($mediaUrl) {
            $postData['MediaUrl'] = $mediaUrl;
        }

        try {
            $response = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->timeout(15)
                ->post($endpoint, $postData);

            $result = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim ke antrean Twilio!',
                    'sid' => $result['sid'] ?? null,
                    'status' => $result['status'] ?? 'queued',
                ];
            } else {
                $errorMsg = $result['message'] ?? 'Gagal mengirim pesan Twilio.';
                Log::error("Twilio WA Error: " . json_encode($result));
                return [
                    'success' => false,
                    'message' => "Twilio Error ({$response->status()}): {$errorMsg}",
                    'raw' => $result,
                ];
            }
        } catch (\Throwable $e) {
            Log::error("Twilio Exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi ke server Twilio: ' . $e->getMessage(),
            ];
        }
    }
}
