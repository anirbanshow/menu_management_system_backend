<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'name'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->with('children');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($menu) {
            $menu->children()->each(function ($child) {
                $child->delete();
            });
        });
    }
}
