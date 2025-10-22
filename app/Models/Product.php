<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $name
 * @property float $discount
 * @property string $description
 * @property string $image
 * @property string $slug
 * @property float $price
 */

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable =
        [
            'user_id',
            'category_id',
            'name',
            'description',
            'image',
            'slug',
            'price',
            'discount'
        ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->HasMany(CartItem::class);
    }

    public function orderItems(): Hasmany
    {
        return $this->HasMany(OrderItem::class);
    }
}
