<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
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
        'slug',
        'menu_id'
    ];

    public function menu() : BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}