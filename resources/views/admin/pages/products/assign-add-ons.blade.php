@extends('admin.layouts.admin')
@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow', [
            'backRoute' => route('admin.products.index'),
            'text' => 'Assign Add on to '. $product->name,
        ])
        <form method="post" action="{{ route('admin.addons.assign-values-store') }}"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="row">
                {{--                <input type="hidden" name="newsTypeId" value="{{ $newsTypeId }}">--}}
                {{--                @include('admin.components.partials.session_statuses')--}}
                @foreach($add_ons as $key => $addon)
                    <div class="col-md-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input main-checkbox" type="checkbox" name="add_on_id[]" id="mainCheckbox{{$addon->id}}"
                                   value="{{$addon->id}}" {{--{{ old('name') || $addon->is_featured == 1 ? 'checked' : '' }}--}} >
                            <label class="form-check-label" for="is_scheduled">{!! ucfirst($addon->name) !!}</label>
                        </div>
                        <ul>
                            @foreach($addon->values as $i => $value)
                                <li>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input addon-value-checkbox addon-{{$addon->id}}" type="checkbox"
                                               name="add_on_value_id[{{$addon->id}}][]" id="add_on_value_id"
                                               value="{{$value->id}}" {{--{{ old('name') || $addon->is_featured == 1 ? 'checked' : '' }}--}} >
                                        <label class="form-check-label"
                                               for="is_scheduled">{!! ucfirst($value->value) !!}
                                            <span><b>Price</b> {!! $value->price ?? 0 !!} AED</span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Update</button>
                </div>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            window.onbeforeunload = function () {
                return "Are you sure you want to leave this page?";
            };

            $('.main-checkbox').on('click', function () {
                // Get the addon ID
                var addonId = $(this).attr('id').replace('mainCheckbox', '');

                // Get its checked state
                var isChecked = $(this).prop('checked');

                // Update the state of all addon value checkboxes for this addon
                $('.addon-' + addonId).prop('checked', isChecked);
            });
        });
    </script>
@endsection


