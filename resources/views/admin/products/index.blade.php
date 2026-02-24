@extends('admin.layouts.admin')

@section('title', __('admin.products'))

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 class="page-title" style="margin-bottom: 5px;">{{ __('admin.products') }}</h2>
        <p class="page-subtitle" style="margin-bottom: 0;">{{ __('admin.manage_products') }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route($routePrefix . '.products.create') }}" style="background-color: #00D1FF; color: #fff; border: 1px solid #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 4px 4px 0px #000;">
        <i class="fa-solid fa-plus"></i> {{ __('admin.add_product') }}
    </a>
    @endif
</div>

<div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; margin-top: 20px;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color);">
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px;">{{ __('admin.product_name') }}</th>
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px;">{{ __('admin.category') }}</th>
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px;">{{ __('admin.price') }}</th>
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px;">{{ __('admin.stock') }}</th>
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px;">{{ __('admin.status') }}</th>
                @if(auth()->user()->isAdmin())
                <th style="padding: 15px 20px; font-weight: 700; color: var(--text-title); font-size: 16px; text-align: center;">{{ __('admin.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                $status = 'In Stock';
                $statusColor = '#4ADE80';
                if ($product->stock <= 0) {
                    $status = 'Out of Stock';
                    $statusColor = '#EF4444';
                } elseif ($product->stock <= 10) {
                    $status = 'Low Stock';
                    $statusColor = '#FB923C';
                }
            @endphp
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 15px 20px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ $product->image }}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; background-color: var(--nav-hover-bg);">
                        <span style="font-size: 13px; font-weight: 400; color: var(--text-main); max-width: 250px; line-height: 1.2;">{{ $product->name }}</span>
                    </div>
                </td>
                <td style="padding: 15px 20px; font-size: 14px; color: var(--text-main);">{{ $product->brand }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 400; color: var(--text-main);">{{ $product->formatted_price }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 700; color: var(--text-main);">{{ $product->stock }}</td>
                <td style="padding: 15px 20px;">
                    <span style="background-color: {{ $statusColor }}; color: #000; font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 4px; text-transform: none;">
                        {{ $status }}
                    </span>
                </td>
                @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
                <td style="padding: 15px 20px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick="openAddStockModal({{ $product->id }}, '{{ $product->name }}')" title="{{ __('admin.add_stock') }}" style="color: #4ADE80; font-size: 18px;"><i class="fa-solid fa-box-open"></i></a>
                        <a href="javascript:void(0)" onclick="openStockHistoryModal({{ $product->id }}, '{{ $product->name }}')" title="{{ __('admin.stock_history') }}" style="color: #6366F1; font-size: 18px;"><i class="fa-solid fa-clock-rotate-left"></i></a>
                        @if(auth()->user()->isAdmin())
                        <a href="javascript:void(0)" onclick='openUpdateModal({!! json_encode($product) !!})' title="{{ __('admin.edit') }}" style="color: var(--text-main); font-size: 18px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" onclick="openDeleteModal({{ $product->id }})" title="{{ __('admin.delete') }}" style="color: #EF4444; font-size: 18px;"><i class="fa-solid fa-trash-can"></i></a>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $products->links() }}
</div>


@if(session('success'))
<!-- Success Modal -->
<div id="successModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: var(--bg-card); width: 400px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid var(--border-color); box-shadow: 10px 10px 0px var(--border-color); transform: translateY(0); transition: transform 0.3s ease;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 10px; color: var(--text-title); text-transform: uppercase;">Success!</h3>
        <p style="font-size: 16px; color: var(--text-muted); margin-bottom: 30px;">{{ session('success') }}</p>
        <button onclick="closeModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; transition: all 0.2s; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<script>
    function closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        setTimeout(() => modal.remove(), 300);
    }
</script>
@endif
@if(session('delete_success'))
<!-- Delete Success Modal -->
<div id="deleteSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid #000; box-shadow: 10px 10px 0px #000;">
        <div style="width: 80px; height: 80px; background: #EF4444; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-trash-can" style="font-size: 40px; color: #fff;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #000;">Deleted!</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px; font-style: italic;">{{ session('delete_success') }}</p>
        <button onclick="closeDeleteSuccessModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000;">
            OK
        </button>
    </div>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 450px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid #000; box-shadow: 10px 10px 0px #000;">
        <div style="width: 80px; height: 80px; background: #FFEA00; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 15px; color: #000; text-transform: uppercase;">{{ __('admin.are_you_sure') }}</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px;">{{ __('admin.delete_confirmation') }}</p>
        
        <form id="deleteForm" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <button onclick="closeDeleteModal()" style="background: #f0f0f0; color: #333; border: 2px solid #000; padding: 12px 30px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                {{ __('admin.cancel') }}
            </button>
            <button onclick="submitDelete()" style="background: #EF4444; color: #fff; border: 2px solid #000; padding: 12px 30px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                {{ __('admin.delete') }}
            </button>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;

    function openDeleteModal(id) {
        currentDeleteId = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
        currentDeleteId = null;
    }

    function submitDelete() {
        if (currentDeleteId !== null) {
            const form = document.getElementById('deleteForm');
            form.action = `/{{ $routePrefix }}/products/${currentDeleteId}`;
            form.submit();
        }
    }

    function closeDeleteSuccessModal() {
        const modal = document.getElementById('deleteSuccessModal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            setTimeout(() => modal.remove(), 300);
        }
    }

    // Reuse existing closeModal for successModal
    function closeModal() {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            setTimeout(() => modal.remove(), 300);
        }
    }

    function openUpdateModal(product) {
        document.getElementById('updateForm').action = `/{{ $routePrefix }}/products/${product.id || 1}`;
        document.getElementById('update_name').value = product.name;
        document.getElementById('update_brand').value = product.brand;
        document.getElementById('update_stock').value = product.stock;
        document.getElementById('update_description').value = product.description || '';
        
        // Ensure price is handled as a string for replacement logic
        let price = String(product.price);
        document.getElementById('update_price').value = price.replace('Rp', '').replace(/\./g, '').replace(/,/g, '');
        
        document.getElementById('updateProductModal').style.display = 'flex';
    }

    function closeUpdateModal() {
        document.getElementById('updateProductModal').style.display = 'none';
    }

    function closeUpdateSuccessModal() {
        const modal = document.getElementById('updateSuccessModal');
        if (modal) {
            modal.style.opacity = '0';
            modal.style.pointerEvents = 'none';
            setTimeout(() => modal.remove(), 300);
        }
    }

    // --- Stock Management JS ---
    function openAddStockModal(id, name) {
        document.getElementById('addStockForm').action = `/{{ $routePrefix }}/products/${id}/add-stock`;
        document.getElementById('stock_product_name').innerText = name;
        document.getElementById('addStockModal').style.display = 'flex';
    }

    function closeAddStockModal() {
        document.getElementById('addStockModal').style.display = 'none';
    }

    async function openStockHistoryModal(id, name) {
        document.getElementById('history_product_name').innerText = name;
        const historyTableBody = document.getElementById('historyTableBody');
        historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px;">Loading...</td></tr>';
        document.getElementById('stockHistoryModal').style.display = 'flex';

        try {
            const response = await fetch(`/{{ $routePrefix }}/products/${id}/stock-history`);
            const data = await response.json();
            
            if (data.length === 0) {
                historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#666;">No history records found.</td></tr>';
                return;
            }

            historyTableBody.innerHTML = '';
            data.forEach(log => {
                const row = `
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px; font-size: 13px;">${log.date}</td>
                        <td style="padding: 12px; font-size: 13px; font-weight:700; color:#4ADE80;">+${log.amount}</td>
                        <td style="padding: 12px; font-size: 13px; color:#666;">${log.description || '-'}</td>
                    </tr>
                `;
                historyTableBody.insertAdjacentHTML('beforeend', row);
            });
        } catch (error) {
            historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:red;">Error loading history.</td></tr>';
        }
    }

    function closeStockHistoryModal() {
        document.getElementById('stockHistoryModal').style.display = 'none';
    }

    // Trigger file input when placeholder is clicked
    const picturePlaceholder = document.getElementById('update_picture_placeholder');
    if (picturePlaceholder) {
        picturePlaceholder.onclick = function() {
            document.getElementById('update_images').click();
        };
    }

    const updateImagesInput = document.getElementById('update_images');
    if (updateImagesInput) {
        updateImagesInput.onchange = function() {
            if(this.files.length > 0) {
                document.getElementById('update_picture_placeholder').value = this.files.length + ' images selected';
            }
        };
    }
</script>

@if(session('update_success'))
<!-- Update Success Modal -->
<div id="updateSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid #000; box-shadow: 10px 10px 0px #000;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 10px; color: #000; text-transform: uppercase;">Updated!</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px;">{{ session('update_success') }}</p>
        <button onclick="closeUpdateSuccessModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>
@endif

<!-- Update Product Modal -->
<div id="updateProductModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: var(--bg-card); width: 500px; padding: 40px; border-radius: 20px; position: relative; border: 2px solid var(--border-color); box-shadow: 10px 10px 0px var(--border-color);">
        <button onclick="closeUpdateModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-main);">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size: 24px; font-weight: 800; text-align: center; margin-bottom: 30px; color: var(--text-title); text-transform: uppercase;">Update Product</h2>

        <form id="updateForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Product Name</label>
                <input type="text" name="name" id="update_name" placeholder="Edit Product Name" 
                    style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-content);">
            </div>

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1; position: relative;">
                    <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Brand</label>
                    <select name="brand" id="update_brand" 
                        style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); appearance: none; background: var(--bg-content); font-weight: 600;">
                        <option value="" disabled>Edit Brand</option>
                        <option value="National Geographic">National Geographic</option>
                        <option value="The North Face">The North Face</option>
                        <option value="Columbia">Columbia</option>
                        <option value="Arcteryx">Arcteryx</option>
                    </select>
                    <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 72%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: var(--text-main);"></i>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Current Stock</label>
                    <input type="number" name="stock" id="update_stock" placeholder="Stock" 
                        style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-content);">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Price</label>
                <input type="text" name="price" id="update_price" placeholder="Edit Price" 
                    style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-content);">
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Description</label>
                <textarea name="description" id="update_description" placeholder="Edit Description" rows="3"
                    style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-content);"></textarea>
            </div>

            <div style="position: relative;">
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Images</label>
                <input type="text" id="update_picture_placeholder" placeholder="Edit Picture" readonly
                    style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); cursor: pointer; font-weight: 600; background: var(--bg-content);">
                <i class="fa-regular fa-image" style="position: absolute; right: 15px; top: 72%; transform: translateY(-50%); font-size: 18px; color: var(--text-main);"></i>
                <input type="file" name="images[]" id="update_images" multiple accept="image/*" style="display: none;">
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" style="background: var(--text-title); color: var(--bg-card); border: 2px solid var(--text-title); padding: 12px 30px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; box-shadow: 4px 4px 0px var(--border-color); text-transform: uppercase;">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Stock Modal -->
<div id="addStockModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 450px; padding: 40px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000;">
        <button onclick="closeAddStockModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size: 24px; font-weight: 800; text-align: center; margin-bottom: 10px; color: #000; text-transform: uppercase;">Add Stock</h2>
        <p id="stock_product_name" style="text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; font-weight: 600;"></p>

        <form id="addStockForm" method="POST" class="space-y-6">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Incoming Stock Quantity</label>
                <input type="number" name="amount" required min="1" placeholder="Example: 50" 
                    style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; outline: none; font-weight: 600;">
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Notes</label>
                <textarea name="description" placeholder="Example: Shipment from Supplier A" rows="3"
                    style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; outline: none; font-weight: 600;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" style="background: #4ADE80; color: #000; border: 2px solid #000; padding: 12px 30px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                    Update Stock
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stock History Modal -->
<div id="stockHistoryModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 600px; padding: 40px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000;">
        <button onclick="closeStockHistoryModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size: 24px; font-weight: 800; text-align: center; margin-bottom: 10px; color: #000; text-transform: uppercase;">Stock History</h2>
        <p id="history_product_name" style="text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; font-weight: 600;"></p>

        <div style="max-height: 400px; overflow-y: auto; border: 2px solid #000; border-radius: 12px; background: #fff;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9f9f9; position: sticky; top: 0; border-bottom: 2px solid #000;">
                    <tr>
                        <th style="padding: 15px; text-align: left; font-size: 13px; font-weight: 800; text-transform: uppercase;">Date</th>
                        <th style="padding: 15px; text-align: left; font-size: 13px; font-weight: 800; text-transform: uppercase;">Quantity</th>
                        <th style="padding: 15px; text-align: left; font-size: 13px; font-weight: 800; text-transform: uppercase;">Notes</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <!-- Loaded via JS -->
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: center; margin-top: 30px;">
            <button onclick="closeStockHistoryModal()" style="background: #000; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                Close
            </button>
        </div>
    </div>
</div>
@endsection
