<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'organizer',
        'event_date',
        'location',
        'signer_name',
        'signer_position',
        'certificate_prefix',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function generateNextCertificateNumber(): string
    {
        $count = $this->certificates()->count() + 1;
        $year = $this->event_date ? $this->event_date->format('Y') : date('Y');
        $prefix = $this->certificate_prefix ?: 'SERT';
        return sprintf('%s/%s/%04d', $prefix, $year, $count);
    }
}
