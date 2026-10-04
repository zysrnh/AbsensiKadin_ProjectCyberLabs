<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'company',
        'position',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Konversi nomor HP/WA ke format internasional (628xxx)
     */
    public function getFormattedPhoneAttribute(): string
    {
        $raw = (string)($this->phone ?? '');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }
}
