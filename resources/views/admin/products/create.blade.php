@extends('admin.layouts.admin')

@section('title', __('admin.add_new_product'))

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="mb-6">
    <div class="flex items-center gap-2 text-gray-400 text-sm mb-4">
        <a href="{{ route($routePrefix . '.products') }}" class="hover:text-black transition-colors font-bold">{{ __('admin.products') }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-black font-bold">{{ __('admin.add_new_product') }}</span>
    </div>
    <h2 class="page-title">{{ __('admin.add_new_product') }}</h2>
    <p class="page-subtitle">{{ __('admin.fill_product_info') }}</p>
</div>

<form action="{{ route($routePrefix . '.products.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 900px;">
    @csrf
    <div style="background-color: #fff; border: 1px solid #000; border-radius: 12px; padding: 40px; margin-top: 20px;">
        <div class="space-y-8">
            <!-- Section: Primary Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label for="name" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.product_name') }}</label>
                    <input type="text" name="name" id="name" placeholder="{{ __('admin.enter_product_name') }}" 
                        style="width: 100%; padding: 12px 20px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none;" required>
                </div>

                <div>
                    <label for="brand" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.brand') }}</label>
                    <div style="position: relative;">
                        <select name="brand" id="brand" 
                            style="width: 100%; padding: 12px 20px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; appearance: none; background-color: #fff;" required>
                            <option value="" disabled selected>{{ __('admin.select_brand') }}</option>
                            <option value="National Geographic">National Geographic</option>
                            <option value="The North Face">The North Face</option>
                            <option value="Columbia">Columbia</option>
                            <option value="Arcteryx">Arcteryx</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px;"></i>
                    </div>
                </div>

                <div>
                    <label for="category" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.category') }}</label>
                    <div style="position: relative;">
                        <select name="category" id="category" 
                            style="width: 100%; padding: 12px 20px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; appearance: none; background-color: #fff;">
                            <option value="Jackets">Jackets</option>
                            <option value="Pants">Pants</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                        <i class="fa-solid fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px;"></i>
                    </div>
                </div>

                <div>
                    <label for="price" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.price') }} (Rp)</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 20px; font-weight: 700; color: #000;">Rp</span>
                        <input type="text" name="price" id="price" placeholder="6.999.000" 
                            style="width: 100%; padding: 12px 20px 12px 50px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none;" required>
                    </div>
                </div>

                <div>
                    <label for="stock" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.stock') }}</label>
                    <input type="number" name="stock" id="stock" placeholder="0" 
                        style="width: 100%; padding: 12px 20px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none;" required>
                </div>

                <div class="md:col-span-2">
                    <label style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.product_images') }}</label>
                    <div style="border: 1px solid #000; border-radius: 8px; padding: 20px; position: relative; background-color: #fcfcfc;">
                        <input type="file" name="images[]" id="images" multiple accept="image/*" 
                            style="width: 100%; font-family: inherit; font-size: 14px; border: none; outline: none; cursor: pointer;">
                        <p style="font-size: 12px; color: #666; margin-top: 10px; font-style: italic;">
                            <i class="fa-solid fa-circle-info"></i> {{ __('admin.image_info_text') }}
                        </p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="description" style="display: block; font-weight: 700; font-size: 16px; margin-bottom: 10px; color: #000;">{{ __('admin.description') }}</label>
                    <textarea name="description" id="description" rows="4" placeholder="{{ __('admin.enter_product_description') }}" 
                        style="width: 100%; padding: 12px 20px; border: 1px solid #000; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; resize: vertical;"></textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 20px; padding-top: 20px;">
                <button type="submit" style="background-color: #00D1FF; color: #fff; border: none; padding: 15px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; flex-grow: 1; transition: background-color 0.3s;">
                    {{ __('admin.save_product') }}
                </button>
                <a href="{{ route($routePrefix . '.products') }}" style="background-color: #f0f0f0; color: #333; text-decoration: none; padding: 15px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; text-align: center; flex-grow: 1; transition: background-color 0.3s;">
                    {{ __('admin.cancel') }}
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
