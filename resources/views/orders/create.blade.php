@extends('welcome')

@section('content')
    <div class="form-container">
        <h2>Создать новую заявку</h2>

        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            <label for="full_name">ФИО <span class="required">*</span></label>
            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}">
            @error('full_name')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="order_date">Дата заявки <span class="required">*</span></label>
            <input type="date" id="order_date" name="order_date" value="{{ old('order_date') }}">
            @error('order_date')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="comment">Комментарий</label>
            <textarea id="comment" name="comment">{{ old('comment') }}</textarea>

            <label for="product_id">Товар <span class="required">*</span></label>
            <select id="product_id" name="product_id">
                <option value="">Выберите товар</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
            @error('product_id')
            <div class="error">{{ $message }}</div>
            @enderror
            <div id="product-price" style="margin-top: 5px; font-weight: 600; color: #27ae60;">
                @if(old('product_id'))
                    Цена:{{number_format($products->firstWhere('id', old('product_id'))->price,2,',',' ')}} ₽
                @endif
            </div>

            <label for="quantity">Количество <span class="required">*</span></label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') ?? 1 }}" min="1" step="1">
            @error('quantity')
            <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-submit">Создать заявку</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product_id');
            const priceDiv = document.getElementById('product-price');

            function updatePrice() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                if (price) {
                    priceDiv.textContent = 'Цена за шт.: ' + Number(price).toLocaleString('ru-RU', { minimumFractionDigits: 2 }) + ' ₽';
                } else {
                    priceDiv.textContent = '';
                }
            }

            productSelect.addEventListener('change', updatePrice);

            updatePrice();
        });
    </script>
@endsection
