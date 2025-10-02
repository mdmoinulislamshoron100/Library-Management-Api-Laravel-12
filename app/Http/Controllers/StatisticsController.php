<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function statistic(){
        $author = Author::count();
        $book = Book::where('status', 'active')->count();
        $member = Member::where('status', 'active')->count();
        $borrowing = Borrowing::where('status', 'borrowed')->count();
        $overdue = Borrowing::where('status', 'overdue')->count();

        return response()->json([
            'total_authors' => $author,
            'total_books' => $book,
            'total_member' => $member,
            'total_borrowing' => $borrowing,
            'total_overdue' => $overdue,
        ]);
    }
}
