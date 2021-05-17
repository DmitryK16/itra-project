<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property array $list_bonus
 * @property string $small_descriptions
 * @property string $video
 * @property string $img
 * @property float $required_amount
 * @property float $deposited_amount
 * @property int $user_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subject $subject
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CompanyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDepositedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereListBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereRequiredAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSmallDescriptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereVideo($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Company[] $companies
 * @property-read int|null $companies_count
 */
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
        'required_amount',
        'deposited_amount',
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

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
