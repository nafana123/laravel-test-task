@extends('welcome')

@section('content')
    <div class="product-view-container">
        <h2>Просмотр товара</h2>

        <h3>{{ $product->name }}</h3>
        <p><strong>Цена:</strong> {{ number_format($product->price, 2, ',', ' ') }} ₽</p>
        <p><strong>Описание:</strong> {{ $product->description ?? 'Описание отсутствует' }}</p>
        <p><strong>Категория:</strong> {{ $product->category->name }}</p>

        <a href="{{ route('product.index') }}" class="btn-back">Назад к списку</a>
    </div>
@endsection
