@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid">
    <h1 class="display-6 mb-3">Избранные лоты <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-star mb-2" viewBox="0 0 16 16">
        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
        </svg></h1>
        @if(count($pageInfo->favoriteProducts) != 0)
            <div class="table-responsive" style="max-height:500px">
                <table class="table table-striped table">
                <thead>
                    <tr>
                    <th scope="col">Наименование лота</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Начальная цена</th>
                    <th scope="col">Прием заявок до</th>
                    <th scope="col">Фото лота</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($pageInfo->favoriteProducts as $product)
                        <tr>
                            <td><a href="{{ route('product.index', ['id' => $product->id]) }}">{{ $product->name }}</a></td>
                            <td>
                                <a href="{{ route('category.index', ['id' => $product->category->id]) }}">{{ $product->category->name }}</a>
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->date_end }}</td>
                            <td><img width="150" src="{{ asset('storage/images/'.$product->picture) }}" alt="" title=""></a></td>
                            <td>
                                <form action={{ route('favorite.delete', [$product->id]) }} method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"></path>
                                        </svg>
                                        Убрать
                                    </button>
            
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                </tbody>
                </table>
            </div>
        @else
        <h4 class="mb-3 lh-2">У вас нет лотов в избранном</h4>
        @endif

    </div>
</div>

<div class="row align-items-md-stretch">
    <div class="col-md-6">
    <div class="h-100 px-5 py-4  text-bg-light rounded-3">
        <h2 class="display-6 mb-3">Популярные категории</h2>
        @if(count($pageInfo->popularCategories) != 0)
        <div class="table-responsive" style="max-height:300px">
        <table class="table table-striped table">
            <thead>
            <tr>
                <th scope="col">Категория</th>
                <th scope="col">Кол-во комментариев</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pageInfo->popularCategories as $category)
                <tr>
                    
                    <td><a href="{{ route('category.index', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->count_reviews }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @else
        <h4 class="mb-3 lh-2">Нет популярных</h4>
        @endif
    </div>
    </div>
    <div class="col-md-6">
        <div class="h-100 px-5 py-4 text-bg-light rounded-3">
            <h2 class="display-6 mb-3">Лоты и категории</h2>
            <div class="input-group mb-3">
                <form class="row g-3" action="{{route('main')}}" method="GET">
                    
                    <div class="col-auto">
                        <input type="text" name="search" value="{{ $pageInfo->search }}" class="form-control" placeholder="Лот или категория" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-secondary" type="submit">Поиск</button>
                    </div>
                </form> 
            </div>
            @if(count($pageInfo->searchedCategories) != 0 || count($pageInfo->searchedProducts) != 0)
            <div class="table-responsive" style="max-height:300px">
                <table class="table table-striped table">
                <thead>
                    <tr>
                    <th scope="col">Наименование</th>
                    <th scope="col">Тип</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pageInfo->searchedCategories as $category)
                        <tr>
                            <td><a href="{{ route('category.index', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                            <td>Категория</td>
                        </tr>
                    @endforeach
                    @foreach ($pageInfo->searchedProducts as $product)
                        <tr>
                            <td><a href="">{{ $product->name }}</a></td>
                            <td>Лот</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            @else 
                <h5 class="mb-3 lh-2">Совпадений не найдено</h5>
            @endif
        </div>
    </div>
</div>
@endsection

