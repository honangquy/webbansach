<div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title ?? '') }}">
    @error('title')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Ảnh (tải lên từ máy)</label>
    <input type="file" name="image_file" class="form-control">
    @if(!empty($banner->image_path ?? null))
        <div class="mt-2">
            <img src="{{ asset('storage/' . $banner->image_path) }}" style="max-height:120px" />
        </div>
    @endif
    @error('image_file')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Hoặc URL ảnh (ví dụ https://...)</label>
    <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $banner->image_url ?? '') }}">
    @if(!empty($banner->image_url ?? null))
        <div class="mt-2">
            <img src="{{ $banner->image_url }}" style="max-height:120px" />
        </div>
    @endif
    @error('image_url')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Link khi click (tùy chọn)</label>
    <input type="text" name="link" class="form-control" value="{{ old('link', $banner->link ?? '') }}">
    @error('link')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Bắt đầu (start_at)</label>
        <input type="datetime-local" name="start_at" class="form-control" value="{{ old('start_at', isset($banner->start_at) ? $banner->start_at->format('Y-m-d\TH:i') : '') }}">
        @error('start_at')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Kết thúc (end_at)</label>
        <input type="datetime-local" name="end_at" class="form-control" value="{{ old('end_at', isset($banner->end_at) ? $banner->end_at->format('Y-m-d\TH:i') : '') }}">
        @error('end_at')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="active" value="0">
    <input type="checkbox" name="active" value="1" class="form-check-input" id="activeCheck" {{ old('active', $banner->active ?? true) ? 'checked' : '' }}>
    <label for="activeCheck" class="form-check-label">Kích hoạt</label>
</div>
