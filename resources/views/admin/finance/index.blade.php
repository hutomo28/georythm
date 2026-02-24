@extends('admin.layouts.admin')

@section('title', __('admin.finance_report'))

@section('content')
    <h2 class="page-title">{{ __('admin.finance_report') }}</h2>
    <p class="page-subtitle">{{ __('admin.finance_summary') }}</p>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            border-radius: 12px;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-title);
        }

        .stat-meta {
            font-size: 13px;
            color: var(--text-muted);
            font-style: italic;
        }

        .report-section {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 30px;
            margin-top: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        .section-header h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            color: var(--text-title);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 15px;
            vertical-align: middle;
            color: var(--text-main);
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-processing { background-color: #dbeafe; color: #1e40af; }
        .status-shipped { background-color: #fef3c7; color: #92400e; }

        .pagination-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #dcfce7; color: #166534;"><i class="fa-solid fa-money-bill-trend-up"></i></div>
            <div class="stat-label">{{ __('admin.money_in') }}</div>
            <div class="stat-value">Rp{{ number_format($moneyIn, 0, ',', '.') }}</div>
            <div class="stat-meta">{{ __('admin.paid_order_total') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #fee2e2; color: #991b1b;"><i class="fa-solid fa-money-bill-transfer"></i></div>
            <div class="stat-label">{{ __('admin.money_out') }}</div>
            <div class="stat-value">Rp{{ number_format($moneyOut, 0, ',', '.') }}</div>
            <div class="stat-meta">{{ __('admin.estimated_cost') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #fef9c3; color: #854d0e;"><i class="fa-solid fa-hand-holding-dollar"></i></div>
            <div class="stat-label">{{ __('admin.profit') }}</div>
            <div class="stat-value">Rp{{ number_format($profit, 0, ',', '.') }}</div>
            <div class="stat-meta">{{ __('admin.net_profit') }}</div>
        </div>
    </div>

    <div class="report-section">
        <div class="section-header">
            <h3>{{ __('admin.recent_transactions') }}</h3>
        </div>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>{{ __('admin.order_id') }}</th>
                    <th>{{ __('admin.customer') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.total') }}</th>
                    <th>{{ __('admin.profit_20') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPaidOrders as $order)
                <tr>
                    <td style="font-weight: 700;">#{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="font-weight: 700;">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td style="color: #166534; font-weight: 700;">Rp{{ number_format($order->total * 0.20, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 40px;">{{ __('admin.no_transactions') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $recentPaidOrders->links() }}
        </div>
    </div>
@endsection
