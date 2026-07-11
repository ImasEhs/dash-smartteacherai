<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    protected function image(): Attribute
    {
         return Attribute::make(
            get: function ($image) {
                if (!$image || trim($image) === '') {
                    return null;
                }

                $path = "categories/{$image}";
                return Storage::disk('public')->exists($path)
                    ? asset("storage/{$path}")
                    : null;
            },
        );
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
