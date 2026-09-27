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
        'logo_image',
        'event_date',
        'location',
        'signer_name',
        'signer_position',
        'signature_image',
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

    public function getLogoBase64(): ?string
    {
        if ($this->logo_image && file_exists(public_path('storage/' . $this->logo_image))) {
            $path = public_path('storage/' . $this->logo_image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    public function getSignatureBase64(): ?string
    {
        if ($this->signature_image && file_exists(public_path('storage/' . $this->signature_image))) {
            $path = public_path('storage/' . $this->signature_image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }
}
