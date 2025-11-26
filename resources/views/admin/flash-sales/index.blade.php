@extends('layouts.admin')

@section('title', 'Quản lý Flash Sale')

@section('page-title', 'Quản lý Flash Sale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Danh sách Flash Sale</h3>
    <a href="{{ route('admin.flash-sales.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tạo Flash Sale mới
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tiêu đề</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th style="width: 100px;">Số sản phẩm</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 120px;">Tình trạng</th>
                        <th style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flashSales as $flashSale)
                    <tr>
                        <td>{{ $flashSale->id }}</td>
                        <td>
                            <strong>{{ $flashSale->title }}</strong>
                            @if($flashSale->description)
                                <br><small class="text-muted">{{ Str::limit($flashSale->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <small>{{ $flashSale->start_time->format('d/m/Y') }}</small><br>
                            <small class="text-muted">{{ $flashSale->start_time->format('H:i') }}</small>
                        </td>
                        <td>
                            <small>{{ $flashSale->end_time->format('d/m/Y') }}</small><br>
                            <small class="text-muted">{{ $flashSale->end_time->format('H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $flashSale->items_count }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.flash-sales.toggle-status', $flashSale->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $flashSale->status ? 'btn-success' : 'btn-secondary' }} w-100">
                                    {{ $flashSale->status ? 'Bật' : 'Tắt' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            @if($flashSale->hasEnded())
                                <span class="badge bg-secondary">Đã kết thúc</span>
                            @elseif($flashSale->isActive())
                                <span class="badge bg-success">Đang diễn ra</span>
                            @elseif(!$flashSale->hasStarted())
                                <span class="badge bg-warning">Sắp diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Không hoạt động</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.flash-sales.edit', $flashSale->id) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.flash-sales.show', $flashSale->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.flash-sales.destroy', $flashSale->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa Flash Sale này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có Flash Sale nào. Hãy tạo Flash Sale đầu tiên!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $flashSales->links() }}
</div>
@endsection
