@extends('templates.app')

@section('content-dinamis')
            {{-- @dd($items) --}}
    <form action="{{route('orders.store')}}" method="POST" class="card d-block mx-auto my-3 p-5">
        @csrf
        <h1 class="text-center">Buat Pembelian</h1>
        @if (Session::get('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{Session::get('failed')}}</div>
        @endif
        <div class="form-group">
            <label for="name_customer" class="form-label">Nama Pembeli</label>
            <input type="text" id="name_customer" name="name_customer" class="form-control" placeholder="Masukkan Nama Customer" value="{{ old('name_customer') }}">
            @error('name_customer')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>    

        @if (old('items'))
        @foreach (old('items') as $no => $item)
             <div class="form-group" id="items-{{$no}}">
            <label for="name_items" class="form-label">Obat {{$no+1}}</label>
            @if ($no > 0)
                <span style="cursor: pointer; font-weight:bold" class="text-danger" onclick="deleteSelect('items-{{$no}}')">X</span>
            @endif

            <select name="items[]" id="item" class="form-select">
                <option disabled selected hidden>PILIH</option>
                @foreach ($items as $itemData)
                @if ($itemData['stok'] > 0)
                <option value="{{ $itemData['id'] }}"{{$item==$itemData['id'] ? 'selected' : ''}}>{{ $itemData['name'] }} - Rp.{{number_format ($itemData['price'],0,'.','.')}}</option>
                @endif
                @endforeach
            </select>
        </div>
        @endforeach
        @else

        <div class="form-group">
            <label for="name_items" class="form-label">Item 1</label>
            <select name="items[]" id="item" class="form-select">
                <option disabled selected hidden>PILIH</option>
                @foreach ($items as $itemData)
                    @if ($itemData['stok'] > 0)
                    <option value="{{ $itemData['id'] }}" >{{ $itemData['name'] }} - Rp.{{number_format ($itemData['price'],0,'.','.')}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        @endif

        <div id="items-more"></div>
        <span class="text-primary" style="font-weight:bold; cursor:pointer" id="btn-more">Tambah Item</span>
        <br>
        <button class="btn btn-primary" type="submit">Beli</button>
        <a class="btn btn-primary"  href="{{route('orders')}}">Kembali</a>
    </form>    
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let no = {{ old('items') ? count(old('items'))+1 : 2 }};
    $("#btn-more").on("click",function(){
        let elSelect = `<div class="form-group" id="items-${no}">
            <label for="name_items" class="form-label">Item ${no}  <span style="cursor: pointer; font-weight:bold" class="text-danger" onclick="deleteSelect('items-${no}') ">X</span></label>
            <select name="items[]" id="item" class="form-select">
                <option disabled selected hidden>PILIH</option>
                @foreach ($items as $itemData)
                      @if ($itemData['stok'] > 0)
                    <option value="{{ $itemData['id'] }}">{{ $itemData['name'] }} - Rp.{{number_format ($itemData['price'],0,'.','.')}}</option>
                    @endif
                @endforeach
            </select>
        </div>`

        $("#items-more").append(elSelect);
        
        no++;
    });

    function deleteSelect(elementId){
        let elementIdForDelete = "#" + elementId;
        $(elementIdForDelete).remove();
        no--;
    }
</script>
@endpush

@push('style')
<!-- Styling Anda tetap sama -->
@endpush
