<?php

namespace App\Http\Controllers;


use App\Models\Author;
use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class HomeController extends Controller
{

    public function index()
    {
        $authors = Author::all();
        $genres = Genre::all();
        $books = Book::all();

        return view('home', compact('authors', 'genres', 'books'));
    }

    public function search(Request $request)
    {
        $data = $request->input('jsonContent');
        $jsonData = json_decode($data, true);

        $searchString = (string)$jsonData['book'];
        $genreIds = $jsonData['genres'];
        $authorIds = $jsonData['authors'];

        if (!empty($searchString)) {
            $books = Book::where('title', 'like', '%' . $searchString . '%')
                ->orWhere('description', 'like', '%' . $searchString . '%')
                ->whereHas('genres', function ($query) use ($genreIds) {
                    if (count($genreIds)) {
                        return $query->whereIn('genres.id', $genreIds);
                    }
                })->whereHas('authors', function ($secondQuery) use ($authorIds) {
                    if (count($authorIds)) {
                        return $secondQuery->whereIn('authors.id', $authorIds);
                    }
                })->get();

            $data = [];

            foreach ($books as $book) {
                $data[] = $book;
                foreach ($book->genres as $genre) {
                    $data[] .= $genre->name;
                }
                foreach ($book->authors as $author) {
                    $data[] .= $author->first_name . $author->middle_name . $author->last_name;
                }
            }

            return json_encode($data);

        }

        if (empty($searchString)) {
            $books = Book::whereHas('genres', function ($query) use ($genreIds) {
                if (count($genreIds)) {
                    return $query->whereIn('genres.id', $genreIds);
                }
            })->whereHas('authors', function ($secondQuery) use ($authorIds) {
                if (count($authorIds)) {
                    return $secondQuery->whereIn('authors.id', $authorIds);
                }
            })->get();

            $data = [];

            foreach ($books as $book) {
                $data[] = $book;
                foreach ($book->genres as $genre) {
                    $data[] .= $genre->name;
                }
                foreach ($book->authors as $author) {
                    $data[] .= $author->first_name . $author->middle_name . $author->last_name;
                }
            }

            return json_encode($data);
        }
    }

}
