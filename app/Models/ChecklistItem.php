<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'is_present',
        'comment',
        'user_name',
        'recipient_email'
    ];

    protected $casts = [
        'is_present' => 'boolean',
    ];

    protected $attributes = [
        'comment' => null,
    ];
}
