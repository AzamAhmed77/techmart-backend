@extends('admin.layout')

@section('title', 'إدارة الطلبات — TECH MART')
@section('page_title', 'إدارة الطلبات (Orders Management) 📦')

@section('content')

<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 14px;">
        <!-- Filters & Search -->
        <form method="GET" action="{{ route('admin.orders') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1;">
            <input type="text" name="search" class="form-control" style="width: 250px;" placeholder="بحث برقم الطلب، الاسم، الهاتف..." value="{{ request('search') }}">
            
            <select name="status" class="form-select" style="width: 180px;" onchange="this.form.submit()">
                <option value="">جميع الحالات</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار (Pending)</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد التجهيز (Processing)</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن (Shipped)</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التسليم (Delivered)</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي (Cancelled)</option>
            </select>

            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>بحث</span>
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm" title="إعادة ضبط">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>العميل / المستلم</th>
                    <th>عنوان التوصيل</th>
                    <th>المنتجات والكميات</th>
                    <th>المبلغ الإجمالي</th>
                    <th>وسيلة الدفع</th>
                    <th>الحالة الحالية</th>
                    <th>تحديث الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong style="color: var(--accent); font-size: 14px;">#{{ $order->order_number }}</strong>
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 700;">{{ $order->recipient_name }}</div>
                            <div style="font-size: 12px; color: var(--text-muted);"><i class="fa-solid fa-phone"></i> {{ $order->phone }}</div>
                        </td>
                        <td>
                            <div style="max-width: 180px; font-size: 12.5px;">
                                <strong>{{ $order->city }}</strong> - {{ $order->shipping_address }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 12px;">
                                @foreach($order->items as $item)
                                    <div style="margin-bottom: 2px;">
                                        • {{ $item->product_name }} <strong style="color: var(--accent);">(x{{ $item->quantity }})</strong>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <strong style="font-size: 15px; color: var(--success);">${{ number_format($order->total, 2) }}</strong>
                            @if($order->discount > 0)
                                <div style="font-size: 11px; color: var(--warning);">خصم: ${{ number_format($order->discount, 2) }}</div>
                            @endif
                        </td>
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
                        <td>
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display: flex; gap: 6px;">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" style="padding: 4px 8px; font-size: 12px; width: 130px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد التجهيز</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm" title="حفظ التعديل">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            لا توجد طلبات مطابقة للبحث أو الفلتر.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $orders->links() }}
    </div>
</div>

@endsection
