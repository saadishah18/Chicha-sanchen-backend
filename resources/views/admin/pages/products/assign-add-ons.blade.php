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
        <form method="post" action="{{ route('admin.addons.assign-values-to-products') }}"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="row">
                @php
                    $add_on_ids = [];
                    $value_ids = [];
                    $add_on_parent_ids = [];
                    foreach ($product_assigned_addons as $key => $ad){
                        $add_on_parent_ids[] = $ad['add_on_parent_id']  ;
                        $add_on_ids[] = $ad['add_on_id']  ;
                        $value_ids[] = $ad['value_id'];
                    }
                @endphp

                @foreach($add_ons as $key => $addon)
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input parent-checkbox" type="checkbox" name="add_on_id[]" id="mainCheckbox{{$addon->id}}"
                                   value="{{$addon->id}}" @if(in_array($addon->id, $add_on_ids)) checked @elseif(in_array($addon->id, $add_on_parent_ids)) checked @endif>
                            <label class="form-check-label" for="is_scheduled">{!! ucfirst($addon->name) !!}</label>
                        </div>

                        {{-- Display values for the current parent add-on --}}
                        <ul>
                            @foreach($addon->values as $i => $value)
                                <li>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input addon-value-checkbox parent-{{$addon->id}} addon-{{$addon->id}}" type="checkbox"
                                               name="add_on_value_id[{{$addon->id}}][]" id="add_on_value_id"
                                               value="{{$value->id}}" @if(in_array($value->id, $value_ids)) checked @endif>
                                        <label class="form-check-label"
                                               for="is_scheduled">{!! ucfirst($value->value) !!}
                                            <span><b>Price</b> {!! $value->price ?? 0 !!} AED</span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Check if the parent add-on has children --}}
                        @if(!empty($addon->children))
                            <div class="col-md-12">
                                {{-- Loop through the child add-ons --}}
                                @foreach($addon->children as $child)
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input main-checkbox parent-{{$addon->id}}" type="checkbox"
                                                   name="add_on_child_id[{{$addon->id}}][]" id="mainCheckbox{{$child->id}}"
                                                   value="{{$child->id}}" @if(in_array($child->id, $add_on_ids)) checked @endif>
                                            <label class="form-check-label"
                                                   for="is_scheduled">{!! ucfirst($child->name) !!}</label>
                                        </div>

                                        {{-- Display values for the current child add-on --}}
                                        <ul>
                                            @foreach($child->values as $i => $value)
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input addon-value-checkbox parent-{{$addon->id}} addon-{{$child->id}}" type="checkbox"
                                                               name="add_on_value_id[{{$addon->id}}][{{$child->id}}][]" id="add_on_value_id"
                                                               value="{{$value->id}}" @if(in_array($value->id, $value_ids)) checked @endif>
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
                            </div>
                        @endif
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

            $('.parent-checkbox').on('click', function () {
                // Get the addon ID
                var addonId = $(this).attr('id').replace('mainCheckbox', '');

                // Get its checked state
                var isChecked = $(this).prop('checked');


                // Update the state of all addon value checkboxes for this addon
                $('.parent-' + addonId).prop('checked', isChecked);
            });
        });
    </script>
@endsection


