<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function FnViewList(){
        $items = Item::with('supplier')->paginate(10); 
        $suppliers = Supplier::where('status', 'Active')->get(); 
        return view('item/list', compact('items', 'suppliers'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'inventory_location' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock_unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'item_images' => 'nullable',
            'status' => 'required|in:enabled,disabled',
        ]);

        // Handle image uploads if present
        if ($request->hasFile('item_images')) {
            $images = [];
            foreach ($request->file('item_images') as $image) {
                $path = $image->store('items', 'public');
                $images[] = $path;
            }
            $validated['item_images'] = json_encode($images);
        }

        Item::create($validated);

        return redirect('item/list')->with('success', 'Item created successfully.');
    }
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect('item/list')->with('success', 'item deleted successfully.');
    }

}
