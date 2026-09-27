<?php

namespace App\Models;

use chillerlan\QRCode\QRCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'certificate_number',
        'recipient_name',
        'recipient_email',
        'role',
        'description',
        'issue_date',
        'verification_token',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($certificate) {
            if (empty($certificate->verification_token)) {
                $certificate->verification_token = Str::random(40);
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getVerificationUrl(): string
    {
        return route('verify.show', ['token' => $this->verification_token]);
    }

    public function getQrCode(): string
    {
        return (new QRCode())->render($this->getVerificationUrl());
    }
}
