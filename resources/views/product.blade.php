@extends('layouts.app')

@section('title', 'Лоты | '.$product->name)

@section('content')

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="row gx-md-5">
                <div class="col-lg-6 mb-3">
                    <h1 class="display-6">{{ $product->name }}</h1>
                    <h4><a href="{{ route('category.index', ['id' => $product->category->id]) }}">{{ $product->category->name }}</a></h4>
                    <p>Цена: {{ $product->price }} р</p>
                  <p>{{ $product->description }}</p>
                  <p>Окончание приема заявок: {{ $product->date_end }}</p>
                  
                </div>
                <div class="col-lg-6 mb-3">
                    <div class='d-flex' >
                        <img width="500" src="{{ asset('storage/images/'.$product->picture) }}" alt="" title="">
                    </div>
                </div>
              </div>
        </div>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 px-5 py-4  text-bg-light rounded-3">
                    <h3 class="mb-3">Комментарии</h3>
                    @if(count($product->reviews) != 0)
                    <div class="table-responsive" style="max-height:300px">
                    <table class="table table-striped table">
                        <thead>
                        <tr>
                            <th scope="col">Автор</th>
                            <th scope="col">Комментарий</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($product->reviews as $review)
                            <tr>
                                <td>{{ $review->user->name }}</td>
                                <td>{{ $review->text }}</td>  
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    @else
                    <h5 class="mb-3">Нет комментариев</h5>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 px-5 py-4  text-bg-light rounded-3">
                    <h3 class="mb-3">Оставить комментарий</h3>
                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <textarea class="form-control mb-3" name="text" rows="3"></textarea>
                        @error('text')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-outline-info" type="submit">Отправить</button>
                    </form>
              </div>
            </div>
          </div>
    </div>
</div>

@endsection