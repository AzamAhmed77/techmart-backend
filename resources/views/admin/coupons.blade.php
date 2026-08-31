@extends('admin.layout')

@section('title', 'إدارة الكوبونات — TECH MART')
@section('page_title', 'إدارة الكوبونات والخصومات (Coupons) 🏷️')

@section('content')

<div class="dashboard-two-col">
    <!-- Add Coupon Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-tag" style="color: var(--accent);"></i> إنشاء كود خصم جديد</h3>
        </div>

        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">رمز الكوبون (Coupon Code)</label>
                <input type="text" name="code" class="form-control" placeholder="مثال: SUMMER25" style="text-transform: uppercase; font-weight: bold;" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">نسبة الخصم (%)</label>
                    <input type="number" name="discount_percentage" class="form-control" min="1" max="100" placeholder="20" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الحد الأدنى للطلب ($)</label>
                    <input type="number" step="0.01" name="min_order_amount" class="form-control" placeholder="100.00" value="50" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">أقصى مبلغ خصم ($ اختياري)</label>
                    <input type="number" step="0.01" name="max_discount_amount" class="form-control" placeholder="200.00">
                </div>
                <div class="form-group">
                    <label class="form-label">تاريخ الانتهاء (اختياري)</label>
                    <input type="date" name="expires_at" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                <i class="fa-solid fa-plus-circle"></i>
                <span>إنشاء وتفعيل الكوبون</span>
            </button>
        </form>
    </div>

    <!-- Active Coupons List -->
    <div class="card" style="grid-column: span 1;">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-ticket" style="color: var(--warning);"></i> الكوبونات المتاحة</h3>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>الكود</th>
                        <th>الخصم</th>
                        <th>الحد الأدنى</th>
                        <th>الحالة</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <strong style="color: var(--accent); letter-spacing: 0.5px;">{{ $coupon->code }}</strong>
                            </td>
                            <td>
                                <span style="color: var(--success); font-weight: 800;">{{ $coupon->discount_percentage }}%</span>
                            </td>
                            <td>${{ number_format($coupon->min_order_amount, 2) }}</td>
                            <td>
                                @if($coupon->is_active)
                                    <span class="badge badge-delivered">مفعل</span>
                                @else
                                    <span class="badge badge-cancelled">معطل</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.coupons.toggle', $coupon->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" title="{{ $coupon->is_active ? 'تعطيل' : 'تفعيل' }}">
                                        @if($coupon->is_active)
                                            <i class="fa-solid fa-pause" style="color: var(--warning);"></i>
                                        @else
                                            <i class="fa-solid fa-play" style="color: var(--success);"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                لا توجد كوبونات مسجلة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
