@extends('layouts.app')

@section('content')
    <h1>Shopping Cart</h1>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>${{ $item->price }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ $item->qty * $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>Total: ${{ Cart::total() }}</div>
@endsection
