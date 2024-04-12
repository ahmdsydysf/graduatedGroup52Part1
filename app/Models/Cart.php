<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    // created  creating
    // updated updating
    // saved saving
    // retrieved

    protected static function booted()
    {
        static::observe(CartObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'not added yet'
        ]);
    }
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => 'not added yet'
        ]);
    }
}
