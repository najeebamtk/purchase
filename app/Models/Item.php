<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_name', 
        'inventory_location', 
        'brand', 
        'category', 
        'supplier_id', 
        'stock_unit', 
        'unit_price', 
        'item_images', 
        'status'
    ];

    // Convert item_images field from JSON to array
    protected $casts = [
        'item_images' => 'array',
    ];

    // Relationship to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
