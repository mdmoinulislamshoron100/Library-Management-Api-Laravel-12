<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('author');
        if($request->has('search')){
            $search = trim($request->search);

            $query->where(function($q) use ($search){
                $q->where('title', 'Like', "%$search%")
                  ->orWhere('genre', 'Like', "%$search%")
                  ->orWhereHas('author', function($authorQuery) use ($search){
                    $authorQuery->where('name', 'Like', "%$search%")
                                ->orWhere('nationality', 'Like', "%$search%");
                  });
            });
        }

        if($request->has('genre')){
            $search = trim($request->genre);
            $query->where('genre',$search);
        }


        $books = $query->paginate(10);
        return $this->successPaginated('Books fetched successfully', BookResource::collection($books));

    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {

            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book = Book::create($data);
        $book->load('author');

        return $this->success('Book created successfully', new BookResource($book), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('author');
        return $this->success('Book fetched successfully', new BookResource($book));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(StoreBookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {

            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($data);
        $book->load('author');

        return $this->success('Book updated successfully', new BookResource($book));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();
        return $this->success('Book deleted successfully');
    }
}
