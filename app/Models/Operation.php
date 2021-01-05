<?php

namespace App\Models;

use App\Casts\TypeCast;
use Database\Factories\OperationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static OperationFactory factory()
 */
class Operation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => TypeCast::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
