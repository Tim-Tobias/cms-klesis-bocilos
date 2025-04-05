<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    use HasFactory;

    protected $table = 'content';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'content',
        'category',
        'active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
