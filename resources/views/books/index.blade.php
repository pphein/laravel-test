@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Book List</h1>

    <!-- Cart Icon -->
    <div class="cart-icon">
        <a href="{{ route('cart.index') }}">
            <i class="fa fa-shopping-cart"></i> <!-- Font Awesome cart icon -->
            <span class="cart-count">
            </span>
        </a>
    </div>

    <div class="mb-4">
        <form action="{{ route('books.index') }}" method="GET">
            <div class="input-group">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Search by title, author, or summary keyword" 
                    value="{{ request()->search }}"
                />
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>


    <!-- <div class="row">
        @foreach($books as $book)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ Str::limit($book->summary, 100) }}</p>
                        <p><strong>Authors:</strong> 
                            {{ $book->authors->pluck('pen_name')->join(', ') }}
                        </p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> -->

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="book-grid">
        @foreach ($books as $book)
            <div class="book-item">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                <h3>{{ $book->title }}</h3>
                <p>{{ $book->summary }}</p>
                <p>Price: ${{ $book->price }}</p>
                <p><strong>Authors:</strong> 
                            {{ $book->authors->pluck('pen_name')->join(', ') }}
                </p>
                <p>
                    <strong>Status:</strong>
                    {{ $book->copy_borrowed }} / {{ $book->copy_availables }}
                </p>
                <p>
                    <!-- @if ($book->canBeBorrowed())
                        <form action="{{ route('books.borrow', $book->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                Borrow
                            </button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-danger" disabled>
                            Cannot Borrow
                        </button>
                    @endif -->
                    <form action="{{ route('cart.add', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                    
                </p>
                <a href="{{ route('books.show', $book) }}" class="btn btn-primary">View Details</a>
            </div>
        @endforeach
    </div>

    <div class="mt-4 flex justify-center">
        <!-- {{ $books->links('pagination::bootstrap-4') }} -->
        {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>

</div>
@endsection
