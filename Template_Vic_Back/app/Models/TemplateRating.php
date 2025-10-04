<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateRating extends Model
{
    use HasFactory;

    protected $table = 'template_ratings';

    public $timestamps = false; // On gère seulement 'created_at'

    protected $fillable = [
        'template_id',
        'rating',
    ];

    // Relation vers le template
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
