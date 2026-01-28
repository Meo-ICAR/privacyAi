<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Normativa extends Model
{
    protected $fillable = [
        'section',
        'control_area',
        'question_en',
        'question_it',
        'iso_27001_2022_reference',
        'gdpr_reference',
        'answer',
        'evidence_required',
        'notes',
        'weight',
        'score',
        'risk_level',
    ];
}
