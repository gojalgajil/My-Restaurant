<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected $fillable = [
        'number',
        'status',
        'capacity',
    ];

    protected $casts = [
        'status' => 'string',
        'capacity' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    public function markAsAvailable()
    {
        $this->status = 'available';
        $this->save();
    }

    public function markAsOccupied()
    {
        $this->status = 'occupied';
        $this->save();
    }
}
