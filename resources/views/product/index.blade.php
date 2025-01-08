@extends('layouts.app')

@section('content')

    <div class="container" id="products-page">

        <div class="card">
            <div class="card-header">
                <h3> Product Form </h3>
            </div>

            <div class="card-body">

                <form id="product-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock_qty" class="form-label">Quantity in Stock</label>
                        <input type="number" id="stock_qty" name="stock_qty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_per_pc" class="form-label">Price Per Item</label>
                        <input type="number" step="0.01" id="price_per_pc" name="price_per_pc" class="form-control" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4"> <i class="bx bx-save"> </i> Submit </button>
                    </div>
                </form>

            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h3> All Products </h3>
            </div>

            <div class="card-body">
            <table class="table table-bordered table-striped mt-3" id="products-table">
                <thead>
                    <tr>
                        <th> Product </th>
                        <th> Qty (pcs)  </th>
                        <th> Price (per pc) </th>
                        <th> Date & Time </th>
                        <th> Total (Qty x Price ) </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalSum = 0; @endphp
                    @foreach($products as $id => $product)
                        @php $totalSum += $product['total_value']; @endphp
                        <tr data-id="{{ $id }}">
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['stock_qty'] }}</td>
                            <td class="text-end">{{ $product['price_per_pc'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($product['date_time'])->format('M j, Y h:i A') }}</td>
                            <td class="text-end">{{ number_format( $product['total_value'], 2) }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-product" data-id="{{ $id }}"> <i class="bx bx-edit"> </i> Edit</button>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="total-row">
                        <td colspan="4" class="text-end"><strong>Total</strong></td>
                        <td id="total-value" class="text-end"><strong>{{ number_format( $totalSum , 2) }}</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            </div>

        </div>

    </div>

@endsection
