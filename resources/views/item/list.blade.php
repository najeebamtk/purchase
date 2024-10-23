<x-app-layout>

    <h1 class="text-2xl font-bold mb-4">Items</h1>
    <div class="flex justify-start" >
    <!-- Button to trigger modal -->
    <button type="button" class="bg-blue-500 text-blue px-4 py-2 rounded mb-4" modal-toggle="addItemModal">
        Add Item
    </button>
    </div>

 
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-md">
            <thead>
                  <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Item No</th>
                <th class="px-4 py-2 text-left">Item Name</th>
                <th class="px-4 py-2 text-left">Brand</th>
                <th class="px-4 py-2 text-left">Category</th>
                <th class="px-4 py-2 text-left">Supplier</th>
                <th class="px-4 py-2 text-left">Stock Unit</th>
                <th class="px-4 py-2 text-left">Unit Price</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        
            </thead>
            <tbody id="item-list">
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->supplier->name }}</td>
                    <td>{{ $item->stock_unit }}</td>
                    <td>{{ $item->unit_price}}</td>
                    <td>{{ $item->status == 1 ? 'Enabled' : 'Disabled'  }}</td>
                    <td>
                        <button
                            class="edit-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                            data-id="{{ $item->id }}"
                            data-item_name="{{ $item->item_name }}"
                            data-inventory_location="{{ $item->inventory_location }}"
                            data-brand="{{ $item->brand }}"
                            data-category="{{ $item->category }}"
                            data-supplier_id="{{ $item->supplier->name }}"
                            data-stock_unit="{{ $item->stock_unit }}"
                            data-unit_price="{{ $item->unit_price }}"
                            data-status="{{ $item->status }}"
                            modal-toggle="addItemModal">
                            Edit
                        </button>
                        
                        <form action="{{route('item.destroy',$item->id)}}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure you want to delete this item?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
      
            </tbody>
        </table>
    </div>

    <div id="addItemModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Item<span style="cursor: pointer; float: right;" onclick="toggleModal('addItemModal')">x</span></h3>
                    <div class="mt-2">
                        <form id="addItemForm" class="space-y-4" enctype="multipart/form-data">
                        
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Item Name</label>
                    <input type="text" name="item_name" class="w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Inventory Location</label>
                    <input type="text" name="inventory_location" class="w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Brand</label>
                    <input type="text" name="brand" class="w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Category</label>
                    <input type="text" name="category" class="w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Supplier</label>
                    <select name="supplier_id" class="w-full border border-gray-300 rounded p-2" required>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Stock Unit</label>
                    <select name="stock_unit" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="piece">Piece</option>
                        <option value="box">Box</option>
                        <option value="set">Set</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" class="w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Item Images</label>
                    <input type="file" name="images[]" multiple class="w-full border border-gray-300 rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="enabled">Enabled</option>
                        <option value="disabled">Disabled</option>
                    </select>
                </div>

                            <button type="submit" class="w-full bg-blue-500 text-blue px-4 py-2 rounded-md">Add Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle modal visibility
        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
        }

        // Open modal when button clicked
        document.querySelectorAll('[modal-toggle]').forEach(function(e) {
            e.addEventListener('click', function() {
                let data = $(e).data();
                for (let key in data) {
                    $('[name="'+key+'"]').val(data[key]);
                }
                toggleModal('addItemModal');
            });
        });

        // AJAX form submission for adding item
        $('#addItemForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('item.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    $('#item-list').append(`
                        <tr>
                            <td class="px-6 py-3 border-b">${response.id}</td>
                            <td class="px-6 py-3 border-b">${response.item_name}</td>
                            <td class="px-6 py-3 border-b">${response.brand}</td>
                            <td class="px-6 py-3 border-b">${response.category}</td>
                            <td class="px-6 py-3 border-b">${response.supplier.name}</td>
                            <td class="px-6 py-3 border-b">${response.stock_unit}</td>
                            <td class="px-6 py-3 border-b">${response.unit_price}</td>
                            <td class="px-6 py-3 border-b">${response.status}</td>
                        </tr>
                    `);

                    // Close the modal
                    toggleModal('addItemModal');

                    // Clear the form
                    $('#addItemForm')[0].reset();
                },
                error: function(response) {
                    alert('Error adding item');
                }
            });
        });
    </script>



</x-app-layout>
