<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total_amount',
        'tax_amount',
        'final_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_items')
            ->withPivot(['quantity', 'price', 'subtotal', 'notes'])
            ->withTimestamps();
    }

    public function isOpen()
    {
        return $this->status === 'open';
    }

    public function isClosed()
    {
        return $this->status === 'closed';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function calculateTotal()
    {
        $this->total_amount = $this->orderItems->sum('subtotal');
        $this->tax_amount = $this->total_amount * 0.1; // 10% tax
        $this->final_amount = $this->total_amount + $this->tax_amount;
        $this->save();
    }

    public function closeOrder()
    {
        $this->status = 'closed';
        $this->calculateTotal();
        $this->table->markAsAvailable();
        $this->save();
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->save();
    }
}
