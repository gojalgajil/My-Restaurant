<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'image',
        'available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isMakanan()
    {
        return $this->category === 'makanan';
    }

    public function isMinuman()
    {
        return $this->category === 'minuman';
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function scopeMakanan($query)
    {
        return $query->where('category', 'makanan');
    }

    public function scopeMinuman($query)
    {
        return $query->where('category', 'minuman');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
