<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_medias';

    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'id',
        'name',
        'description',
        'path',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
