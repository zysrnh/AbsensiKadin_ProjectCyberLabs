<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'position',
        'phone',
        'email',
        'qr_token',
        'status',
        'attended_at',
        'notes',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
    ];

    /**
     * Konversi nomor HP/WA ke format internasional (628xxx)
     */
    public function getFormattedPhoneAttribute(): string
    {
        $raw = (string)($this->phone ?? $this->phone_number ?? '');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }

    /**
     * Link WhatsApp blast lengkap dengan template pesan undangan & QR ticket
     */
    public function getWhatsAppBlastUrlAttribute(): string
    {
        $phone = $this->formatted_phone;
        $ticketUrl = route('participants.card', $this->qr_token);

        $text = "Halo Bapak/Ibu *{$this->name}*,\n\n"
              . "Terima kasih telah melakukan registrasi kegiatan Kadin 2026.\n\n"
              . "Berikut tiket QR Code Kehadiran Anda:\n"
              . "🔗 {$ticketUrl}\n\n"
              . "Kode Tiket: *{$this->qr_token}*\n\n"
              . "Silakan tunjukkan QR Code pada tautan di atas kepada petugas saat memasuki lokasi acara.\n\n"
              . "Salam hangat,\n*Panitia Kadin 2026*";

        return "https://wa.me/{$phone}?text=" . rawurlencode($text);
    }
}


