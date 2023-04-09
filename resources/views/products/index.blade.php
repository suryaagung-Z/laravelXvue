@extends('templates.main')

@section('main-content')
    <h1>Products</h1>
    @if (session('message'))
        <p style="color:green;">{{ session('message') }}</p>
    @endif
    <a href="/product/add">Add</a>

    <main style="display: flex; gap: 20px;">
        <table border="1" cellpadding="5">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Tanggal Produksi</th>
            </tr>
    
            @foreach ($products as $i => $product)
                <tr>
                    <td>{{ $i+=1 }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->id }} - {{ $product->category->category_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->production_date }}</td>
                </tr>
            @endforeach
        </table>
    
        <table border="1" cellpadding="5">
            <tr>
                <th>Id</th>
                <th>Nama Kategori</th>
            </tr>
    
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->category_name }}</td>
                </tr>
            @endforeach
        </table>
    </main>
@endsection