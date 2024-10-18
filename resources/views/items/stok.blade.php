@extends('templates.app')

@section('content-dinamis')  
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Daftar Barang</h3>
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
@endsection
