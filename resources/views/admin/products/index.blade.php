@extends('admin.layouts.admin')

@section('title', 'Product')

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 class="page-title" style="margin-bottom: 5px;">Product</h2>
        <p class="page-subtitle" style="margin-bottom: 0;">Manage your product catalog, inventory, and categories</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route($routePrefix . '.products.create') }}" style="background-color: #00D1FF; color: #fff; border: 1px solid #000; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 4px 4px 0px #000;">
        <i class="fa-solid fa-plus"></i> Add new Product
    </a>
    @endif
</div>

<div style="background-color: #fff; border: 1px solid #000; border-radius: 12px; overflow: hidden; margin-top: 20px;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px;">Product</th>
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px;">Brand</th>
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px;">Price</th>
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px;">Stok</th>
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px;">Status</th>
                @if(auth()->user()->isAdmin())
                <th style="padding: 15px 20px; font-weight: 700; color: #333; font-size: 16px; text-align: center;">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $products = [
                    [
                        'name' => 'NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK',
                        'brand' => 'National Geographic',
                        'price' => 'Rp6.999.000',
                        'stock' => 42,
                        'status' => 'In Stock',
                        'status_color' => '#4ADE80',
                        'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
                    ],
                    [
                        'name' => 'NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White',
                        'brand' => 'National Geographic',
                        'price' => 'Rp6.999.000',
                        'stock' => 9,
                        'status' => 'Low Stock',
                        'status_color' => '#FB923C',
                        'image' => 'https://images.unsplash.com/photo-1559551409-dadc959f76b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
                    ],
                    [
                        'name' => 'TNF- Men\'s DRYVENT™ Mono Mountain Jacket',
                        'brand' => 'The North Face',
                        'price' => 'Rp2.550.000',
                        'stock' => 60,
                        'status' => 'In Stock',
                        'status_color' => '#4ADE80',
                        'image' => 'https://images.unsplash.com/photo-1547996160-81f9608c3a99?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
                    ],
                    [
                        'name' => 'COLUMBIA- Men\'s Whistler Peak™ Shell Jacket',
                        'brand' => 'Columbia',
                        'price' => 'Rp4.200.000',
                        'stock' => 0,
                        'status' => 'Out of Stock',
                        'status_color' => '#EF4444',
                        'image' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
                    ],
                    [
                        'name' => 'Arcteryx- Beta LT Gore-Tex Jacket Mens Medium 30165',
                        'brand' => 'Arcteryx',
                        'price' => 'Rp7.000.000',
                        'stock' => 50,
                        'status' => 'In Stock',
                        'status_color' => '#4ADE80',
                        'image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
                    ],
                ];
            @endphp

            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #000;">
                <td style="padding: 15px 20px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ $product['image'] }}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-cover: center; background-color: #eee;">
                        <span style="font-size: 13px; font-weight: 400; color: #000; max-width: 250px; line-height: 1.2;">{{ $product['name'] }}</span>
                    </div>
                </td>
                <td style="padding: 15px 20px; font-size: 14px; color: #333;">{{ $product['brand'] }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 400; color: #000;">{{ $product['price'] }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 700; color: #000;">{{ $product['stock'] }}</td>
                <td style="padding: 15px 20px;">
                    <span style="background-color: {{ $product['status_color'] }}; color: #fff; font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 4px; text-transform: none;">
                        {{ $product['status'] }}
                    </span>
                </td>
                @if(auth()->user()->isAdmin())
                <td style="padding: 15px 20px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick='openUpdateModal({!! json_encode($product) !!})' style="color: #000; font-size: 18px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" onclick="openDeleteModal({{ $loop->index }})" style="color: #EF4444; font-size: 18px;"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@if(session('success'))
<!-- Success Modal -->
<div id="successModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid #000; box-shadow: 10px 10px 0px #000; transform: translateY(0); transition: transform 0.3s ease;">
        <div style="width: 80px; height: 80px; background: #FFEA00; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #000;">Success!</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px; font-style: italic;">{{ session('success') }}</p>
        <button onclick="closeModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; transition: all 0.2s;">
            OK
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
        <div style="width: 80px; height: 80px; background: #fff; border: 2px solid #EF4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px; color: #EF4444;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 15px; color: #000;">Are you sure?</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px;">Are you sure you want to delete this product? This action cannot be undone.</p>
        
        <form id="deleteForm" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <button onclick="closeDeleteModal()" style="background: #f0f0f0; color: #333; border: 2px solid #000; padding: 12px 30px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000;">
                Cancel
            </button>
            <button onclick="submitDelete()" style="background: #EF4444; color: #fff; border: 2px solid #000; padding: 12px 30px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000;">
                Delete
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
            // Assuming the route is /admin/products/{id}
            form.action = `/admin/products/${currentDeleteId}`;
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
        document.getElementById('updateForm').action = `/admin/products/${product.id || 1}`;
        document.getElementById('update_name').value = product.name;
        document.getElementById('update_brand').value = product.brand;
        document.getElementById('update_stock').value = product.stock;
        document.getElementById('update_price').value = product.price.replace('Rp', '').replace(/\./g, '');
        
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
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #fff;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #000;">Updated!</h3>
        <p style="font-size: 16px; color: #333; margin-bottom: 30px; font-style: italic;">{{ session('update_success') }}</p>
        <button onclick="closeUpdateSuccessModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000;">
            OK
        </button>
    </div>
</div>
@endif

<!-- Update Product Modal -->
<div id="updateProductModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(2px);">
    <div style="background: #fff; width: 500px; padding: 40px; border-radius: 12px; position: relative; border: 1px solid #ddd; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <button onclick="closeUpdateModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #333;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h2 style="font-size: 28px; font-weight: 700; text-align: center; margin-bottom: 30px; text-decoration: underline; color: #000;">Update Product</h2>

        <form id="updateForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <input type="text" name="name" id="update_name" placeholder="Edit Product Name" 
                    style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; color: #666;">
            </div>

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1; position: relative;">
                    <select name="brand" id="update_brand" 
                        style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; color: #666; appearance: none; background: #fff;">
                        <option value="" disabled>Edit Brand</option>
                        <option value="National Geographic">National Geographic</option>
                        <option value="The North Face">The North Face</option>
                        <option value="Columbia">Columbia</option>
                        <option value="Arcteryx">Arcteryx</option>
                    </select>
                    <i class="fa-solid fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: #666;"></i>
                </div>
                <div style="flex: 1;">
                    <input type="number" name="stock" id="update_stock" placeholder="Add Stock" 
                        style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; color: #666;">
                </div>
            </div>

            <div>
                <input type="text" name="price" id="update_price" placeholder="Edit Price" 
                    style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; color: #666;">
            </div>

            <div style="position: relative;">
                <input type="text" id="update_picture_placeholder" placeholder="Edit Picture" readonly
                    style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; color: #666; cursor: pointer;">
                <i class="fa-regular fa-image" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #000;"></i>
                <input type="file" name="images[]" id="update_images" multiple accept="image/*" style="display: none;">
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" style="background: #000; color: #fff; border: none; padding: 10px 25px; border-radius: 4px; font-weight: 700; font-size: 14px; cursor: pointer;">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
