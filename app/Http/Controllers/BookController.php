<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display a list of books
    public function index(Request $request)
    {
        // $books = Book::with('authors')->paginate(10); // Paginate the books
        // return view('books.index', compact('books'));

        $query = Book::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;

            $query->where('title', 'like', "%{$search}%")
                ->orWhere('summary', 'like', "%{$search}%")
                ->orWhereHas('authors', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('pen_name', 'like', "%{$search}%");
                });
        }

        $books = $query->with('authors')->paginate(10);

        return view('books.index', compact('books'));
    }

    // Display details of a single book
    public function show(Book $book)
    {
        $book->load('authors'); // Eager load authors
        return view('books.show', compact('book'));
    }

    public function toggleCanBorrow(Book $book)
    {
        if ($book->copy_availables > 0) {
            $book->can_borrow = !$book->can_borrow;
            $book->save();

            return redirect()->route('books.index')->with('status', 'Can Borrow status updated successfully!');
        }

        return redirect()->route('books.index')->with('error', 'Cannot enable borrowing. No available copies.');
    }

    public function borrow(Book $book)
    {
        try {
            $book->borrow();
            return redirect()->back()->with('success', 'Book borrowed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function return(Book $book)
    {
        $book->returnBook();
        return redirect()->back()->with('success', 'Book returned successfully.');
    }

    public function addToBorrowList(Book $book)
    {
        $user = auth()->user();

        // Check if the book is already in the user's borrow list
        if ($user->borrowedBooks()->where('book_id', $book->id)->whereNull('returned_at')->exists()) {
            return redirect()->back()->with('error', 'This book is already in your borrow list.');
        }

        // Add the book to the borrow list
        $user->borrowedBooks()->attach($book);

        return redirect()->back()->with('success', 'Book added to borrow list.');
    }

}
