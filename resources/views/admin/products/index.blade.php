@extends('admin.layouts.admin')

@section('title', __('admin.products'))

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="header-actions">
    <div>
        <h2 class="page-title">{{ __('admin.products') }}</h2>
        <p class="page-subtitle">{{ __('admin.manage_products') }}</p>
    </div>
    @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
    <div style="display: flex; gap: 10px;">
        <a href="{{ route($routePrefix . '.products.deleted') }}" 
            style="background-color: var(--nav-hover-bg); color: var(--text-title); border: 1px solid var(--border-color); padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 4px 4px 0px var(--border-color);">
            <i class="fa-solid fa-clock-rotate-left"></i> Delete History
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route($routePrefix . '.products.create') }}" 
            style="background-color: #00D1FF; color: #fff; border: 1px solid #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-plus"></i> {{ __('admin.add_product') }}
        </a>
        @endif
    </div>
    @endif
</div>

@if($errors->any() || session('error'))
<div style="background-color: #FEE2E2; border: 2px solid #EF4444; border-radius: 12px; padding: 15px; margin-bottom: 20px; box-shadow: 6px 6px 0px #000;">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
        <i class="fa-solid fa-circle-exclamation" style="color: #EF4444; font-size: 18px;"></i>
        <h4 style="color: #991B1B; font-weight: 800; text-transform: uppercase; font-size: 14px;">Product Update Failed</h4>
    </div>
    <ul style="margin: 0; padding-left: 25px; color: #B91C1C; font-size: 13px; font-weight: 600;">
        @if(session('error')) <li>{{ session('error') }}</li> @endif
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="table-container">
    <table class="responsive-table">
        <thead>
            <tr>
                <th>{{ __('admin.product_name') }}</th>
                <th>{{ __('admin.category') }}</th>
                <th>{{ __('admin.price') }}</th>
                <th>{{ __('admin.stock') }}</th>
                <th>{{ __('admin.status') }}</th>
                @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
                <th style="text-align: center;">{{ __('admin.actions') }}</th>
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
                        <a href="javascript:void(0)" 
                            data-product='@json($product)' 
                            onclick="openUpdateProductModal(this)" 
                            title="{{ __('admin.edit') }}" style="color: var(--text-main); font-size: 18px;">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
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

    function openUpdateProductModal(btn) {
        const product = JSON.parse(btn.getAttribute('data-product'));
        const baseUrl = "{{ url('/') }}";
        const routePrefix = "{{ $routePrefix }}";
        
        // Update form action with correct ID
        document.getElementById('updateForm').action = `${baseUrl}/${routePrefix}/products/${product.id}`;
        
        // Populate fields
        document.getElementById('update_name').value = product.name;
        document.getElementById('update_brand').value = product.brand;
        document.getElementById('update_brand').value = product.brand;
        
        // Populate sizes
        document.getElementById('update_size_S').value = 0;
        document.getElementById('update_size_M').value = 0;
        document.getElementById('update_size_L').value = 0;
        document.getElementById('update_size_XL').value = 0;
        if(product.sizes && product.sizes.length > 0) {
            product.sizes.forEach(sz => {
                const el = document.getElementById(`update_size_${sz.size}`);
                if(el) el.value = sz.stock;
            });
        }
        
        document.getElementById('update_description').value = product.description || '';
        
        let price = String(product.price);
        const updatePriceInput = document.getElementById('update_price');
        updatePriceInput.value = price.replace(/\D/g, ''); // Ensure clean digits
        formatPriceInput(updatePriceInput); // Format it immediately with dots

        // Populate Image Slots
        const images = [product.image, product.image2, product.image3];
        for(let i = 1; i <= 3; i++) {
            const imgUrl = images[i-1];
            const previewEl = document.getElementById(`preview_${i}`);
            const placeholderEl = document.getElementById(`placeholder_${i}`);
            const removeBtn = document.getElementById(`remove_btn_${i}`);
            const deleteInput = document.getElementById(`delete_${i}`);
            const fileInput = document.getElementById(`input_${i}`);
            
            // Reset state
            deleteInput.value = "0";
            fileInput.value = "";
            
            const isPlaceholder = imgUrl && imgUrl.includes('placehold.co');
            const hasImage = imgUrl && !isPlaceholder;
            
            if (hasImage) {
                previewEl.src = imgUrl;
                previewEl.style.display = 'block';
                placeholderEl.style.display = 'none';
                removeBtn.style.display = 'flex';
            } else {
                previewEl.src = '';
                previewEl.style.display = 'none';
                placeholderEl.style.display = 'block';
                removeBtn.style.display = 'none';
            }
        }
        
        document.getElementById('updateProductModal').style.display = 'flex';
    }

    // New Image Slot Handlers
    function previewImageSlot(input, i) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`preview_${i}`).src = e.target.result;
                document.getElementById(`preview_${i}`).style.display = 'block';
                document.getElementById(`placeholder_${i}`).style.display = 'none';
                document.getElementById(`remove_btn_${i}`).style.display = 'flex';
                document.getElementById(`delete_${i}`).value = "0"; // Cancel any deletion
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImageSlot(i, event) {
        if (event) event.stopPropagation(); // Prevent triggering file input
        
        document.getElementById(`preview_${i}`).src = '';
        document.getElementById(`preview_${i}`).style.display = 'none';
        document.getElementById(`placeholder_${i}`).style.display = 'block';
        document.getElementById(`remove_btn_${i}`).style.display = 'none';
        
        document.getElementById(`input_${i}`).value = ""; // Clear file input
        document.getElementById(`delete_${i}`).value = "1"; // Mark for deletion in DB
    }

    // Price auto-format with dots
    function formatPriceInput(input) {
        let value = input.value.replace(/\D/g, ''); // strip non-digits
        if (value === '') { input.value = ''; return; }
        input.value = Number(value).toLocaleString('id-ID');
    }

    // Initialize formatting and listeners
    document.addEventListener('DOMContentLoaded', function() {
        const updatePriceInput = document.getElementById('update_price');
        if (updatePriceInput) {
            updatePriceInput.addEventListener('input', function() { formatPriceInput(this); });
        }

        // Strip dots before any form submit in this page
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const up = document.getElementById('update_price');
                if (up && form.contains(up)) up.value = up.value.replace(/\./g, '');
            });
        });

        // Image Slots
        for(let i = 1; i <= 3; i++) {
            const container = document.getElementById(`image_slot_${i}_container`);
            const input = document.getElementById(`input_${i}`);
            if (container && input) {
                container.addEventListener('click', function() {
                    input.click();
                });
            }
        }
    });

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
<div id="updateProductModal" class="modal-container" style="display: none;">
    <div class="modal-content">
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

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; color: var(--text-muted);">Brand</label>
                <div style="position: relative;">
                    <select name="brand" id="update_brand" required
                        style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-content); appearance: none; cursor: pointer;">
                        <option value="" disabled selected>Select Brand</option>
                        <option value="National Geographic">National Geographic</option>
                        <option value="The North Face">The North Face</option>
                        <option value="Columbia">Columbia</option>
                        <option value="Arcteryx">Arcteryx</option>
                    </select>
                    <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: var(--text-main);"></i>
                </div>
            </div>

            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
                    <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Stock per Size</label>
                    <span style="font-size: 10px; font-style: italic; color: #EF4444; font-weight: 700;"><i class="fa-solid fa-lock"></i> Add via Supplier / Incoming</span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; opacity: 0.7;">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">S</label>
                        <input type="number" name="sizes[S]" id="update_size_S" placeholder="0" min="0" required readonly title="Stock locked. Use Add Stock from Supplier."
                            style="width: 100%; padding: 8px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-page); cursor: not-allowed;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">M</label>
                        <input type="number" name="sizes[M]" id="update_size_M" placeholder="0" min="0" required readonly title="Stock locked. Use Add Stock from Supplier."
                            style="width: 100%; padding: 8px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-page); cursor: not-allowed;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">L</label>
                        <input type="number" name="sizes[L]" id="update_size_L" placeholder="0" min="0" required readonly title="Stock locked. Use Add Stock from Supplier."
                            style="width: 100%; padding: 8px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-page); cursor: not-allowed;">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">XL</label>
                        <input type="number" name="sizes[XL]" id="update_size_XL" placeholder="0" min="0" required readonly title="Stock locked. Use Add Stock from Supplier."
                            style="width: 100%; padding: 8px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; color: var(--text-main); font-weight: 600; background: var(--bg-page); cursor: not-allowed;">
                    </div>
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

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; color: var(--text-muted);">Product Images (Max 3)</label>
                <div style="display: flex; gap: 15px;">
                    @for($i = 1; $i <= 3; $i++)
                    <div id="image_slot_{{ $i }}_container" style="flex: 1; aspect-ratio: 1; border: 2px dashed var(--border-color); border-radius: 12px; position: relative; overflow: hidden; background: var(--bg-content); display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <!-- Preview Image -->
                        <img id="preview_{{ $i }}" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                        
                        <!-- Empty Placeholder -->
                        <div id="placeholder_{{ $i }}" style="text-align: center; color: var(--text-muted);">
                            <i class="fa-solid fa-plus-circle" style="font-size: 24px; margin-bottom: 5px;"></i>
                            <div style="font-size: 10px; font-weight: 700;">ADD IMAGE</div>
                        </div>

                        <!-- Remove Button -->
                        <button type="button" onclick="removeImageSlot({{ $i }}, event)" id="remove_btn_{{ $i }}" style="position: absolute; top: 5px; right: 5px; background: #EF4444; color: #fff; border: 2px solid #000; width: 24px; height: 24px; border-radius: 6px; display: none; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; z-index: 10; box-shadow: 2px 2px 0px #000;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Hidden File Input (Robust approach) -->
                        <input type="file" name="image_slot_{{ $i }}" id="input_{{ $i }}" accept="image/*" 
                            style="opacity: 0; position: absolute; inset: 0; cursor: pointer; font-size: 0;"
                            onchange="previewImageSlot(this, {{ $i }})">
                        
                        <!-- Deletion Marker -->
                        <input type="hidden" name="delete_image_{{ $i }}" id="delete_{{ $i }}" value="0">
                    </div>
                    @endfor
                </div>
                <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px; font-style: italic;">* Click a slot to add or replace an image. Use the red X to remove.</p>
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
<div id="addStockModal" class="modal-container" style="display: none;">
    <div class="modal-content">
        <button onclick="closeAddStockModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size: 24px; font-weight: 800; text-align: center; margin-bottom: 10px; color: #000; text-transform: uppercase;">Add Stock</h2>
        <p id="stock_product_name" style="text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; font-weight: 600;"></p>

        <form id="addStockForm" method="POST" class="space-y-6">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Size</label>
                <select name="size" required style="width: 100%; padding: 12px 15px; border: 2px solid #000; border-radius: 12px; font-size: 14px; outline: none; font-weight: 600;">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            
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
<div id="stockHistoryModal" class="modal-container" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
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
