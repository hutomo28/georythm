@extends('admin.layouts.admin')

@section('title', 'Order')

@section('content')
<div class="mb-4">
    <h2 class="page-title">Order</h2>
    <p class="page-subtitle">Track and manage customer orders</p>
</div>

<!-- Order Container -->
<div style="background-color: #fff; border: 1px solid #000; border-radius: 12px; padding: 20px; margin-top: 20px;">
    
    <!-- Status Tabs -->
    <div style="background-color: #E2E8F0; padding: 6px; border-radius: 12px; width: fit-content; display: flex; gap: 5px; margin-bottom: 25px; border: 1px solid #000;">
        <button class="tab-btn active" data-status="all" style="padding: 8px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: #fff; color: #000; box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">All order</button>
        <button class="tab-btn" data-status="Process pay" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Process payment</button>
        <button class="tab-btn" data-status="packing" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Packing</button>
        <button class="tab-btn" data-status="Delivered" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Delivery</button>
        <button class="tab-btn" data-status="Order completed" style="padding: 8px 15px; border-radius: 8px; font-weight: 700; font-size: 13px; border: none; cursor: pointer; transition: all 0.3s; background: transparent; color: #4A5568;">Order completed</button>
    </div>

    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Customer</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Date</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Item</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Total</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px; text-align: center;">Transaction</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px;">Status</th>
                <th style="padding: 15px 10px; font-weight: 700; color: #000; font-size: 18px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $orders = [
                    [
                        'name' => 'Bagoes Hutomo',
                        'email' => 'bagoeshutomo@gmail.com',
                        'date' => '15-2-2026',
                        'time' => '07.00',
                        'item' => 2,
                        'total' => 'Rp10.008.000',
                        'transaction' => true,
                        'status' => 'Delivered',
                        'status_color' => '#4ADE80',
                        'telp' => '09998887776891',
                        'address' => 'Jl.Biru, RT03/RW06, No 20, Kel.Merah, Kec.Oren, Kota Pelangi',
                        'no' => '20',
                        'prov' => 'Gradasi',
                        'city' => 'Pelangi',
                        'postal' => '11223',
                        'items' => [
                            ['name' => 'NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK', 'qty' => 1, 'size' => 'XL'],
                            ['name' => 'NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK', 'qty' => 1, 'size' => 'XL'],
                        ]
                    ],
                    [
                        'name' => 'Kim Jong-un',
                        'email' => 'kimkim@gmail.com',
                        'date' => '15-2-2026',
                        'time' => '08.30',
                        'item' => 1,
                        'total' => 'Rp6.999.000',
                        'transaction' => true,
                        'status' => 'packing',
                        'status_color' => '#FB923C',
                        'telp' => '081234567890',
                        'address' => 'Pyongyang St. No 1, North Block',
                        'no' => '1',
                        'prov' => 'DKI Korea',
                        'city' => 'Pyongyang',
                        'postal' => '00000',
                        'items' => [
                            ['name' => 'NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White', 'qty' => 1, 'size' => 'L'],
                        ]
                    ],
                    [
                        'name' => 'Dewi Anjani',
                        'email' => 'jani@gmail.com',
                        'date' => '15-2-2026',
                        'time' => '10.15',
                        'item' => 1,
                        'total' => 'Rp2.550.000',
                        'transaction' => false,
                        'status' => 'Process pay',
                        'status_color' => '#EF4444',
                        'telp' => '082233445566',
                        'address' => 'Rinjani Peak Road No 7',
                        'no' => '7',
                        'prov' => 'Lombok',
                        'city' => 'Mataram',
                        'postal' => '83121',
                        'items' => [
                            ['name' => 'TNF- Men\'s DRYVENT™ Mono Mountain Jacket', 'qty' => 1, 'size' => 'M'],
                        ]
                    ],
                    [
                        'name' => 'Maha Meru',
                        'email' => 'semeru@gmail.com',
                        'date' => '15-2-2026',
                        'time' => '11.00',
                        'item' => 1,
                        'total' => 'Rp4.200.000',
                        'transaction' => false,
                        'status' => 'Process pay',
                        'status_color' => '#EF4444',
                        'telp' => '081199887766',
                        'address' => 'Semeru Valley View No 10',
                        'no' => '10',
                        'prov' => 'Jawa Timur',
                        'city' => 'Lumajang',
                        'postal' => '65281',
                        'items' => [
                            ['name' => 'COLUMBIA- Men\'s Whistler Peak™ Shell Jacket', 'qty' => 1, 'size' => 'L'],
                        ]
                    ],
                    [
                        'name' => 'Aji Saka',
                        'email' => 'sadu@gmail.com',
                        'date' => '15-2-2026',
                        'time' => '13.45',
                        'item' => 1,
                        'total' => 'Rp7.000.000',
                        'transaction' => true,
                        'status' => 'packing',
                        'status_color' => '#FB923C',
                        'telp' => '085544332211',
                        'address' => 'Medang Kamulan St. No 1',
                        'no' => '1',
                        'prov' => 'Jawa Tengah',
                        'city' => 'Grobogan',
                        'postal' => '58111',
                        'items' => [
                            ['name' => 'Arcteryx- Beta LT Gore-Tex Jacket Mens Medium 30165', 'qty' => 1, 'size' => 'S'],
                        ]
                    ]
                ];
            @endphp

            @foreach($orders as $order)
            <tr class="order-row" data-status="{{ $order['status'] }}" style="border-bottom: 1px solid #E2E8F0;">
                <td style="padding: 20px 10px;">
                    <div style="font-weight: 700; color: #000; font-size: 15px;">{{ $order['name'] }}</div>
                    <div style="font-size: 12px; color: #718096;">{{ $order['email'] }}</div>
                </td>
                <td style="padding: 20px 10px; font-weight: 400; color: #000;">{{ $order['date'] }}</td>
                <td style="padding: 20px 10px; font-weight: 700; color: #000;">{{ $order['item'] }}</td>
                <td style="padding: 20px 10px; font-weight: 400; color: #000;">{{ $order['total'] }}</td>
                <td style="padding: 20px 10px; text-align: center;">
                    @if($order['transaction'])
                        <div onclick="openTransactionModal('{{ asset('assets/receipt_detail.jpeg') }}')" style="display: inline-block; width: 35px; height: 45px; border: 1px solid #000; padding: 4px; background: #fff; cursor: pointer;">
                            <div style="border: 1px solid #E2E8F0; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-file-invoice" style="font-size: 18px; color: #4A5568;"></i>
                            </div>
                        </div>
                    @else
                        <span style="color: #000; font-weight: 700;">—</span>
                    @endif
                </td>
                <td style="padding: 20px 10px;">
                    <span style="background-color: {{ $order['status_color'] }}; color: #fff; font-size: 11px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                        {{ $order['status'] }}
                    </span>
                </td>
                <td style="padding: 20px 10px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <a href="javascript:void(0)" onclick="openPrintModal({{ json_encode($order) }})" style="color: #000; font-size: 20px;"><i class="fa-solid fa-print"></i></a>
                        @if($order['status'] !== 'Order completed')
                            <a href="javascript:void(0)" onclick="openEditModal({{ json_encode($order) }})" style="color: #000; font-size: 20px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        @else
                            <span style="color: #cbd5e0; font-size: 20px; cursor: not-allowed;"><i class="fa-regular fa-pen-to-square"></i></span>
                        @endif
                        <a href="javascript:void(0)" onclick="openShipModal({{ json_encode($order) }})" style="color: #000; font-size: 20px;"><i class="fa-solid fa-truck"></i></a>
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
        <button onclick="closePrintModal()" class="no-print" style="position: absolute; right: -60px; top: 0; background: #fff; border: 1px solid #000; font-size: 24px; cursor: pointer; color: #000; width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- The "Paper" Container -->
        <div class="paper" style="background: #fff; width: 600px; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; transform: scale(0.9); overflow-y: auto;">
            <div style="text-align: center; margin-bottom: 30px;">
                <span style="font-size: 28px; font-weight: 700; letter-spacing: 2px;">
                    <span style="color: #000;">GEO</span><span style="color: #FFEA00;">RYTHM</span>
                </span>
            </div>

            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 14px; color: #666; font-weight: 500; margin-bottom: 10px;">Adress</h4>
                <div style="border: 1px solid #000; padding: 15px; border-radius: 4px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 13px;">
                    <div>
                        <div style="font-weight: 700;">Indonesia</div>
                        <div id="print_name" style="margin-top: 5px;">Bagoes Hutomo</div>
                        <div id="print_telp" style="margin-top: 15px;">No Telp.09998887776891</div>
                    </div>
                    <div style="text-align: right;">
                        <div id="print_no_top">No Telp.09998887776891</div>
                    </div>
                    <div style="grid-column: span 2; margin-top: 10px; line-height: 1.4;">
                        <div id="print_address">Jl.Biru,RT03/RW06,No 20,Kel.Merah,Kec.Oren,Kota Pelangi</div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; margin-top: 5px;">
                            <div>No.<span id="print_no">20</span></div>
                            <div>Prov: <span id="print_prov">Gradasi</span></div>
                            <div>Kota: <span id="print_city">Pelangi</span></div>
                            <div>Kode Pos: <span id="print_postal">11223</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 14px; color: #666; font-weight: 500; margin-bottom: 10px;">Order</h4>
                <div id="print_items_container" style="border: 1px solid #000; padding: 15px; border-radius: 4px; font-size: 12px; max-height: 150px; overflow-y: auto;">
                    <!-- Items will be injected here -->
                </div>
            </div>

            <div style="margin-bottom: 0px;">
                <h4 style="font-size: 14px; color: #666; font-weight: 500; margin-bottom: 5px;">Order Date</h4>
                <div id="print_date_time" style="font-size: 14px; font-weight: 700; color: #000;">15-2-2026 07.00</div>
            </div>
        </div>

        <!-- Print Button (Outside Paper) -->
        <div style="display: flex; justify-content: center;" class="no-print">
            <button onclick="triggerPrint()" style="background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px 60px; border-radius: 50px; font-weight: 800; font-size: 18px; cursor: pointer; box-shadow: 4px 4px 0px #000; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-print"></i> Print
            </button>
        </div>
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="transactionModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(2px);" onclick="closeTransactionModal()">
    <div style="background: #fff; padding: 10px; border-radius: 4px; position: relative; max-width: 90%; max-height: 90%;" onclick="event.stopPropagation()">
        <button onclick="closeTransactionModal()" style="position: absolute; right: -15px; top: -15px; background: #fff; border: 1px solid #000; width: 30px; height: 30px; border-radius: 50%; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="modalTransactionImage" src="" alt="Transaction Detail" style="display: block; max-width: 100%; max-height: 80vh; border: 1px solid #eee;">
    </div>
</div>

<!-- Order Edit Modal -->
<div id="editModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 450px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px;">
        <button onclick="closeEditModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 24px; font-weight: 800; color: #000; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px;">Edit status order</h3>

        <form action="#" method="POST" id="editOrderForm">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Customer Name</label>
                <div id="edit_customer_name" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 15px; color: #4A5568; background: #F7FAFC; font-weight: 600;">
                    Bagoes Hutomo
                </div>
            </div>

            <div style="margin-bottom: 35px;">
                <label for="order_status" style="display: block; font-size: 14px; font-weight: 700; color: #000; margin-bottom: 8px; text-transform: uppercase;">Selected Status</label>
                <select name="status" id="order_status" style="width: 100%; padding: 12px 15px; border: 1px solid #000; border-radius: 8px; font-size: 15px; color: #000; background: #fff; appearance: none; cursor: pointer; font-weight: 600;">
                    <option value="Process pay">Process pay</option>
                    <option value="packing">Packing</option>
                    <option value="Delivered">Delivery</option>
                    <option value="Order completed">Order completed</option>
                </select>
                <div style="position: absolute; right: 55px; margin-top: -38px; pointer-events: none;">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 14px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; transition: all 0.2s; text-transform: uppercase; letter-spacing: 1px;">
                Update Status
            </button>
        </form>
    </div>
</div>

<!-- Order Edit Success Modal -->
<div id="editSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Success!</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5;">Order status has been successfully updated.</p>
        <button onclick="closeEditSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<!-- Order Shipping Modal -->
<div id="shipModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 650px; border-radius: 12px; position: relative; border: 1px solid #000; padding: 60px;">
        <button onclick="closeShipModal()" style="position: absolute; right: 20px; top: 20px; background: none; border: none; font-size: 32px; cursor: pointer; color: #000;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 style="font-size: 32px; font-weight: 800; color: #000; margin-bottom: 40px; text-align: center;">Receipt Number</h3>

        <form action="#" method="POST" id="shipOrderForm">
            @csrf
            @method('PUT')
            <div style="max-width: 360px; margin: 0 auto;">
                <div style="margin-bottom: 15px;">
                    <input type="text" name="receipt_number" id="receipt_number" placeholder="Receipt Number" style="width: 100%; padding: 10px 20px; border: 1px solid #718096; border-radius: 10px; font-size: 14px; color: #000; outline: none;">
                </div>

                <div style="margin-bottom: 25px; position: relative;">
                    <select name="delivery_service" id="delivery_service" style="width: 100%; padding: 10px 20px; border: 1px solid #718096; border-radius: 10px; font-size: 14px; color: #718096; background: #fff; appearance: none; cursor: pointer; outline: none;">
                        <option value="" disabled selected>Delivery Service</option>
                        <option value="JNE">JNE</option>
                        <option value="JNT">JNT</option>
                        <option value="Anteraja">Anteraja</option>
                    </select>
                    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #000;">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 8px 30px; border-radius: 4px; font-weight: 600; font-size: 14px; cursor: pointer;">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Order Shipping Success Modal -->
<div id="shipSuccessModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1100; backdrop-filter: blur(4px);">
    <div style="background: #fff; width: 400px; border-radius: 12px; position: relative; border: 1px solid #000; box-shadow: 10px 10px 0px #000; padding: 40px; text-align: center;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-truck-fast" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 22px; font-weight: 800; color: #000; margin-bottom: 10px; text-transform: uppercase;">Shipped!</h3>
        <p style="font-size: 15px; color: #4A5568; margin-bottom: 30px; line-height: 1.5;">Receipt number and courier have been updated.</p>
        <button onclick="closeShipSuccessModal()" style="width: 100%; background: #FFEA00; color: #000; border: 2px solid #000; padding: 12px; border-radius: 50px; font-weight: 800; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; text-transform: uppercase;">
            Done
        </button>
    </div>
</div>

<script>
    // Handle Ship Form Submission (Simulated)
    document.getElementById('shipOrderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        closeShipModal();
        document.getElementById('shipSuccessModal').style.display = 'flex';
    });

    function closeShipSuccessModal() {
        document.getElementById('shipSuccessModal').style.display = 'none';
    }

    function openShipModal(order) {
        document.getElementById('receipt_number').value = '';
        document.getElementById('delivery_service').value = '';
        document.getElementById('shipModal').style.display = 'flex';
    }

    function closeShipModal() {
        document.getElementById('shipModal').style.display = 'none';
    }

    // Handle Edit Form Submission (Simulated)
    document.getElementById('editOrderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        closeEditModal();
        document.getElementById('editSuccessModal').style.display = 'flex';
    });

    function closeEditSuccessModal() {
        document.getElementById('editSuccessModal').style.display = 'none';
        // In a real app, we'd reload or update the UI
    }

    function openEditModal(order) {
        document.getElementById('edit_customer_name').innerText = order.name;
        const statusSelect = document.getElementById('order_status');
        statusSelect.value = order.status;

        const statuses = ['Process pay', 'packing', 'Delivered', 'Order completed'];
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
        document.getElementById('print_no_top').innerText = (order.telp || '-');
        document.getElementById('print_address').innerText = order.address || '-';
        document.getElementById('print_no').innerText = order.no || '-';
        document.getElementById('print_prov').innerText = order.prov || '-';
        document.getElementById('print_city').innerText = order.city || '-';
        document.getElementById('print_postal').innerText = order.postal || '-';
        document.getElementById('print_date_time').innerText = order.date + ' ' + (order.time || '');

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
