@extends('welcome')

@section('content')
    <div class="products-container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h2 style="text-align: center; margin-bottom: 25px; font-weight: 700; color: #2c3e50;">Список заказов</h2>
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="{{ route('order.create') }}"
               class="btn-add-product">
                Сделать заказ
            </a>
        </div>

        @if($orders->isNotEmpty())
            <div class="orders-cards" style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;">
                @foreach($orders as $order)
                    <div class="order-card" style="cursor: pointer;" onclick="window.location='{{ route('order.show', $order) }}'">

                    <h4 style="margin: 0 0 12px 0; color: #000000; font-weight: 700;">Заказ №{{ $order->id }}</h4>
                        <h3 style="margin: 0 0 15px 0; color: #34495e; font-weight: 600;">Пользователь: {{ $order->full_name }}</h3>
                        <p class="p-style"><strong>Дата заявки:</strong> {{ $order->order_date}}</p>
                        <p class="p-style"><strong>Статус:</strong> <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $order->status) }}</span></p>
                        <p class="p-style"><strong>Комментарий:</strong> {{ $order->comment ?? '-' }}</p>
                        <p class="p-style"><strong>Товар:</strong> {{ $order->product->name ?? '—' }}</p>
                        <p class="p-style"><strong>Цена за шт.:</strong>
                            @if($order->product)
                                {{ number_format($order->product->price, 2, ',', ' ') }} ₽
                            @else
                                —
                            @endif
                        </p>
                        <p class="p-style"><strong>Количество:</strong> {{ $order->quantity }}</p>
                        <p style="margin: 5px 0 0 0; font-weight: 700; font-size: 1.1em;">
                            <strong>Итого:</strong>
                            @if($order->product)
                                {{ number_format($order->product->price * $order->quantity, 2, ',', ' ') }} ₽
                            @else
                                —
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; font-size: 1.1em; color: #7f8c8d;">Заказов пока нет.</p>
        @endif
    </div>
@endsection
