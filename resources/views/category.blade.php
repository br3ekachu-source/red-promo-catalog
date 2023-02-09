@extends('layouts.app')

@section('title', 'Категории | '.$category->name)

@section('content')

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid">
    <h1 class="display-6 mb-3">Лоты категории: {{ $category->name }}</h1>
        @if(count($products) != 0)
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('category.index', [
                'id' => $category->id, 
                'sort' => 'date', 
                'type' => $sort['field']=='date' && $sort['type']=='asc'?'desc':'asc' 
                ]) }}" role="button">
                По дате
            </a>     
            <a class="btn btn-primary" href="{{ route('category.index', [
                'id' => $category->id, 
                'sort' => 'count', 
                'type' => $sort['field']=='count' && $sort['type']=='asc'?'desc':'asc' 
                ]) }}" role="button">
                По комментариям
            </a>
        </div>
            <div class="table-responsive">
                <table class="table table-striped table">
                <thead>
                    <tr>
                    <th scope="col">Наименование лота</th>
                    <th scope="col">Начальная цена</th>
                    <th scope="col">Прием заявок до</th>
                    <th scope="col">Количество комментариев</th>
                    <th scope="col">Фото лота</th>
                    <th scope="col">Дата</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td><a href="{{ route('product.index', ['id' => $product->id]) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->date_end }}</td>
                            <td>{{ $product->count_reviews }}</td>
                            <td><img width="100" src="{{ asset('storage/images/'.$product->picture) }}" alt="" title=""></a></td>
                            <td>{{ $product->created_at }}</td>
                            <td>
                                @php
                                    if ( $product->users->find(auth()->user()->id) != null ) {
                                        $in_favorite = $product->users->find(auth()->user()->id)->pivot->product_id == $product->id?true:false;
                                    } else {
                                        $in_favorite = false;
                                    }
                                @endphp
                                @if ( $in_favorite )
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
                                @else
                                    <form action={{ route('favorite.store', [$product->id]) }} method="get">
                                        @csrf
                                        @method('get')
                                        <button type="submit" class="btn btn-sm btn-outline-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"></path>
                                            </svg>
                                            Добавить
                                        </button>
                                    </form>
                                @endif
                                
                            </td>
                        </tr>
                        @endforeach
                </tbody>
                </table>
            </div>
            {{ $products->links() }}
        @else
        <h4 class="mb-3 lh-2">В этой категории нет лотов</h4>
        @endif

    </div>
</div>

@endsection