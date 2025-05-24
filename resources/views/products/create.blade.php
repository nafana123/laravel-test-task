@extends('welcome')

@section('content')
    <div class="form-container">
        <h2>Добавить новый товар</h2>

        <form action="{{ route('product.store') }}" method="POST">
            @csrf
            <label for="name">Название товара <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" >
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="category_id">Категория <span class="required">*</span></label>
            <select id="category_id" name="category_id" >
                <option value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="description">Описание</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>

            <label for="price">Цена<span class="required">*</span></label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01">
            @error('price')
            <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-submit">Сохранить</button>
        </form>
    </div>
@endsection
