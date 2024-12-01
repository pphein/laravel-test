@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $book->title }}</h1>

    <div class="row">
        <div class="col-md-4">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" class="img-fluid" alt="{{ $book->title }}">
            @else
                <img src="https://via.placeholder.com/150" class="img-fluid" alt="No Image">
            @endif
        </div>
        <div class="col-md-8">
            <h3>Details</h3>
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
            <p><strong>Copies Available:</strong> {{ $book->copy_availables }}</p>
            <p><strong>Authors:</strong> 
                {{ $book->authors->pluck('pen_name')->join(', ') }}
            </p>
            <p><strong>Summary:</strong></p>
            <p>{{ $book->summary }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
    </div>
</div>
@endsection
