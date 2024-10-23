<x-app-layout>

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Purchase Order Details</h1>

    <div class="bg-white shadow-md rounded p-4 mb-4">
        <h2 class="text-lg font-semibold">Order Information</h2>
        <p><strong>Order No:</strong> {{ $purchaseOrder->order_no }}</p>
        <p><strong>Order Date:</strong> {{ $purchaseOrder->order_date->format('d-m-Y') }}</p>
        <p><strong>Supplier Name:</strong> {{ $purchaseOrder->supplier->name }}</p>
    </div>

    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-lg font-semibold">Items List</h2>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Item No</th>
                    <th class="px-4 py-2 border">Item Name</th>
                    <th class="px-4 py-2 border">Stock Unit</th>
                    <th class="px-4 py-2 border">Unit Price</th>
                    <th class="px-4 py-2 border">Packing Unit</th>
                    <th class="px-4 py-2 border">Order Qty</th>
                    <th class="px-4 py-2 border">Item Amount</th>
                    <th class="px-4 py-2 border">Discount</th>
                    <th class="px-4 py-2 border">Net Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->items as $item)
                    <tr>
                        <td class="px-4 py-2 border">{{ $item->id }}</td>
                        <td class="px-4 py-2 border">{{ $item->name }}</td>
                        <td class="px-4 py-2 border">{{ $item->stock_unit }}</td>
                        <td class="px-4 py-2 border">{{ $item->unit_price }}</td>
                        <td class="px-4 py-2 border">{{ $item->packing_unit }}</td>
                        <td class="px-4 py-2 border">{{ $item->order_qty }}</td>
                        <td class="px-4 py-2 border">{{ $item->item_amount }}</td>
                        <td class="px-4 py-2 border">{{ $item->discount }}</td>
                        <td class="px-4 py-2 border">{{ $item->net_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('purchaseorder.export', $purchaseOrder->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Export to Excel
        </a>
    </div>
</div>
</x-app-layout>
