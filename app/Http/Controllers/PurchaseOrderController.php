<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Item;
use App\Exports\PurchaseOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseOrderController extends Controller
{
    public function create()
    {
        // Fetch all active suppliers for dropdown
        $suppliers = Supplier::where('status', 'Active')->get();

        // Fetch all active items for line items
        $items = Item::where('status', 'enabled')->get();
        $lastOrder = PurchaseOrder::latest('id')->first();
        $nextOrderNo = $lastOrder ? $lastOrder->id + 1 : 1;
        return view('purchaseorder/list', compact('suppliers', 'items','nextOrderNo'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.order_qty' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        // Calculate total and discount
        $itemTotal = 0;
        $totalDiscount = 0;
        
        foreach ($request->items as $lineItem) {
            $itemAmount = $lineItem['order_qty'] * $lineItem['unit_price'];
            $discount = $lineItem['discount'] ?? 0;
            $netAmount = $itemAmount - $discount;

            $itemTotal += $netAmount;
            $totalDiscount += $discount;
        }

        $netAmount = $itemTotal - $totalDiscount;

        // Store Purchase Order
        $purchaseOrder = PurchaseOrder::create([
            'order_no' => 'PO' . time(),  // Generate a unique order number
            'order_date' => $request->order_date,
            'supplier_id' => $request->supplier_id,
            'item_total' => $itemTotal,
            'discount' => $totalDiscount,
            'net_amount' => $netAmount,
        ]);

        // Store Purchase Order Items
        foreach ($request->items as $lineItem) {
            $purchaseOrder->items()->create([
                'item_id' => $lineItem['item_id'],
                'order_qty' => $lineItem['order_qty'],
                'unit_price' => $lineItem['unit_price'],
                'packing_unit' => $lineItem['packing_unit'] ?? null,
                'item_amount' => $lineItem['order_qty'] * $lineItem['unit_price'],
                'discount' => $lineItem['discount'] ?? 0,
                'net_amount' => ($lineItem['order_qty'] * $lineItem['unit_price']) - ($lineItem['discount'] ?? 0),
            ]);
        }

        return redirect()->route('purchaseorder.list')->with('success', 'Purchase Order created successfully.');
    }

    public function showorders()
    {
    // Fetch all purchase orders with their supplier data
    $purchaseOrders = PurchaseOrder::with('supplier')->paginate(10); // Modify pagination as needed

    return view('purchaseorder/showorders', compact('purchaseOrders'));
    }

    public function destroy($id){
    $purchaseOrder = PurchaseOrder::findOrFail($id);
    $purchaseOrder->delete();
    return redirect()->route('purchaseorder/showorders')->with('success', 'Purchase Order deleted successfully.');
    }

    public function export($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        return Excel::download(new PurchaseOrderExport($id), 'purchaseorder_'.$purchaseOrder->order_no.'.xlsx');
    }
    public function show($id){
    $purchaseOrder = PurchaseOrder::with(['supplier', 'items'])->findOrFail($id);
    
    return view('purchaseorder.show', compact('purchaseOrder'));
    }
}


