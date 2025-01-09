<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptionItem extends Model
{
    protected $fillable = [
        'reception_form_id',
        'category',
        'name',
        'description',
        'status',
        'comment'
    ];

    public function form()
    {
        return $this->belongsTo(ReceptionForm::class, 'reception_form_id');
    }
}
