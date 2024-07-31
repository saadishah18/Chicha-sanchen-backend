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
                <div class="row">
                    <div class="col-md-6">
                        <h4><strong>Customer: </strong> {{ucfirst($order->user->fname).' '.ucfirst($order->user->lname)}}</h4>
                        <p><strong>Total Items: </strong> {{$order->orderItems->count()}}</p>
                        <p><strong>Order Date: </strong>{{\Carbon\Carbon::parse($order->order_date)->toFormattedDateString()}}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="font-weight-bold float-right">Order <span class="text-primary">#{{$order->order_unique_id}}</span></h5>

                    </div>
                </div>
                <div class="order">


                    @foreach($order->orderItems as $key => $item)
                        <div class="order-item">
                            <h2>
                                <ol start="1" type="1">
                                    <li  value="{{ $loop->iteration++ }}">
                                        {{$item->product_name}}
                                    </li>
                                </ol>

                            </h2>
                                @foreach($item->orderItemAddOns as $adOnIndex => $adOn)
                                @if($adOn->values->count())
                                <ul class="add-ons">
                                    @foreach($adOn->values as $valIndex => $value)
                                        <li>{{$value->value_name}}</li>
                                    @endforeach

                                    </ul>
                                @else
                                    <div class="alert alert-info">
                                        <p>No Add for this item</p>
                                    </div>
                                @endif
                                @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


