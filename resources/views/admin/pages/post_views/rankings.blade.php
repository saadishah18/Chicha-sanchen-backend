@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Post View Analytics</h1>
        @include('admin.pages.post_views.ranking_datatable',['id' => 'datatable1'])
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">

        function initializeDatatable(tableId){
            url = `/admin/posts/analytics/datatable`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'author' },
                    { data: 'category' },
                    { data: 'year' },
                    { data: 'view_type' },
                    // { data: 'sort_type' },
                    { data: 'title',width:"50%" },
                    { data: 'post_views_total' },
                    { data: 'post_views_year' },
                    { data: 'post_views_halfyear' },
                    { data: 'post_views_month' },
                    { data: 'post_views_week' },
                    { data: 'post_views_today' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'hidden', visible: false, searchable:false, orderable: false },
                    {'max-width': '10%', 'targets': [5]},
                ],
                order: [[6, 'desc']],

            });
        }
        $(document).ready(function(){
            initializeDatatable('datatable1');
            $('.select2').select2();
            $(document).on('change','.select2',function (e){
                var i =$(this).attr('data-column');
                var v =$(this).val();
                let tableId = $(this).attr('data-tbId');
                $('#'+tableId).DataTable().columns(i).search(v).draw(false);
            });
        });
    </script>
@endsection
@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection

