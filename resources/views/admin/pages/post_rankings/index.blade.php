@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage News Post</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
        @endif
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#left_post" role="tab" aria-controls="left_post" aria-selected="true">Left Post</a>
                <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#center_post" role="tab" aria-controls="center_post" aria-selected="false">Center Featured Post</a>
                <a class="nav-item nav-link" id="tab3" data-toggle="tab" href="#top_post" role="tab" aria-controls="top_post" aria-selected="false">Top Stories Post</a>
                <a class="nav-item nav-link" id="tab4" data-toggle="tab" href="#politics_post" role="tab" aria-controls="politics_post" aria-selected="false">Politics Post</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="left_post" role="tabpanel" aria-labelledby="tab1">
                @include('admin.pages.post_rankings.datatable',['id' => 'left_post_order'])
            </div>
            <div class="tab-pane fade" id="center_post" role="tabpanel" aria-labelledby="tab2">
                @include('admin.pages.post_rankings.datatable',['id' => 'center_featured_post_order'])
            </div>
            <div class="tab-pane fade" id="top_post" role="tabpanel" aria-labelledby="tab3">
                @include('admin.pages.post_rankings.datatable',['id' => 'top_post_order'])
            </div>
            <div class="tab-pane fade" id="politics_post" role="tabpanel" aria-labelledby="tab4">
                @include('admin.pages.post_rankings.datatable',['id' => 'politics_post_order'])
            </div>
        </div>


    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">


        var left_post,center_featured_posts,datatable3,datatable4;
        function initializeDatatable(tableId,newsTypeId,section){
            url = `/admin/post-rankings/datatable/${newsTypeId}/${section}`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'content_id' },
                    { data: 'title' },
                    { data: 'journalist',name:'author' ,width: '10%'},
                    { data: 'category',name:'category',width: '10%' },
                    { data: 'tags', width: '20%' },
                    { data: 'thumbnail',width: '10%'},
                    { data: 'comments_count',width: '20%'},
                    { name:'order',data: 'order',width: '20%'},
                    { name: 'publish_date',data:'schedule_date' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false },
                    {'max-width': '10%', 'targets': [2]}
                ],
                order: [[7, 'asc']],

        });
        }
        $(document).ready(function(){

            initializeDatatable('left_post_order',"{{request()->newsTypeId}}",'left_post_order')
            initializeDatatable('center_featured_post_order',"{{request()->newsTypeId}}",'center_featured_post_order')
            initializeDatatable('top_post_order',"{{request()->newsTypeId}}",'top_post_order')
            initializeDatatable('politics_post_order',"{{request()->newsTypeId}}",'politics_post_order')


            $('.select2').select2();

            $(document).on('click','.action',function (e){
                e.preventDefault();
            });
            $(document).on('change','.select2',function (e){
                var i =$(this).attr('data-column');
                var v =$(this).val();
                let tableId = $(this).closest('table').attr('id');
                $('#'+tableId).DataTable().columns(i).search(v).draw(false);
            });
            $('#caribbean_post, #left_post_order, #center_featured_post_order, #top_post_order, #politics_post_order').on( 'dblclick', 'tbody td:nth-child(8)', function (e) {
                e.stopPropagation();
                var currentEle = $(this);
                let order_column = $(e.currentTarget.closest('table')).attr('id');
                let content_id = $(currentEle.siblings()[0]).html(); //content_id
                var value = $(this).html();
                value = value.replace(/\s/g, '');
                if($.isNumeric(value))
                    updateVal(currentEle, value,content_id,order_column);
                else
                    return false;
            });
            function updateVal(currentEle, value,content_id,order_column) {
                $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
                var thVal = $(".thVal");
                thVal.focus();
                thVal.keyup(function (event) {
                    if (event.keyCode == 13) {
                        var value = thVal.val();
                        value = value.replace(/\s/g, '');
                        $(currentEle).html(value.trim());
                        save(currentEle,value.trim(),content_id,order_column);
                    }
                });

                thVal.focusout(function () {
                    var value = thVal.val();
                    value = value.replace(/\s/g, '');
                    $(currentEle).html(value.trim());
                    return save(currentEle,value.trim(),content_id,order_column);
                });

            }

            function save(_this,value,content_id,order_column) {
                var id 						= content_id;
                var left_search 			= $('#left_post_filter input').val();
                var center_featured_search 	= $('#center_featured_post input').val();
                var top_stories_search 		= $('#top_stories_post input').val();
                var politics_search 		= $('#politics_post input').val();
                $.post('/admin/post-rankings/set-order', {_token: '{{csrf_token()}}' ,id:id,order_column:order_column,type:'{{request()->newsTypeId}}', order: value,left_search:left_search,center_featured_search:center_featured_search,top_stories_search:top_stories_search,politics_search:politics_search}, function (data) {
                    if (data.status) {
                        $('table').DataTable().draw(false);
                    } else {

                    }
                }, "json");
            }

        });
    </script>
@endsection
@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection

