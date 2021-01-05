<?php

namespace App\Models;

use App\Casts\TypeCast;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static CategoryFactory factory()
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => TypeCast::class
    ];
}
