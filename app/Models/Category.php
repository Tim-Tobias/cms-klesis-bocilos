<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'name',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_category');
    }
}
