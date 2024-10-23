<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseOrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected $purchaseOrder;

    public function __construct($purchaseOrderId)
    {
        $this->purchaseOrder = PurchaseOrder::with('items')->findOrFail($purchaseOrderId);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->purchaseOrder->items;
    }

    /**
     * Define the headings for the Excel sheet
     */
    public function headings(): array
    {
        return [
            'Item No',
            'Item Name',
            'Stock Unit',
            'Unit Price',
            'Packing Unit',
            'Order Qty',
            'Item Amount',
            'Discount',
            'Net Amount',
        ];
    }

    /**
     * Map each row of the Purchase Order Item to a format suitable for Excel
     */
    public function map($item): array
    {
        return [
            $item->item_id,
            $item->item->name, // Assuming there's a relation between PurchaseOrderItem and Item
            $item->stock_unit,
            $item->unit_price,
            $item->packing_unit,
            $item->order_qty,
            $item->item_amount,
            $item->discount,
            $item->net_amount,
        ];
    }
}
