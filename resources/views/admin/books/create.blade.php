@extends('layouts.admin')

@section('title', 'Thêm sách mới')
@section('page-title', 'Thêm sách mới')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin sách</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tên sách <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Tác giả <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                               id="author" name="author" value="{{ old('author') }}" required>
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" name="category_id" required>
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                               id="isbn" name="isbn" value="{{ old('isbn') }}">
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pages" class="form-label">Số trang</label>
                                        <input type="number" class="form-control @error('pages') is-invalid @enderror" 
                                               id="pages" name="pages" value="{{ old('pages') }}" min="1">
                                        @error('pages')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="publisher" class="form-label">Nhà xuất bản</label>
                                        <input type="text" class="form-control @error('publisher') is-invalid @enderror" 
                                               id="publisher" name="publisher" value="{{ old('publisher') }}">
                                        @error('publisher')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="publish_date" class="form-label">Ngày xuất bản</label>
                                        <input type="date" class="form-control @error('publish_date') is-invalid @enderror" 
                                               id="publish_date" name="publish_date" value="{{ old('publish_date') }}">
                                        @error('publish_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="image" class="form-label">Ảnh bìa sách</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Chọn file ảnh (JPEG, PNG, JPG, GIF). Tối đa 2MB. Nếu bạn tải ảnh lên, nó sẽ được ưu tiên so với link ảnh bên dưới.</div>
                            </div>

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Hoặc dán link ảnh bìa</label>
                                <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                       id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/cover.jpg">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Dán link ảnh nếu bạn muốn dùng ảnh từ URL (không cần upload). Nếu cả hai cùng có, file upload sẽ được dùng.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Xem trước ảnh bìa</label>
                                <div>
                                    <img id="imagePreview" src="" alt="Preview" class="img-fluid" style="max-height:260px; display:none; border-radius:6px;" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" min="0" step="1000" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                           id="sale_price" name="sale_price" value="{{ old('sale_price') }}" min="0" step="1000">
                                    <span class="input-group-text">đ</span>
                                </div>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">Số lượng trong kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">
                                        Sách nổi bật
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        Đang bán
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu sách
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const imageUrlInput = document.getElementById('image_url');
    const preview = document.getElementById('imagePreview');

    function showPreview(src) {
        if (!src) { preview.style.display = 'none'; preview.src = ''; return; }
        preview.src = src;
        preview.style.display = 'block';
    }

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    showPreview(ev.target.result);
                };
                reader.readAsDataURL(file);
                // clear URL input when a file is chosen
                if (imageUrlInput) imageUrlInput.value = '';
            } else {
                if (imageUrlInput && imageUrlInput.value) showPreview(imageUrlInput.value);
                else showPreview(null);
            }
        });
    }

    if (imageUrlInput) {
        imageUrlInput.addEventListener('input', function(e) {
            const url = e.target.value.trim();
            // only preview URL if no file is selected
            if (!imageInput || !imageInput.files.length) {
                showPreview(url || null);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // On load, if there's an old URL value (from validation), preview it
        if ((imageInput && imageInput.files && imageInput.files.length)) {
            // file inputs can't be prefilled for security reasons
        } else if (imageUrlInput && imageUrlInput.value) {
            showPreview(imageUrlInput.value);
        }
    });
</script>
@endpush