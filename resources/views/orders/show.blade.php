@extends('welcome')

@section('content')
    <div class="order-details-container" style="max-width: 700px; margin: 0 auto; padding: 20px;">

        <h2 style="text-align: center; margin-bottom: 30px;">Детали заказа №{{ $order->id }}</h2>

        <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <p><strong>Пользователь:</strong> {{ $order->full_name }}</p>
            <p><strong>Дата заявки:</strong> {{ $order->order_date }}</p>
            <p><strong>Комментарий:</strong> {{ $order->comment ?? '-' }}</p>

            <hr style="margin: 20px 0;">

            <h3>Информация о товаре</h3>
            @if($order->product)
                <p><strong>Название:</strong> {{ $order->product->name }}</p>
                <p><strong>Описание:</strong> {{ $order->product->description ?? 'Описание отсутствует' }}</p>
                <p><strong>Цена за шт.:</strong> {{ number_format($order->product->price, 2, ',', ' ') }} ₽</p>
            @else
                <p>Товар не найден</p>
            @endif

            <p><strong>Количество:</strong> {{ $order->quantity }}</p>
            <p style="font-weight: 700; font-size: 1.2em; margin-top: 15px;">
                Итого:
                @if($order->product)
                    {{ number_format($order->product->price * $order->quantity, 2, ',', ' ') }} ₽
                @else
                    —
                @endif
            </p>

            <hr style="margin: 25px 0;">

            <form action="{{ route('order.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <label for="status" style="font-weight: 600;">Статус заказа:</label>
                <select name="status" id="status" style="padding: 8px; margin: 10px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="новый" {{ $order->status === 'новый' ? 'selected' : '' }}>Новый</option>
                    <option value="выполнен" {{ $order->status === 'выполнен' ? 'selected' : '' }}>Выполнен</option>
                </select>
                @error('status')
                <div class="error" style="color: red; margin-bottom: 10px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-submit" style="padding: 10px 15px; background-color: #38b000; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                    Обновить статус
                </button>
            </form>
        </div>
    </div>
@endsection
