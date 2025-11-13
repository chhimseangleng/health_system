<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Medicine extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'generic_name',
        'category',
        'strength',
        'unit',
        'form',
        'manufacturer',
        'description',
        'indications',
        'contraindications',
        'side_effects',
        'dosage_instructions',
        'storage_conditions',
        'expiry_date',
        'batch_number',
        'price',
        'stock_quantity',
        'minimum_stock',
        'is_active',
        'requires_prescription'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'float',
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
        'is_active' => 'boolean',
        'requires_prescription' => 'boolean'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock_quantity', '<=', 'minimum_stock');
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days));
    }

    // Accessors
    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'out of stock';
        } elseif ($this->stock_quantity <= $this->minimum_stock) {
            return 'low stock';
        } else {
            return 'in stock';
        }
    }

    public function getStockStatusColorAttribute()
    {
        return [
            'out of stock' => 'red',
            'low stock' => 'yellow',
            'in stock' => 'green'
        ][$this->stock_status] ?? 'gray';
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getDaysUntilExpiryAttribute()
    {
        return now()->diffInDays($this->expiry_date, false);
    }
}
