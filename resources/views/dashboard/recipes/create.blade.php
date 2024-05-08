@extends('layouts.app')
@section('title', 'Tambah Data Resep Minuman')

@section('title-header', 'Tambah Data Resep Minuman')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('drink-recipes.index') }}">Data Resep Minuman</a></li>
    <li class="breadcrumb-item active">Tambah Data Resep Minuman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Resep Minuman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('drink-recipes.store') }}" method="POST" role="form"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="category_id">Kategori Minuman</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                        name="category_id" required>
                                        <option value="" selected>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (old('category_id') == $category->id) selected @endif>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="name">Nama Minuman</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Nama Resep Minuman" value="{{ old('name') }}"
                                        name="name" required>

                                    @error('name')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="purchase_link">Link Pembelian</label>
                                    <input type="text" class="form-control @error('purchase_link') is-invalid @enderror"
                                        id="purchase_link" placeholder="Link Pembelian Resep Minuman"
                                        value="{{ old('purchase_link') }}" name="purchase_link" required>

                                    @error('purchase_link')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-between align-items-center mb-0" id="ingredient-form-detail">
                            <div class="col-12 col-md-8 mb-md-0 d-flex justify-content-start">
                                <label>{{ __('Bahan Bahan') }}</label>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-borderless" id="dynamic_field">
                                                    <thead>
                                                        <tr style="background: #DDF5FF;">
                                                            <th>Nama Bahan</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="ingredient-row">
                                                            <td><input type="text" name="ingredient[]"
                                                                    class="form-control" required></td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger mt-2 btn-sm btn_remove">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="text-left">
                                                                <button type="button"
                                                                    class="btn btn-outline-primary btn-md" id="add">
                                                                    Tambah
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="step">Cara Pembuatan</label>
                                    <textarea class="form-control @error('step') is-invalid @enderror" id="step"
                                        placeholder="Cara Pembuatan Resep Minuman" name="step" rows="8" required>{{ old('step') }}</textarea>

                                    @error('step')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                placeholder="Gambar Resep Minuman" name="image">

                            @error('image')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{ route('drink-recipes.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var i = 1;
            $("#add").click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '" class="ingredient-row"><td><input type="text" name="ingredient[]" class="form-control" required/></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger mt-2 btn-sm btn_remove"><i class="fas fa-trash"></i></button></td></tr>'
                );
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
@endsection
