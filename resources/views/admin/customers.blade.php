@extends('admin.layout')

@section('title', 'قائمة العملاء — TECH MART')
@section('page_title', 'قائمة العملاء المسجلين (Customers) 👥')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-users" style="color: var(--accent);"></i> بيانات حسابات العملاء</h3>
        <span style="color: var(--text-muted); font-size: 13px;">إجمالي المسجلين: {{ $customers->total() }} عميل</span>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>البريد الإلكتروني</th>
                    <th>حالة التحقق (Email Verified)</th>
                    <th>عدد الطلبات</th>
                    <th>تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), #7928CA); display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; font-size: 14px;">
                                    {{ mb_substr($user->name, 0, 1, 'utf-8') }}
                                </div>
                                <strong style="font-size: 14px;">{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <span style="color: var(--text-muted);">{{ $user->email }}</span>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge badge-delivered">
                                    <i class="fa-solid fa-circle-check"></i> موثق (Verified)
                                </span>
                            @else
                                <span class="badge badge-pending">
                                    <i class="fa-solid fa-clock"></i> بانتظار التحقق
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong style="color: var(--accent); font-size: 14px;">{{ $user->orders_count }} طلب</strong>
                        </td>
                        <td style="font-size: 12.5px; color: var(--text-muted);">
                            {{ $user->created_at->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            لا يوجد عملاء مسجلين بعد.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $customers->links() }}
    </div>
</div>

@endsection
