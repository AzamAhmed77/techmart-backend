@extends('admin.layout')

@section('title', 'إدارة المنتجات — TECH MART')
@section('page_title', 'إدارة المنتجات (Products Catalog) 🛍️')

@section('content')

<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 14px;">
        <!-- Filter & Search -->
        <form method="GET" action="{{ route('admin.products') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1;">
            <input type="text" name="search" class="form-control" style="width: 250px;" placeholder="بحث باسم المنتج أو الوصف..." value="{{ request('search') }}">
            
            <select name="category" class="form-select" style="width: 180px;" onchange="this.form.submit()">
                <option value="">جميع الفئات</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-secondary">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>بحث</span>
            </button>
        </form>

        <!-- Add Product Button -->
        <button type="button" class="btn btn-primary" onclick="openAddModal()">
            <i class="fa-solid fa-plus"></i>
            <span>إضافة منتج جديد</span>
        </button>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>اسم المنتج</th>
                    <th>الفئة</th>
                    <th>السعر الحالي</th>
                    <th>السعر السابق</th>
                    <th>المخزون</th>
                    <th>التقييم</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border-color);" onerror="this.src='https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=200';">
                        </td>
                        <td>
                            <strong style="font-size: 13.5px;">{{ $product->name }}</strong>
                            <div style="font-size: 11.5px; color: var(--text-muted); max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $product->description }}
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(121, 40, 202, 0.15); color: #B388FF; border: 1px solid #7928CA;">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: var(--accent); font-size: 14px;">${{ number_format($product->price, 2) }}</strong>
                        </td>
                        <td>
                            @if($product->old_price)
                                <span style="text-decoration: line-through; color: var(--text-muted); font-size: 12px;">
                                    ${{ number_format($product->old_price, 2) }}
                                </span>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 700; color: {{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }};">
                                {{ $product->stock }} قطعة
                            </span>
                        </td>
                        <td>
                            <span style="color: var(--warning); font-weight: bold; font-size: 12.5px;">
                                <i class="fa-solid fa-star"></i> {{ $product->rating }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick='openEditModal(@json($product))' title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج من المتجر؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="حذف">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            لا توجد منتجات مطابقة في الكتالوج.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
</div>

<!-- Modal: Add Product -->
<div class="modal-overlay" id="addModal">
    <div class="modal-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-plus-circle" style="color: var(--accent);"></i> إضافة منتج جديد</h3>
            <i class="fa-solid fa-xmark" style="cursor: pointer; font-size: 20px;" onclick="closeAddModal()"></i>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">اسم المنتج</label>
                <input type="text" name="name" class="form-control" placeholder="مثال: Apple iPhone 16 Pro Max 256GB" required>
            </div>

            <div class="form-group">
                <label class="form-label">الفئة (Category)</label>
                <select name="category" class="form-select" required>
                    <option value="الهواتف الذكية">الهواتف الذكية</option>
                    <option value="اللابتوبات والكمبيوترات">اللابتوبات والكمبيوترات</option>
                    <option value="الساعات الذكية">الساعات الذكية</option>
                    <option value="السماعات والصوتيات">السماعات والصوتيات</option>
                    <option value="الأجهزة اللوحية">الأجهزة اللوحية</option>
                    <option value="الكاميرات والتصوير">الكاميرات والتصوير</option>
                    <option value="الألعاب ومنصات الترفيه">الألعاب ومنصات الترفيه</option>
                    <option value="الشاشات والتلفزيونات">الشاشات والتلفزيونات</option>
                    <option value="إكسسوارات وملحقات">إكسسوارات وملحقات</option>
                    <option value="الشبكات والأجهزة الذكية">الشبكات والأجهزة الذكية</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">السعر ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="999.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">السعر قبل الخصم ($ اختياري)</label>
                    <input type="number" step="0.01" name="old_price" class="form-control" placeholder="1199.00">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">الكمية المتوفرة (المخزون)</label>
                    <input type="number" name="stock" class="form-control" value="50" required>
                </div>
                <div class="form-group" style="display: flex; align-items: center; margin-top: 24px; gap: 8px;">
                    <input type="checkbox" name="is_featured" id="is_featured_add" value="1" checked style="width: 18px; height: 18px; accent-color: var(--accent);">
                    <label for="is_featured_add" class="form-label" style="margin: 0; cursor: pointer;">منتج مميز (Featured)</label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">رابط صورة المنتج (URL)</label>
                <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/..." required>
            </div>

            <div class="form-group">
                <label class="form-label">وصف ومواصفات المنتج</label>
                <textarea name="description" class="form-control" rows="3" placeholder="مواصفات المعالج، الشاشة، البطارية، الكاميرا..." required></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> حفظ وإضافة المنتج</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Product -->
<div class="modal-overlay" id="editModal">
    <div class="modal-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa-solid fa-pen-to-square" style="color: var(--accent);"></i> تعديل بيانات المنتج</h3>
            <i class="fa-solid fa-xmark" style="cursor: pointer; font-size: 20px;" onclick="closeEditModal()"></i>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">اسم المنتج</label>
                <input type="text" id="edit_name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">الفئة (Category)</label>
                <select id="edit_category" name="category" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">السعر ($)</label>
                    <input type="number" step="0.01" id="edit_price" name="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">السعر قبل الخصم ($ اختياري)</label>
                    <input type="number" step="0.01" id="edit_old_price" name="old_price" class="form-control">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">المخزون المتوفر</label>
                    <input type="number" id="edit_stock" name="stock" class="form-control" required>
                </div>
                <div class="form-group" style="display: flex; align-items: center; margin-top: 24px; gap: 8px;">
                    <input type="checkbox" id="edit_is_featured" name="is_featured" value="1" style="width: 18px; height: 18px; accent-color: var(--accent);">
                    <label for="edit_is_featured" class="form-label" style="margin: 0; cursor: pointer;">منتج مميز (Featured)</label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">رابط صورة المنتج (URL)</label>
                <input type="url" id="edit_image_url" name="image_url" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">وصف المنتج</label>
                <textarea id="edit_description" name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">إلغاء</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> حفظ التعديلات</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }
    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    function openEditModal(product) {
        document.getElementById('editForm').action = '/admin/products/' + product.id;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_category').value = product.category;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_old_price').value = product.old_price || '';
        document.getElementById('edit_stock').value = product.stock;
        document.getElementById('edit_is_featured').checked = product.is_featured == 1 || product.is_featured == true;
        document.getElementById('edit_image_url').value = product.image_url;
        document.getElementById('edit_description').value = product.description;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
@endsection
