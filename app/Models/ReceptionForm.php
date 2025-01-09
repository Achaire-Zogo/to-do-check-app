<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceptionForm extends Model
{
    protected $fillable = [
        'project',
        'check_date',
        'stamp_number',
        'check_roadmap',
        'check_schemas',
        'check_etiquette',
        'receiver_email',
        'missing_parts',
        'unmounted_parts',
        'signature_performer',
        'signature_image',
        'signature_witness',
        'signature_reviewer',
        'pdf_path',
        'submitted_at'
    ];

    protected $casts = [
        'check_date' => 'date',
        'submitted_at' => 'datetime'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }
}
