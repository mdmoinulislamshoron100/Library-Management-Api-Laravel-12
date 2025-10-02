<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AuthorController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Author::with('books');
        if($request->has('search')){
            $search = trim($request->search);

            $query->where(function($q) use ($search){
                $q->where('name', 'Like', "%$search%")
                    ->orWhere('nationality', 'Like', "%$search%");
            });
        }
        $authors = $query->paginate(10);
        return $this->successPaginated('Books fetched successfully', AuthorResource::collection($authors));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        return $this->success('Author created successfully', new AuthorResource($author), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return $this->success('Author fetched successfully', new AuthorResource($author));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return $this->success('Author updated successfully', new AuthorResource($author));

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Author $author)
    {
        $author->delete();
        return $this->success('Author deleted successfully');
    }

}
