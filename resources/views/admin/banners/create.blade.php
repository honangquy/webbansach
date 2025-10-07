@extends('layouts.admin')

@section('title', 'Thêm banner')
@section('page-title', 'Thêm banner')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.banners._form')
                <button class="btn btn-primary">Lưu</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
