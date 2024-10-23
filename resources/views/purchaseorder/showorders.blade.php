<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Purchase Orders List</h1>

    <!-- Table for listing purchase orders -->
    <table class="min-w-full bg-white border-collapse">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300">Order No</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Order Date</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Supplier Name</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Item Total</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Discount</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Net Amount</th>
                <th class="px-6 py-3 border-b-2 border-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchaseOrders as $order)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $order->order_no }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $order->order_date }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $order->supplier->name }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ number_format($order->item_total, 2) }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ number_format($order->discount, 2) }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ number_format($order->net_amount, 2) }}</td>
                    <td class="px-6 py-4 border-b border-gray-200 flex space-x-2">
                        <a href="" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('purchaseorder.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 border-b border-gray-200 text-center">No Purchase Orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $purchaseOrders->links() }}
    </div>
</div>
</x-app-layout>