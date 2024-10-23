<x-app-layout>
    <div class="flex justify-end" >
<a href="{{ url('purchaseorder/showorders') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded right">
   Show Orders
</a> 
</div>   

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Create Purchase Order</h1>

    <!-- Purchase Order Form -->
    <form method="POST" action="{{ url('purchaseorder/list') }}" id="purchaseOrderForm">
        @csrf

        <!-- Order No (Auto-generated) -->
        <div class="mb-4">
            <label for="order_no" class="block text-sm font-medium text-gray-700">Order No</label>
            <input type="text" id="order_no" name="order_no" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly value="{{ $nextOrderNo }}">
        </div>

        <!-- Order Date (Date Picker) -->
        <div class="mb-4">
            <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
            <input type="date" id="order_date" name="order_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ now()->format('Y-m-d') }}">
        </div>

        <!-- Supplier Name (Dropdown) -->
        <div class="mb-4">
            <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier Name</label>
            <select id="supplier_id" name="supplier_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Select Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Item List -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Items</h2>
            <table class="w-full table-auto border-collapse" id="itemsTable">
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
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border">
                            <input type="text" name="items[0][item_no]" class="border rounded w-full" readonly value="1">
                        </td>
                        <td class="px-4 py-2 border">
                            <select name="items[0][item_id]" class="border rounded w-full">
                                <option value="">-- Select Item --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" name="items[0][stock_unit]" class="border rounded w-full" />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="number" name="items[0][unit_price]" class="border rounded w-full" onchange="calculateTotals()" />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" name="items[0][packing_unit]" class="border rounded w-full" />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="number" name="items[0][order_qty]" class="border rounded w-full" onchange="calculateTotals()" />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" name="items[0][item_amount]" class="border rounded w-full" readonly />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="number" name="items[0][discount]" class="border rounded w-full" onchange="calculateTotals()" />
                        </td>
                        <td class="px-4 py-2 border">
                            <input type="text" name="items[0][net_amount]" class="border rounded w-full" readonly />
                        </td>
                        <td class="px-4 py-2 border">
                            <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="removeItem(this)">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" onclick="addItem()">Add Item</button>
        </div>

        <!-- Item Total, Discount, Net Amount (Readonly fields) -->
        <div class="mb-4 grid grid-cols-3 gap-4">
            <div>
                <label for="item_total" class="block text-sm font-medium text-gray-700">Item Total</label>
                <input type="text" id="item_total" name="item_total" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly />
            </div>
            <div>
                <label for="total_discount" class="block text-sm font-medium text-gray-700">Discount</label>
                <input type="text" id="total_discount" name="total_discount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly />
            </div>
            <div>
                <label for="net_amount" class="block text-sm font-medium text-gray-700">Net Amount</label>
                <input type="text" id="net_amount" name="net_amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Submit Purchase Order</button>
        </div>
    </form>
</div>

<script>
    // JavaScript to dynamically add/remove items and calculate totals
    let itemIndex = 1; // Initialize the item index counter

    // Function to add a new item row
    function addItem() {
        let table = document.getElementById('itemsTable').getElementsByTagName('tbody')[0];
        let newRow = table.insertRow();
        newRow.innerHTML = `
            <td class="px-4 py-2 border">
                <input type="text" name="items[${itemIndex}][item_no]" class="border rounded w-full" readonly value="${itemIndex + 1}">
            </td>
            <td class="px-4 py-2 border">
                <select name="items[${itemIndex}][item_id]" class="border rounded w-full">
                    <option value="">-- Select Item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="items[${itemIndex}][stock_unit]" class="border rounded w-full" />
            </td>
            <td class="px-4 py-2 border">
                <input type="number" name="items[${itemIndex}][unit_price]" class="border rounded w-full" onchange="calculateTotals()" />
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="items[${itemIndex}][packing_unit]" class="border rounded w-full" />
            </td>
            <td class="px-4 py-2 border">
                <input type="number" name="items[${itemIndex}][order_qty]" class="border rounded w-full" onchange="calculateTotals()" />
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="items[${itemIndex}][item_amount]" class="border rounded w-full" readonly />
            </td>
            <td class="px-4 py-2 border">
                <input type="number" name="items[${itemIndex}][discount]" class="border rounded w-full" onchange="calculateTotals()" />
            </td>
            <td class="px-4 py-2 border">
                <input type="text" name="items[${itemIndex}][net_amount]" class="border rounded w-full" readonly />
            </td>
            <td class="px-4 py-2 border">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="removeItem(this)">Remove</button>
            </td>
        `;
        itemIndex++;
    }

    // Function to remove an item row
    function removeItem(element) {
        // Remove the row from the table
        let row = element.parentNode.parentNode;
        row.parentNode.removeChild(row);
        
        // Reassign the item indices to avoid errors
        reassignItemIndices();

        // Recalculate totals after an item is removed
        calculateTotals();
    }

    // Function to reassign item indices after an item is removed
    function reassignItemIndices() {
        let rows = document.querySelectorAll('#itemsTable tbody tr');
        itemIndex = 0; // Reset the item index

        rows.forEach((row, index) => {
            row.querySelector('input[name^="items["]').name = `items[${index}][item_no]`;
            row.querySelector('select[name^="items["]').name = `items[${index}][item_id]`;
            row.querySelector('input[name^="items["][name*="stock_unit"]').name = `items[${index}][stock_unit]`;
            row.querySelector('input[name^="items["][name*="unit_price"]').name = `items[${index}][unit_price]`;
            row.querySelector('input[name^="items["][name*="packing_unit"]').name = `items[${index}][packing_unit]`;
            row.querySelector('input[name^="items["][name*="order_qty"]').name = `items[${index}][order_qty]`;
            row.querySelector('input[name^="items["][name*="item_amount"]').name = `items[${index}][item_amount]`;
            row.querySelector('input[name^="items["][name*="discount"]').name = `items[${index}][discount]`;
            row.querySelector('input[name^="items["][name*="net_amount"]').name = `items[${index}][net_amount]`;
            
            // Update the item number display
            row.querySelector('input[name^="items["][name*="item_no"]').value = index + 1;
        });
    }

    function calculateTotals() {
        let itemTotal = 0;
        let discountTotal = 0;
        let netAmountTotal = 0;
        let rows = document.querySelectorAll('#itemsTable tbody tr');

        rows.forEach((row, index) => {
            let unitPrice = parseFloat(row.querySelector(`input[name="items[${index}][unit_price]"]`).value) || 0;
            let orderQty = parseInt(row.querySelector(`input[name="items[${index}][order_qty]"]`).value) || 0;
            let discount = parseFloat(row.querySelector(`input[name="items[${index}][discount]"]`).value) || 0;

            let itemAmount = unitPrice * orderQty;
            let netAmount = itemAmount - discount;

            row.querySelector(`input[name="items[${index}][item_amount]"]`).value = itemAmount.toFixed(2);
            row.querySelector(`input[name="items[${index}][net_amount]"]`).value = netAmount.toFixed(2);

            itemTotal += itemAmount;
            discountTotal += discount;
            netAmountTotal += netAmount;
        });

        document.getElementById('item_total').value = itemTotal.toFixed(2);
        document.getElementById('total_discount').value = discountTotal.toFixed(2);
        document.getElementById('net_amount').value = netAmountTotal.toFixed(2);
    }
</script>
</x-app-layout>