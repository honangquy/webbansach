@extends('layouts.admin')

@section('title', 'Sửa banner')
@section('page-title', 'Sửa banner')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.banners._form')
                <button class="btn btn-primary">Lưu</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
