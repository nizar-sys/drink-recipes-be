@extends('layouts.app')
@section('title', 'Data Resep Minuman')

@section('title-header', 'Data Resep Minuman')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('drink-recipes.index') }}">Data Resep Minuman</a></li>
    <li class="breadcrumb-item active">Data Resep Minuman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h3 class="mb-0">Data Resep Minuman {{ $recipe->name }}</h3>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('drink-recipes.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('/uploads/images/' . $recipe->image) }}" alt="{{ $recipe->name }}"
                                class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h4>{{ $recipe->name }}</h4>
                            <p>Kategori: {{ $recipe->category->name }}</p>
                            <p>Bahan-bahan:</p>
                            <ul>
                                @foreach (explode(', ', $recipe->ingredient) as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            </ul>
                            <p>Langkah Pembuatan:</p>
                            <p>{{ $recipe->step }}</p>
                            <p>Link Pembelian: <a href="{{ $recipe->purchase_link }}"
                                    target="_blank">{{ $recipe->purchase_link }}</a></p>
                            <p>Dilihat: {{ $recipe->total_view }} kali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h3 class="mb-0">Komentar</h3>
                </div>

                <div class="card-body">
                    <!-- Daftar komentar -->
                    <div class="mt-4">
                        @forelse ($recipe->comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $comment->user->name }}</h5>
                                    <p class="card-text">{{ $comment->comment }}</p>
                                </div>
                                <!-- Daftar balasan -->
                                @if (count($comment->children) > 0)
                                    <div class="card-body bg-light">
                                        @foreach ($comment->children as $reply)
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $reply->user->name }}</h6>
                                                    <p class="card-text">{{ $reply->comment }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-center font-weight-bold">Belum ada komentar</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        @foreach ($resepRecommendation as $item)
            <div class="col-sm-12 col-md-4 mb-4">
                <div class="card shadow">
                    <img src="{{ asset('/uploads/images/' . $item->image) }}" alt="{{ $item->name }}"
                        class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->category->name }}</p>
                        <p class="card-text"><strong>Bahan-bahan:</strong></p>
                        <ul>
                            @foreach (explode(', ', $item->ingredient) as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('drink-recipes.show', $item->id) }}" class="btn btn-primary">Lihat Resep</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
