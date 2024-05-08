@extends('layouts.app')
@section('title', 'Data Resep Minuman')

@section('title-header', 'Data Resep Minuman')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Resep Minuman</li>
@endsection

@section('action_btn')
    <a href="{{route('drink-recipes.create')}}" class="btn btn-default">Tambah Data</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Data Resep Minuman</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Nama Minuman</th>
                                    <th>Bahan-bahan</th>
                                    <th>Langkah Pembuatan</th>
                                    <th>Link Pembelian</th>
                                    <th>Dilihat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recipes as $recipe)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $recipe->category->name }}</td>
                                        <td>{{ $recipe->name }}</td>
                                        <td>{{ $recipe->ingredient }}</td>
                                        <td>{{ $recipe->step }}</td>
                                        <td>{{ $recipe->purchase_link }}</td>
                                        <td>{{ $recipe->total_view }}</td>
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('drink-recipes.edit', $recipe->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="{{route('drink-recipes.show', $recipe->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <form id="delete-form-{{ $recipe->id }}" action="{{ route('drink-recipes.destroy', $recipe->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$recipe->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        {{ $recipes->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id){
            Swal.fire({
                title: 'Hapus data',
                text: "Anda akan menghapus data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit()
                }
            })
        }
    </script>
@endsection
