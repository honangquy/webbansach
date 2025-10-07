@extends('layouts.admin')

@section('title', 'Quản lý banner')

@section('page-title', 'Quản lý banner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Danh sách banner</h3>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm banner</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tiêu đề</th>
            <th>Start</th>
            <th>End</th>
            <th>Active</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($banners as $banner)
        <tr>
            <td>{{ $banner->id }}</td>
            <td style="width:180px">
                @if($banner->image_path)
                    <img src="{{ asset('storage/' . $banner->image_path) }}" alt="" class="img-fluid" style="max-height:60px">
                @elseif($banner->image_url)
                    <img src="{{ $banner->image_url }}" alt="" class="img-fluid" style="max-height:60px">
                @endif
            </td>
            <td>{{ $banner->title }}</td>
            <td>{{ optional($banner->start_at)->format('Y-m-d H:i') }}</td>
            <td>{{ optional($banner->end_at)->format('Y-m-d H:i') }}</td>
            <td>{{ $banner->active ? 'Có' : 'Không' }}</td>
            <td>
                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-secondary">Sửa</a>
                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xóa?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $banners->links() }}

@endsection
