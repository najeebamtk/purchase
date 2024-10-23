<x-app-layout>

    <h1 class="text-2xl font-bold mb-4">Suppliers</h1>
    
    <!-- Button to trigger modal -->
    <div class="flex justify-start" >
    <button type="button" class="bg-blue-500 text-blue px-4 py-2 rounded mb-4" modal-toggle="addSupplierModal">
        Add Supplier
    </button>
    </div>

    <!-- Supplier List Tale -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-md">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-6 py-3 border-b">Supplier No</th>
                    <th class="text-left px-6 py-3 border-b">Supplier Name</th>
                    <th class="text-left px-6 py-3 border-b">Address</th>
                    <th class="text-left px-6 py-3 border-b">TAX No</th>
                    <th class="text-left px-6 py-3 border-b">Country</th>
                    <th class="text-left px-6 py-3 border-b">Mobile No</th>
                    <th class="text-left px-6 py-3 border-b">Email</th>
                    <th class="text-left px-6 py-3 border-b">Status</th>
                    <th class="text-left px-6 py-3 border-b">Actions</th>

                </tr>
            </thead>
            <tbody id="supplier-list">
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->tax_no }}</td>
                    <td>{{ $supplier->country }}</td>
                    <td>{{ $supplier->mobile_no }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->status }}</td>
                    <td>
                        <button
                            class="edit-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                            data-id="{{ $supplier->id }}"
                            data-name="{{ $supplier->name }}"
                            data-address="{{ $supplier->address }}"
                            data-tax_no="{{ $supplier->tax_no }}"
                            data-country="{{ $supplier->country }}"
                            data-mobile_no="{{ $supplier->mobile_no }}"
                            data-email="{{ $supplier->email }}"
                            data-status="{{ $supplier->status }}"
                            modal-toggle="addSupplierModal">
                            Edit
                        </button>
                        <form action="{{route('supplier.destroy',$supplier->id)}}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure you want to delete this supplier?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
      
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding Supplier -->
    <div id="addSupplierModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Supplier<span style="cursor: pointer; float: right;" onclick="toggleModal('addSupplierModal')">x</span></h3>
                    <div class="mt-2">
                        <form id="addSupplierForm" class="space-y-4" >
                            @csrf
                            <input type="hidden" name="id" value="" />
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                                <input type="text" name="name" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="tax_no" class="block text-sm font-medium text-gray-700">TAX No</label>
                                <input type="text" name="tax_no" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select name="country" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <option value="">-- Select Country --</option>
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="France">France</option>
                                    <option value="India">India</option>
                                    <option value="China">China</option>
                                    <option value="Japan">Japan</option>
                                    <!-- Add more countries as needed -->
                                </select>
                                                        </div>

                            <div>
                                <label for="mobile_no" class="block text-sm font-medium text-gray-700">Mobile No</label>
                                <input type="text" name="mobile_no" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Blocked">Blocked</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-500 text-blue px-4 py-2 rounded-md">Add Supplier</button>
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
                toggleModal('addSupplierModal');
            });
        });

        // AJAX form submission for adding supplier
        $('#addSupplierForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('suppliers.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    $('#supplier-list').append(`
                        <tr>
                            <td class="px-6 py-3 border-b">${response.id}</td>
                            <td class="px-6 py-3 border-b">${response.name}</td>
                            <td class="px-6 py-3 border-b">${response.address}</td>
                            <td class="px-6 py-3 border-b">${response.tax_no}</td>
                            <td class="px-6 py-3 border-b">${response.country}</td>
                            <td class="px-6 py-3 border-b">${response.mobile_no}</td>
                            <td class="px-6 py-3 border-b">${response.email}</td>
                            <td class="px-6 py-3 border-b">${response.status}</td>
                        </tr>
                    `);

                    // Close the modal
                    toggleModal('addSupplierModal');

                    // Clear the form
                    $('#addSupplierForm')[0].reset();
                },
                error: function(response) {
                    alert('Error adding supplier');
                }
            });
        });
    </script>



</x-app-layout>