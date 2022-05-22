@extends('layouts.main')

@section('content')

    <div class="home-container">

        <div id="form-block">
            <h1 id="title-text">Book Search</h1>
            <form method="post" id="book-search-form">
                <p>Название</p>
                <input type="text" placeholder="Введите имя книги" name="book" id="search-input">
                <p>Жанры</p>
                <div id="more-parameters" style="display:none">
                    @foreach($genres as $genre)
                        <input type="checkbox" value="{{$genre->id}}" name="genres" class="checkbox-input">
                        <label for="{{$genre->name}}">{{$genre->name}}</label>
                    @endforeach
                    <p>Авторы</p>
                    @foreach($authors as $author)
                        <input type="checkbox" name="authors" value="{{$author->id}}" class="checkbox-input">
                        <label for="{{$author->first_name}}&nbsp{{$author->middle_name}}&nbsp{{$author->last_name}}">{{$author->first_name}}&nbsp{{$author->middle_name}}&nbsp{{$author->last_name}}</label>
                    @endforeach
                </div>
                <input type="button" name="showMore" value="All parameters" onclick="show()" style="display: block" id="show-more-button">
                <br>
                <input type="submit" value="Поиск" id="submit-inpit">
            </form>
        </div>

        <div id="books-block">
            @foreach($books as $book)
                <div class="book">
                    <img src="{{ asset("$book->image_path") }}" alt="book image" >
                    <p>{{$book->title}}</p>
                    <p>{{$book->description}}</p>
                    @foreach($book->authors as $author)
                        <p>{{$author->first_name}}&nbsp{{$author->middle_name}}&nbsp{{$author->last_name}}</p>
                    @endforeach
                    @foreach($book->genres as $genre)
                        <p>{{$genre->name}}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
