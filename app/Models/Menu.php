<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'title',
        'content',
        'is_sub',
        'parent',
        'slug'
    ];

    public function pages() : HasMany
    {
        return $this->hasMany(Page::class);
    }
}