@extends('admin.layout')

@section('title', 'نظرة عامة — TECH MART')
@section('page_title', 'لوحة التحكم والتحليلات 📊')

@section('styles')
<style>
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 20px;
        margin-bottom: 26px;
    }

    .metric-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 22px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 14px;
    }

    .icon-revenue { background: rgba(0, 230, 118, 0.12); color: var(--success); }
    .icon-orders { background: rgba(0, 210, 255, 0.12); color: var(--accent); }
    .icon-products { background: rgba(121, 40, 202, 0.15); color: #B388FF; }
    .icon-customers { background: rgba(255, 214, 0, 0.12); color: var(--warning); }

    .metric-title {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .metric-value {
        font-size: 26px;
        font-weight: 900;
        color: #fff;
    }

    .status-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 26px;
    }

    .status-pill {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .status-pill-info span {
        display: block;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .status-pill-info strong {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
    }

    .dashboard-two-col {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1100px) {
        .dashboard-two-col { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <!-- Top Metrics -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon icon-revenue">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="metric-title">إجمالي المبيعات والأرباح</div>
            <div class="metric-value">${{ number_format($totalRevenue, 2) }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-icon icon-orders">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div class="metric-title">إجمالي الطلبات</div>
            <div class="metric-value">{{ number_format($totalOrders) }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-icon icon-products">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="metric-title">إجمالي المنتجات بالمتجر</div>
            <div class="metric-value">{{ number_format($totalProducts) }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-icon icon-customers">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <div class="metric-title">العملاء المسجلين</div>
            <div class="metric-value">{{ number_format($totalCustomers) }}</div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="status-summary">
        <div class="status-pill" style="border-right: 4px solid var(--warning);">
            <div class="status-pill-info">
                <span>طلبات قيد الانتظار</span>
                <strong>{{ $pendingOrdersCount }}</strong>
            </div>
            <i class="fa-solid fa-clock text-warning" style="font-size: 22px; color: var(--warning);"></i>
        </div>

        <div class="status-pill" style="border-right: 4px solid var(--info);">
            <div class="status-pill-info">
                <span>طلبات قيد التجهيز</span>
                <strong>{{ $processingOrdersCount }}</strong>
            </div>
            <i class="fa-solid fa-arrows-rotate" style="font-size: 22px; color: var(--info);"></i>
        </div>

        <div class="status-pill" style="border-right: 4px solid var(--success);">
            <div class="status-pill-info">
                <span>طلبات تم تسليمها</span>
                <strong>{{ $deliveredOrdersCount }}</strong>
            </div>
            <i class="fa-solid fa-circle-check" style="font-size: 22px; color: var(--success);"></i>
        </div>
    </div>

    <div class="dashboard-two-col">
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-receipt" style="color: var(--accent);"></i>
                    <span>أحدث الطلبات المستلمة</span>
                </div>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">عرض الكل</a>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المبلغ</th>
                            <th>الدفع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><strong style="color: var(--accent);">#{{ $order->order_number }}</strong></td>
                                <td>
                                    <div>{{ $order->recipient_name }}</div>
                                    <small style="color: var(--text-muted);">{{ $order->phone }}</small>
                                </td>
                                <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                <td>
                                    <span class="badge" style="background: rgba(255,255,255,0.06); color: #fff;">
                                        {{ strtoupper($order->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        {{ $order->status_arabic }}
                                    </span>
                                </td>
                                <td style="font-size: 12px; color: var(--text-muted);">
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    لا توجد طلبات مستلمة بعد.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fa-solid fa-star" style="color: var(--warning);"></i>
                    <span>أعلى المنتجات تقييماً</span>
                </div>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary btn-sm">الكتالوج</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                @forelse($topProducts as $prod)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 10px; background: var(--bg-card); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 10px;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $prod->name }}</div>
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted);">
                                <span style="color: var(--accent); font-weight: bold;">${{ number_format($prod->price, 2) }}</span>
                                <span>•</span>
                                <span style="color: var(--warning);"><i class="fa-solid fa-star"></i> {{ $prod->rating }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--text-muted); padding: 20px;">لا توجد منتجات.</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
