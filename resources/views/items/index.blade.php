@extends('templates.app')

@section('content-dinamis')  
@if(Session::get('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif 
@if(Session::get('deleted'))
<div class="alert alert-success">{{Session::get('deleted')}}</div>
@endif 

    <a class="btn btn-light shadow-sm px-3 py-2" href="{{ route('item.create') }}" style="border-radius: 0; width: 150px;">
        <i class="fa fa-plus me-2"></i> Tambah
    </a>


    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Daftar Barang</h3>
            </div>
           
            <div class="card-header bg-primary">
                <form class="d-flex" action="{{route('item.home')}}" role="search" method="GET">
                    <input type="search" name="search" aria-label="Search" class="form-control me-2" placeholder="Cari Barang">
                    <button class="btn btn-outline-success" type="submit" style="background-color: white; color: black; border-color: white;">
                        Search
                    </button>
                  </form>
            </div>
            <div class="card-body">
                <table class="table table-responsive-md table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($items as $index => $item)
                        <tr>
                            <td>{{ ($items->currentPage() - 1) * $items->perPage() + ($index + 1) }}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['type']}}</td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }} IDR</td>
                            <td>{{$item['stok']}}</td>
                            <td class="text-center">
                                <a href="{{route('item.update', $item['id'])}}" class="btn btn-sm btn-outline-info me-2"><i class="fas fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-outline-danger" onclick="showModalDelete({{$item['id']}},'{{$item['name']}}')"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>

    {{--modal hapus--}}
    <div class="modal fade" id="ModalDeleteBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-barang" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data Barang <span id="nama-barang" class="fw-bold"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script>
        function showModalDelete(id,name) {
            let action = '{{route('item.delete',':id')}}';
            action =action.replace(':id',id);
            $('#form-delete-barang').attr('action',action);
            $('#ModalDeleteBarang').modal('show');
            $('nama-barang').text(name);
        }

       
    </script>
    @endpush


@endsection
