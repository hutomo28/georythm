@extends('admin.layouts.admin')

@section('title', __('admin.orders'))

@section('content')
<div class="mb-4">
    <h2 class="page-title">{{ __('admin.orders') }}</h2>
    <p class="page-subtitle">{{ __('admin.manage_orders') }}</p>
</div>

<!-- Order Container -->
<div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-top: 20px;">
    
    <!-- Status Tabs -->
    <div style="background-color: var(--nav-hover-bg); padding: 6px; border-radius: 12px; width: fit-content; display: flex; gap: 5px; margin-bottom: 25px; border: 1px solid var(--border-color);">
        <button class="tab-btn active" data-status="all" style="padding: 8px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: var(--bg-card); color: var(--text-title); box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">{{ __('admin.all') }} {{ __('admin.orders') }}</button>
        <button class="tab-btn" data-status="waiting-payment" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">Waiting Payment</button>
        <button class="tab-btn" data-status="processing" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">Processing</button>
        <button class="tab-btn" data-status="shipped" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">Shipping</button>
        <button class="tab-btn" data-status="completed" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: var(--text-muted);">Completed</button>
    </div>

    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--border-color);">
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.customer') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.date') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.items') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.total') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px; text-align: center;">{{ __('admin.transaction') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px;">{{ __('admin.status') }}</th>
                <th style="padding: 15px 10px; font-weight: 700; color: var(--text-title); font-size: 18px; text-align: center;">{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            @php
                $statusColor = match($order->status) {
                    'waiting-payment' => '#EF4444',
                    'processing' => '#FB923C',
                    'shipped' => '#3B82F6',
                    'arrived' => '#10B981',
                    'completed' => '#4ADE80',
                    'cancelled' => '#6B7280',
                    default => '#000'
                };
            @endphp
            <tr class="order-row" data-status="{{ $order->status }}" style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 20px 10px;">
                    <div style="font-weight: 700; color: var(--text-title); font-size: 15px;">{{ $order->user->name }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">{{ $order->user->email }}</div>
                </td>
                <td style="padding: 20px 10px; font-weight: 400; color: var(--text-main);">{{ $order->created_at->format('d-m-Y') }}</td>
                <td style="padding: 20px 10px; font-weight: 700; color: var(--text-main);">{{ $order->items->count() }}</td>
                <td style="padding: 20px 10px; font-weight: 400; color: var(--text-main);">{{ $order->formatted_total }}</td>
                <td style="padding: 20px 10px; text-align: center;">
                    @if($order->payment && $order->payment->proof_image)
                        <div onclick="openTransactionModal('{{ asset('storage/' . $order->payment->proof_image) }}')" style="display: inline-block; width: 35px; height: 45px; border: 1px solid var(--border-color); padding: 4px; background: var(--bg-card); cursor: pointer;">
                            <div style="border: 1px solid var(--border-color); height: 100%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-file-invoice" style="font-size: 18px; color: var(--text-muted);"></i>
                            </div>
                        </div>
                    @else
                        <span style="color: var(--text-main); font-weight: 700;">—</span>
                    @endif
                </td>
                <td style="padding: 20px 10px;">
                    <span style="background-color: {{ $statusColor }}; color: #000; font-size: 11px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td style="padding: 20px 10px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick='openPrintModal({!! json_encode([
                            "name" => $order->shipping_name ?? $order->user->name,
                            "telp" => $order->shipping_phone ?? ($order->user->phone ?? "-"),
                            "address" => $order->shipping_address,
                            "no" => $order->shipping_apartment ?? "-",
                            "city" => $order->shipping_city ?? "-",
                            "prov" => $order->shipping_province ?? "-",
                            "postal" => $order->shipping_zip ?? "-",
                            "shipping_method" => $order->delivery_service ?? "Standard",
                            "date" => $order->created_at->format("d-m-Y"),
                            "time" => $order->created_at->format("H:i"),
                            "items" => $order->items->map(fn($i) => ["name" => $i->product_name, "qty" => $i->quantity, "size" => $i->size])
                        ]) !!})' title="{{ __('admin.print') }}" style="color: var(--text-main); font-size: 20px;"><i class="fa-solid fa-print"></i></a>
                        
                        @if($order->status !== 'completed')
                            <a href="javascript:void(0)" onclick='openEditModal({!! json_encode([
                                "id" => $order->id,
                                "name" => $order->user->name,
                                "status" => $order->status
                            ]) !!})' title="{{ __('admin.update_status') }}" style="color: var(--text-main); font-size: 20px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        @else
                            <span style="color: var(--text-muted); font-size: 20px; cursor: not-allowed;"><i class="fa-regular fa-pen-to-square"></i></span>
                        @endif
                        <a href="javascript:void(0)" onclick='openShipModal({!! json_encode(["id" => $order->id]) !!})' title="{{ __('admin.ship') }}" style="color: var(--text-main); font-size: 20px;"><i class="fa-solid fa-truck"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


    </table>
</div>

<style>
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        
        /* Show only the print modal and its contents */
        #printModal, #printModal * {
            visibility: visible;
        }

        /* Force light mode colors for printing */
        body {
            background-color: #fff !important;
            color: #000 !important;
        }

        /* Broadest possible override to force black text on everything in the paper */
        #printModal .paper, #printModal .paper * {
            color: #000 !important;
            background-color: transparent !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Specific exception for paper background */
        #printModal .paper {
            background-color: #fff !important;
        }

        /* Preserve logo brand color */
        #printModal .logo-yellow {
            color: #FFEA00 !important;
        }

        /* Hide the modal backdrop and specifically the buttons */
        #printModal {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            background: none !important;
            display: block !important;
        }

        .no-print {
            display: none !important;
        }

        /* Styling the paper for the printer */
        #printModal .paper {
            border: none !important;
            box-shadow: none !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            transform: none !important;
            position: static !important;
        }

        /* Specifically hide other modals and UI that might be visible */
        .sidebar, .top-bar, #transactionModal, .mb-4, .tab-btn {
            display: none !important;
        }
    }
</style>

<!-- Order Print Modal -->
<div id="printModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="position: relative; max-height: 95vh; display: flex; flex-direction: column; align-items: center;">
        
        <!-- Close Button (Outside Paper) -->
        <button onclick="closePrintModal()" class="no-print" style="position: absolute; right: -60px; top: 0; background: #fff; border: 2px solid #000; font-size: 24px; cursor: pointer; color: #000; width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- The "Paper" Container -->
        <div class="paper" style="background: #fff; width: 600px; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; transform: scale(0.9); overflow-y: auto; border-radius: 4px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span style="font-size: 28px; font-weight: 800; letter-spacing: 2px;">
                    <span style="color: #000;">GEO</span><span style="color: #FFEA00;" class="logo-yellow">RYTHM</span>
                </span>
            </div>

            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 14px; color: #000; font-weight: 800; margin-bottom: 10px; text-transform: uppercase;">Shipping Address</h4>
                <div style="border: 2px solid #000; padding: 15px; border-radius: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 13px;">
                    <div>
                        <div style="font-weight: 700;">Indonesia</div>
                        <div id="print_name" style="margin-top: 5px; font-weight: 800; font-size: 16px; text-transform: uppercase;">GEORYTHM CUSTOMER</div>
                        <div id="print_telp" style="margin-top: 10px; font-weight: 700;">No Telp. -</div>
                    </div>
                    <div style="text-align: right;">
                    </div>
                    <div style="grid-column: span 2; margin-top: 10px; line-height: 1.4;">
                        <div id="print_address" style="font-weight: 600;">Jl.Biru,RT03/RW06,No 20,Kel.Merah,Kec.Oren,Rainbow City</div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; margin-top: 5px; font-weight: 600;">
                             <div>No.<span id="print_no">20</span></div>
                            <div>Province: <span id="print_prov">Gradasi</span></div>
                            <div>City: <span id="print_city">Pelangi</span></div>
                            <div>Zip Code: <span id="print_postal">11223</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 14px; color: #000; font-weight: 800; margin-bottom: 10px; text-transform: uppercase;">Order Items</h4>
                <div id="print_items_container" style="border: 2px solid #000; padding: 15px; border-radius: 8px; font-size: 12px; max-height: 150px; overflow-y: auto;">
                    <!-- Items will be injected here -->
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 0px;">
                <div>
                    <h4 style="font-size: 14px; color: #000; font-weight: 800; margin-bottom: 5px; text-transform: uppercase;">Order Date</h4>
                    <div id="print_date_time" style="font-size: 14px; font-weight: 700; color: #000;">15-2-2026 07.00</div>
                </div>
                <div>
                    <h4 style="font-size: 14px; color: #000; font-weight: 800; margin-bottom: 5px; text-transform: uppercase;">Shipping Method</h4>
                    <div id="print_shipping_method" style="font-size: 14px; font-weight: 700; color: #000; text-transform: uppercase;">Standard</div>
                </div>
            </div>
        </div>

        <!-- Print Button (Outside Paper) -->
        <div style="display: flex; justify-content: center; margin-top: 30px;" class="no-print">
            <button onclick="triggerPrint()" style="background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px 60px; border-radius: 50px; font-weight: 800; font-size: 18px; cursor: pointer; box-shadow: 4px 4px 0px #000; display: flex; align-items: center; gap: 10px; text-transform: uppercase;">
                <i class="fa-solid fa-print"></i> Print Receipt
            </button>
        </div>
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="transactionModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);" onclick="closeTransactionModal()">
    <div style="background: #fff; padding: 20px; border-radius: 20px; position: relative; max-width: 90%; max-height: 90%; border: 2px solid #000; box-shadow: 10px 10px 0px #000;" onclick="event.stopPropagation()">
        <button onclick="closeTransactionModal()" style="position: absolute; right: 20px; top: 20px; background: #fff; border: 2px solid #000; width: 35px; height: 35px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h3 style="font-size: 20px; font-weight: 800; color: #000; margin-bottom: 20px; text-transform: uppercase;">Payment Proof</h3>
        <img id="modalTransactionImage" src="" alt="Transaction Detail" style="display: block; max-width: 100%; max-height: 70vh; border: 2px solid #000; border-radius: 12px;">
        <div style="display: flex; justify-content: center; margin-top: 25px;">
            <button onclick="closeTransactionModal()" style="background: #000; color: #fff; border: 2px solid #000; padding: 10px 30px; border-radius: 50px; font-weight: 800; font-size: 14px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Order Edit Modal -->
<div id="editModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: var(--bg-card); width: 450px; border-radius: 20px; position: relative; border: 2px solid var(--border-color); box-shadow: 10px 10px 0px var(--border-color); padding: 40px;">
        <button onclick="closeEditModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-main);">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: var(--text-title); margin-bottom: 30px; text-transform: uppercase;">Edit Order Status</h3>

        <form action="" method="POST" id="editOrderForm">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase;">Customer Name</label>
                <div id="edit_customer_name" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 15px; color: var(--text-main); background: var(--bg-content); font-weight: 700;">
                    Bagoes Hutomo
                </div>
            </div>

            <div style="margin-bottom: 35px; position: relative;">
                <label for="order_status" style="display: block; font-size: 12px; font-weight: 800; color: var(--text-muted); margin-bottom: 8px; text-transform: uppercase;">Selected Status</label>
                <select name="status" id="order_status" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 15px; color: var(--text-main); background: var(--bg-card); appearance: none; cursor: pointer; font-weight: 700;">
                    <option value="waiting-payment">Waiting Payment</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="arrived">Completed (Arrived)</option>
                    <option value="completed" disabled>Completed (Confirmed by Customer)</option>
                </select>
                <div style="position: absolute; right: 20px; top: 43px; pointer-events: none; color: var(--text-main);">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; transition: all 0.2s; text-transform: uppercase;">
                Update Status
            </button>
        </form>
    </div>
</div>

<!-- Order Edit Success Modal -->
<div id="editSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Success!</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5; font-weight: 600;">Order status has been successfully updated.</p>
        <button onclick="closeEditSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<!-- Order Shipping Modal -->
<div id="shipModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 500px; border-radius: 20px; position: relative; border: 2px solid #000; padding: 60px; box-shadow: 10px 10px 0px #000;">
        <button onclick="closeShipModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 32px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 28px; font-weight: 800; color: #000; margin-bottom: 40px; text-align: center; text-transform: uppercase;">Ship Order</h3>

        <form action="" method="POST" id="shipOrderForm">
            @csrf
            @method('PUT')
            <div style="max-width: 360px; margin: 0 auto;">
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Receipt Number / Waybill</label>
                    <input type="text" name="receipt_number" id="receipt_number" placeholder="Enter tracking number" required style="width: 100%; padding: 14px 20px; border: 2px solid #000; border-radius: 12px; font-size: 15px; color: #000; outline: none; font-weight: 700;">
                </div>

                <div style="display: flex; justify-content: center;">
                    <button type="submit" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 14px 60px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
                        Confirm Shipping
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Order Shipping Success Modal -->
<div id="shipSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 20px; position: relative; border: 2px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-truck-fast" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Shipped!</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5; font-weight: 600;">Receipt number and courier have been updated.</p>
        <button onclick="closeShipSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Done
        </button>
    </div>
</div>

<script>
    // Forms are now handled by standard submission since we have real routes
    // But we need to set the correct action URLs in openModal functions

    function closeShipSuccessModal() {
        document.getElementById('shipSuccessModal').style.display = 'none';
    }

    function openShipModal(order) {
        const form = document.getElementById('shipOrderForm');
        const route = "{{ route($routePrefix . '.orders.update-shipment', ':id') }}";
        form.action = route.replace(':id', order.id);

        document.getElementById('receipt_number').value = '';
        document.getElementById('shipModal').style.display = 'flex';
    }

    function closeShipModal() {
        document.getElementById('shipModal').style.display = 'none';
    }

    function closeEditSuccessModal() {
        document.getElementById('editSuccessModal').style.display = 'none';
        // In a real app, we'd reload or update the UI
    }

    function openEditModal(order) {
        const form = document.getElementById('editOrderForm');
        const route = "{{ route($routePrefix . '.orders.update-status', ':id') }}";
        form.action = route.replace(':id', order.id);
        
        document.getElementById('edit_customer_name').innerText = order.name;
        const statusSelect = document.getElementById('order_status');
        statusSelect.value = order.status;

        const statuses = ['waiting-payment', 'processing', 'shipped', 'completed'];
        const currentIndex = statuses.indexOf(order.status);

        // Disable options that are the current status or before it
        Array.from(statusSelect.options).forEach((option) => {
            const optionIndex = statuses.indexOf(option.value);
            if (optionIndex <= currentIndex) {
                option.disabled = true;
                option.style.color = '#cbd5e0';
            } else {
                option.disabled = false;
                option.style.color = '#000';
            }
        });

        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openPrintModal(order) {
        document.getElementById('print_name').innerText = order.name;
        document.getElementById('print_telp').innerText = 'No Telp.' + (order.telp || '-');
        document.getElementById('print_address').innerText = order.address || '-';
        document.getElementById('print_no').innerText = order.no || '-';
        document.getElementById('print_prov').innerText = order.prov || '-';
        document.getElementById('print_city').innerText = order.city || '-';
        document.getElementById('print_postal').innerText = order.postal || '-';
        document.getElementById('print_date_time').innerText = order.date + ' ' + (order.time || '');
        document.getElementById('print_shipping_method').innerText = order.shipping_method || 'Standard';

        const itemsContainer = document.getElementById('print_items_container');
        itemsContainer.innerHTML = '';
        
        if (order.items && order.items.length > 0) {
            order.items.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.style.display = 'flex';
                itemDiv.style.justifyContent = 'space-between';
                itemDiv.style.padding = '8px 0';
                if (index > 0) itemDiv.style.borderTop = '1px solid #eee';
                
                itemDiv.innerHTML = `
                    <div style="flex: 1; margin-right: 15px;">
                        <span style="font-weight: 700;">${index + 1}</span> ${item.name}
                        <div style="color: #666; font-size: 11px; margin-top: 2px;">${item.size || ''}</div>
                    </div>
                    <div style="font-weight: 700; white-space: nowrap;">${item.qty}X</div>
                `;
                itemsContainer.appendChild(itemDiv);
            });
        }

        document.getElementById('printModal').style.display = 'flex';
    }

    function closePrintModal() {
        document.getElementById('printModal').style.display = 'none';
    }

    let printCounter = 1;

    function triggerPrint() {
        const originalTitle = document.title;
        const printTitle = `georythm-${printCounter}`;
        
        document.title = printTitle;
        window.print();
        
        printCounter++;
        
        // Restore title after a short delay to ensure print dialog captures it
        setTimeout(() => {
            document.title = originalTitle;
        }, 1000);
    }

    function openTransactionModal(imageUrl) {
        document.getElementById('modalTransactionImage').src = imageUrl;
        document.getElementById('transactionModal').style.display = 'flex';
    }

    function closeTransactionModal() {
        document.getElementById('transactionModal').style.display = 'none';
    }

    // Tab Filtering Logic
    const tabButtons = document.querySelectorAll('.tab-btn');
    const orderRows = document.querySelectorAll('.order-row');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active states
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.style.background = 'transparent';
                b.style.color = '#4A5568';
                b.style.boxShadow = 'none';
            });

            // Add active state to clicked button
            btn.classList.add('active');
            btn.style.background = '#fff';
            btn.style.color = '#000';
            btn.style.boxShadow = '2px 2px 0px rgba(0,0,0,0.1)';

            const status = btn.getAttribute('data-status');

            // Filter rows
            orderRows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
