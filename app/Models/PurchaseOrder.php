<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no', 
        'order_date', 
        'supplier_id', 
        'item_total', 
        'discount', 
        'net_amount'
    ];

    // Relationship to Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
        // Relationship to Purchase Order Items
        public function items()
        {
            return $this->hasMany(PurchaseOrderItem::class);
        }
}
