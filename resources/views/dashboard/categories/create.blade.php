@extends('layouts.app')
@section('title', 'Tambah Data Kategori')

@section('title-header', 'Tambah Data Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Data Kategori</a></li>
    <li class="breadcrumb-item active">Tambah Data Kategori</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST" role="form"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row justify-content-center align-items-center">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Nama Kategori" value="{{ old('name') }}"
                                        name="name">

                                    @error('name')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
