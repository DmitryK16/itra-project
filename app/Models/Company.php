<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'list_bonus',
        'small_descriptions',
        'video',
        'img',
        'amount',
        'user_id',
        'subject_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'list_bonus' => 'array'
    ];

    /**
     * @var string[]
     */
    protected $attributes = [
        'list_bonus' => '{}'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
