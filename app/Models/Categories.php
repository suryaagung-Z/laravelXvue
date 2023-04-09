<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';

    // protected $guarded = ['id'];

    protected $fillable = [
        'category_name'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'category_id', 'id');
    }
}
