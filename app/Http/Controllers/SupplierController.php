<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function FnViewList(){
        $suppliers = Supplier::all();
       
        return view ('supplier/list',compact('suppliers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tax_no' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'status' => 'required|string|in:Active,Inactive,Blocked',
        ]);
        $id = $request->get('id');
        if ($id) {
            $supplier = Supplier::find($id);
            $supplier->update($request->all(), ['id' => $id]);
        } else {
            $supplier = Supplier::create($request->all());
        }
        return response()->json($supplier);
    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect('supplier/list')->with('success', 'Supplier deleted successfully.');
    }
}
