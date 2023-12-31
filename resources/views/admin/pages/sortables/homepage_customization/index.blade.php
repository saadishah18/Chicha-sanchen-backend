@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Homepage Customization</h1>

        @php
            $uiTypes = range(1,7);
        @endphp
        <div class="row">
            <div class="col">
                <ul class="p-0" id="sortable">
                    @foreach($categoriesOrder as $categoryOrder)
                        @include('admin.pages.sortables.homepage_customization.categories.sort_category_list_item',['categoryOrder' => $categoryOrder,'categories' => $categories,'uiTypes' => $uiTypes])
                    @endforeach
                </ul>
            </div>
{{--            <div class="col">--}}
{{--                @include('admin.pages.homepage_customization.components.ui7')--}}
{{--                @include('admin.pages.homepage_customization.components.ui1')--}}
{{--                @include('admin.pages.homepage_customization.components.ui2')--}}
{{--                @include('admin.pages.homepage_customization.components.ui3')--}}
{{--                @include('admin.pages.homepage_customization.components.ui4')--}}
{{--                @include('admin.pages.homepage_customization.components.ui5')--}}
{{--                @include('admin.pages.homepage_customization.components.ui6')--}}
{{--            </div>--}}
        </div>
{{--        <div class="row">--}}
{{--            @foreach(range(1,7) as $uiPreview)--}}
{{--                <div class="col-md-4">--}}
{{--                    UI: {{$uiPreview}}--}}
{{--                    <img width="400" height="400" style="object-fit: contain" src="{{asset("img/category_ui/ui".$uiPreview.'.png')}}">--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
        <div class="mb-3 text-center">
            <button type="submit" id="save_changes" class="btn btn-primary bg-theme">Save changes</button>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    @include('admin.layouts.partials.sweetalert')

    <script>
        var idWithOrder = [];
        function setSortingDetails (){
            $("#sortable li").each(function(index) {
                var itemId = $(this).data("id");
                var itemOrder = index + 1; // Index-based order (1-based)

                var category_id = $(this).find("select[name='category_id']").val();
                var ui_type = $(this).find("select[name='ui_type']").val();
                var is_displayed = $(this).find('#is_displayed_'+itemId).is(':checked') ? 1 : 0;

                idWithOrder.push({
                    id: itemId,
                    order: itemOrder,
                    category_id: category_id,
                    ui_type: ui_type,
                    is_displayed: is_displayed
                });
            });
        }
        $(document).ready(function (){
            $( "#sortable" ).sortable({
                handle: ".sorting-handle",
                update: function(event, ui) {
                    idWithOrder = [];
                    // setSortingDetails();
                }
            });
            $("#save_changes").click(async function() {
                await setSortingDetails();

                if (idWithOrder && idWithOrder.length){
                    $(this).attr('disabled',true);
                    $.ajax({
                        url: "/admin/homepage-customization/set-order",
                        type: "POST",
                        data: {_token: "{{csrf_token()}}", idWithOrder},
                        success: function(response) {
                            Swal.fire({
                                toast:true,
                                icon: 'success',
                                position:'top-right',
                                title: '',
                                text: "Changes saved successfully!",
                                showConfirmButton: false,

                            });
                            $("#save_changes").attr('disabled',false);
                        },
                        error: function(xhr, status, error) {
                            // Handle any errors that occur during the AJAX request
                            Swal.fire({
                                icon: 'error',
                                toast:true,
                                position:'top-right',
                                title: '',
                                text: "An error occurred while saving changes.",
                                showConfirmButton: false,
                            });
                            $("#save_changes").attr('disabled',false);
                        }
                    });
                }
            });
            $('.select2').select2();

        });
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
    @vite('public/admin/css/shimmering_style.css')
@endsection

