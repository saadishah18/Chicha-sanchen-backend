@extends('admin.layouts.admin')
@section('content')
    <style>
        .order-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .order-item h2 {
            font-size: 20px;
            color: #555;
            margin-bottom: 10px;
        }

        .add-ons {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .add-ons li {
            background-color: #f9f9f9;
            margin-bottom: 5px;
            padding: 10px;
            border-radius: 5px;
            color: #333;
        }

    </style>
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Post View Analytics</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="order">
                    <h1>Order #{{$order->order_unique_id}}</h1>
                    <div class="order-details">
                        <p><strong>User Name:</strong> {{$order->user->fname.' '.$order->user->lname}}</p>
                        <p><strong>Total Items:</strong> {{$order->orderItems->count()}}</p>
                        <p><strong>Order Date:</strong>{{\Carbon\Carbon::parse($order->order_date)}}</p>
                    </div>
                    @foreach($order->orderItems as $key => $item)
                        <div class="order-item">
                            <h2>{{$item->product_name}}</h2>
                            <ul class="add-ons">
                                @foreach($item->orderItemAddOns as $adOnIndex => $adOn)
                                    @dd($adOn)
                                <li>Extra shot of espresso</li>
                                @endforeach
{{--                                <li>Almond milk</li>--}}
{{--                                <li>Vanilla syrup</li>--}}
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


