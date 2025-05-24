@extends('welcome')

@section('content')
    @php
        $editProductId = session('editProductId');
    @endphp

    <div class="products-container">
        <h2>Список товаров</h2>

        <a href="{{ route('product.create') }}" class="btn-add-product">Добавить товар</a>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($products->isNotEmpty())
            <div class="product-list">
                @foreach($products as $product)
                    @php
                        $isEditing = ($editProductId == $product->id);
                    @endphp

                    <div class="product-card" id="product-card-{{ $product->id }}">
                        <form action="{{ route('product.update', $product->id) }}" method="POST" class="product-form">
                            @csrf
                            @method('PUT')

                            <div class="view-mode" style="{{ $isEditing ? 'display:none;' : '' }}">
                                <h3>{{ $product->name }}</h3>
                                <p><strong>Цена:</strong> {{ number_format($product->price, 2, ',', ' ') }} ₽</p>
                                <p><strong>Описание:</strong> {{ $product->description ?? 'Описание отсутствует' }}</p>
                                <p><strong>Категория:</strong> {{ $product->category->name ?? 'Без категории' }}</p>

                                <div class="actions">
                                    <a href="{{ route('product.show', $product->id) }}" class="btn-view">Просмотр</a>

                                    <button type="button" class="btn-edit" onclick="enableEditBtn({{ $product->id }})">Редактировать</button>
                                </div>
                            </div>

                            <div class="edit-mode" style="{{ $isEditing ? 'display:block;' : 'display:none;' }}">
                                <label for="name-{{ $product->id }}">Название<span class="required">*</span></label>
                                <input id="name-{{ $product->id }}" type="text" name="name" class="input"
                                       value="{{ old('name', $product->name) }}">
                                <div id="error-name-{{ $product->id }}" class="error">@error('name'){{ $message }}@enderror</div>

                                <label for="price-{{ $product->id }}">Цена<span class="required">*</span></label>
                                <input id="price-{{ $product->id }}" type="number" step="0.01" name="price" class="input"
                                       value="{{ old('price', $product->price) }}">
                                <div id="error-price-{{ $product->id }}" class="error">@error('price'){{ $message }}@enderror</div>

                                <label for="description-{{ $product->id }}">Описание</label>
                                <textarea id="description-{{ $product->id }}" name="description" class="input">{{ old('description', $product->description) }}</textarea>
                                <div id="error-description-{{ $product->id }}" class="error">@error('description'){{ $message }}@enderror</div>

                                <label for="category-{{ $product->id }}">Категория<span class="required">*</span></label>
                                <select id="category-{{ $product->id }}" name="category_id" class="input">
                                    <option value="">Без категории</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="error-category_id-{{ $product->id }}" class="error">@error('category_id'){{ $message }}@enderror</div>

                                <div class="actions">
                                    <button type="button" class="btn-save" onclick="submitEditForm({{ $product->id }})">Сохранить</button>
                                    <button type="button" class="btn-cancel" onclick="cancelEdit({{ $product->id }})">Отменить</button>
                                </div>
                            </div>
                        </form>

                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Удалить этот товар?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Удалить</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p>Товаров пока нет.</p>
        @endif
    </div>

    <script>
        function enableEditBtn(id) {
            const card = document.getElementById(`product-card-${id}`);
            const editMode = card.querySelector('.edit-mode');
            const viewMode = card.querySelector('.view-mode');

            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        }

        function cancelEdit(id) {
            const card = document.getElementById(`product-card-${id}`);
            const editMode = card.querySelector('.edit-mode');
            const viewMode = card.querySelector('.view-mode');

            card.querySelectorAll('.error').forEach(el => el.textContent = '');

            editMode.style.display = 'none';
            viewMode.style.display = 'block';
        }

        function submitEditForm(productId) {
            const card = document.getElementById(`product-card-${productId}`);
            const form = card.querySelector('.product-form');

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
                body: formData
            })
                .then(response => {
                    if(response.ok) {
                        return response.json();
                    } else {
                        return response.json().then(data => Promise.reject(data));
                    }
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(data => {
                    card.querySelectorAll('.error').forEach(el => el.textContent = '');

                    if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const errorDiv = card.querySelector(`#error-${field}-${productId}`);
                            if (errorDiv) {
                                errorDiv.textContent = messages.join(', ');
                            }
                        }
                    } else {
                        location.reload();
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if($editProductId)
            enableEditBtn({{ $editProductId }});
            @endif
        });
    </script>
@endsection
