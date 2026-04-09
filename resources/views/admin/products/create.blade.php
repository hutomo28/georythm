@extends('admin.layouts.admin')

@section('title', __('admin.add_new_product'))

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="mb-6">
    <div class="flex items-center gap-2 text-gray-400 text-sm mb-4">
        <a href="{{ route($routePrefix . '.products') }}" class="hover:text-black dark:hover:text-white transition-colors font-bold">{{ __('admin.products') }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-black dark:text-white font-bold">{{ __('admin.add_new_product') }}</span>
    </div>
    <h2 class="page-title">{{ __('admin.add_new_product') }}</h2>
    <p class="page-subtitle">{{ __('admin.fill_product_info') }}</p>
</div>

@if ($errors->any())
    <div style="background-color: #FEF2F2; border: 1px solid #F87171; color: #991B1B; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
        <div style="font-weight: 700; margin-bottom: 5px;">{{ __('admin.error_title') ?? 'There were some problems with your input.' }}</div>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li style="font-size: 14px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route($routePrefix . '.products.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 900px;">
    @csrf
    <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 40px; margin-top: 20px; box-shadow: 10px 10px 0px var(--border-color); transition: all 0.3s;">
        <div class="space-y-8">
            <!-- Section: Primary Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label for="name" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.product_name') }}</label>
                    <input type="text" name="name" id="name" placeholder="{{ __('admin.enter_product_name') }}" value="{{ old('name') }}"
                        style="width: 100%; padding: 12px 20px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);" required>
                </div>

                <div>
                    <label for="brand" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.brand') }}</label>
                    <div style="position: relative;">
                        <select name="brand" id="brand" 
                            style="width: 100%; padding: 12px 20px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; appearance: none; background-color: var(--bg-page); color: var(--text-main);" required>
                            <option value="" disabled selected>{{ __('admin.select_brand') }}</option>
                            <option value="National Geographic">National Geographic</option>
                            <option value="The North Face">The North Face</option>
                            <option value="Columbia">Columbia</option>
                            <option value="Arc'teryx">Arc'teryx</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: var(--text-main);"></i>
                    </div>
                </div>

                <div>
                    <label for="category" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.category') }}</label>
                    <div style="position: relative;">
                        <select name="category" id="category" 
                            style="width: 100%; padding: 12px 20px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; appearance: none; background-color: var(--bg-page); color: var(--text-main);">
                            <option value="Jackets">Jackets</option>
                            <option value="Pants">Pants</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: var(--text-main);"></i>
                    </div>
                </div>

                <div>
                    <label for="price" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.price') }} (Rp)</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 20px; font-weight: 700; color: var(--text-title);">Rp</span>
                        <input type="text" name="price" id="price" placeholder="6.999.000" value="{{ old('price') }}"
                            style="width: 100%; padding: 12px 20px 12px 50px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);" required>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.stock') }} per Size</label>
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">S</label>
                            <input type="number" name="sizes[S]" placeholder="0" value="{{ old('sizes.S', 0) }}" min="0" required
                                style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">M</label>
                            <input type="number" name="sizes[M]" placeholder="0" value="{{ old('sizes.M', 0) }}" min="0" required
                                style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">L</label>
                            <input type="number" name="sizes[L]" placeholder="0" value="{{ old('sizes.L', 0) }}" min="0" required
                                style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">XL</label>
                            <input type="number" name="sizes[XL]" placeholder="0" value="{{ old('sizes.XL', 0) }}" min="0" required
                                style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: var(--bg-page); color: var(--text-main);">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.product_images') }} (Max 3)</label>
                    <div style="display: flex; gap: 15px;">
                        @for($i = 1; $i <= 3; $i++)
                        <div id="image_slot_{{ $i }}_container" style="flex: 1; aspect-ratio: 1; border: 2px dashed var(--border-color); border-radius: 12px; position: relative; overflow: hidden; background: var(--bg-content, #f9fafb); display: flex; align-items: center; justify-content: center; cursor: pointer;">
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

                            <!-- Hidden File Input -->
                            <input type="file" name="images[]" id="input_{{ $i }}" accept="image/*" {{ $i === 1 ? 'required' : '' }}
                                style="opacity: 0; position: absolute; inset: 0; cursor: pointer; font-size: 0;"
                                onchange="previewImageSlot(this, {{ $i }})">
                        </div>
                        @endfor
                    </div>
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px; font-style: italic;">* Click a slot to add an image. Use the red X to remove. Minimum 1 image is required.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="description" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: var(--text-title);">{{ __('admin.description') }}</label>
                    <textarea name="description" id="description" rows="4" placeholder="{{ __('admin.enter_product_description') }}" 
                        style="width: 100%; padding: 12px 20px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; resize: vertical; background-color: var(--bg-page); color: var(--text-main);">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 20px; padding-top: 20px;">
                <button type="submit" style="background-color: #00D1FF; color: #fff; border: 2px solid #000; padding: 15px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; flex-grow: 1; transition: all 0.3s; box-shadow: 6px 6px 0px #000;">
                    {{ __('admin.save_product') }}
                </button>
                <a href="{{ route($routePrefix . '.products') }}" style="background-color: var(--nav-hover-bg); color: var(--text-title); text-decoration: none; padding: 15px 40px; border: 2px solid var(--border-color); border-radius: 12px; font-weight: 700; font-size: 16px; text-align: center; flex-grow: 1; transition: all 0.3s; box-shadow: 6px 6px 0px var(--border-color);">
                    {{ __('admin.cancel') }}
                </a>
            </div>
        </div>
    </div>
</form>

<script>
    function previewImageSlot(input, i) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`preview_${i}`).src = e.target.result;
                document.getElementById(`preview_${i}`).style.display = 'block';
                document.getElementById(`placeholder_${i}`).style.display = 'none';
                document.getElementById(`remove_btn_${i}`).style.display = 'flex';
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
    }

    // Price auto-format with dots
    function formatPriceInput(input) {
        let value = input.value.replace(/\D/g, ''); // strip non-digits
        if (value === '') { input.value = ''; return; }
        input.value = Number(value).toLocaleString('id-ID');
    }

    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function() { formatPriceInput(this); });
        // Format on page load if old value exists
        if (priceInput.value) formatPriceInput(priceInput);
    }

    // Strip dots before form submit
    document.querySelector('form').addEventListener('submit', function() {
        const p = document.getElementById('price');
        if (p) p.value = p.value.replace(/\./g, '');
    });
</script>
@endsection
