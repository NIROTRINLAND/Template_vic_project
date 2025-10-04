<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    // Champs assignables en masse
    protected $fillable = [
        'name',
        'slug',
        'folder',
        'price',
        'is_paid',
        'is_public',
        'screenshot',
        'preview_link',
        'creator_id',
        'description',
        'download'
    ];

    /**
     * Génère automatiquement le slug à partir du nom si besoin
     */
    public static function booted()
    {
        static::creating(function ($template) {
            if (empty($template->slug) && !empty($template->name)) {
                $template->slug = \Str::slug($template->name);
            }
        });
    }

    /**
     * Relation avec l'utilisateur créateur
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
