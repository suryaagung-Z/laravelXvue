@extends('..templates.main')

@section('main-content')
    <h1>Product Add</h1>
    <form action="{{ route('product.in') }}" method="POST" style="width: 40%; display: flex; flex-direction: column; gap:20px;">
        @csrf
        <div>
            <label for="product_name">Nama produk :</label>
            <input type="text" name="namaproduk" id="product_name" autocomplete="off">
        </div>

        <div>
            <label for="harga">Harga :</label>
            <input type="number" name="harga" id="harga" autocomplete="off">
        </div>

        <div>
            <label for="product_category">Kategori produk :</label>
            <select name="kategoriproduk" id="product_category">
                <option disabled selected>Pilih</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="production_date">Tanggal produksi :</label>
            <input type="date" name="tanggalproduksi" id="production_date" value="YYYY-MM-DD" autocomplete="off">
        </div>

        <button type="submit">Simpan</button>
    </form>
@endsection