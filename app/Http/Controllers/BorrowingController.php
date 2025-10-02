<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of borrowings.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        $borrowings = $query->latest()->paginate(10);
        return $this->successPaginated('Borrowings fetched successfully', BorrowingResource::collection($borrowings));
    }

    /**
     * Store a new borrowing.
     */
    public function store(StoreBorrowingRequest $request)
    {
        $book = Book::findOrFail($request->book_id);
        $member = Member::findOrFail($request->member_id);

        if ($member->status !== 'active') {
            return $this->error('Member is not active for borrowing.', null, 422);
        }

        if (!$book->isAvailable() || $book->status !== 'active') {
            return $this->error('Book is not available for borrowing.', null, 422);
        }

        $borrowing = Borrowing::create($request->validated());

        $book->borrow();

        $borrowing->load(['book', 'member']);

        return $this->success('Borrowing created successfully', new BorrowingResource($borrowing), 201);
    }

    /**
     * Display a specific borrowing.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['book', 'member']);
        return $this->success('Borrowing fetched successfully', new BorrowingResource($borrowing));
    }

    /**
     * Mark a borrowing as returned.
     */
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return $this->error('The book has already been returned.', null, 422);
        }

        $borrowing->update([
            "returned_date" => now(),
            "status" => "returned",
        ]);

        $borrowing->book->returnBook();

        $borrowing->load(['book', 'member']);

        return $this->success('Book returned successfully', new BorrowingResource($borrowing));
    }

    /**
     * List overdue borrowings.
     */
    public function overdue()
    {
        $borrowings = Borrowing::with(['book', 'member'])
            ->where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->get();


            Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        return $this->success('Overdue borrowings fetched successfully', BorrowingResource::collection($borrowings));
    }
}
