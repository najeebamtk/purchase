<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',  // Reference to the PurchaseOrder
        'item_id',            // Reference to the Item being ordered
        'order_qty',          // Quantity of the item ordered
        'unit_price',         // Price per unit of the item
        'packing_unit',       // Optional: How the item is packed or sold (e.g., box, piece)
        'item_amount',        // Total price for the item (order_qty * unit_price)
        'discount',           // Discount on the item
        'net_amount',         // Final amount after discount (item_amount - discount)
    ];

    // Relationship to PurchaseOrder
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    // Relationship to Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
?>
