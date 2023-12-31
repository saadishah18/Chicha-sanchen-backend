@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage Pages</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
        @endif
        @include('admin.pages.pages.datatable',['id' => 'datatable1'])


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')

    @include('admin.pages.partials.datatable_pdf_js')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    <script type="text/javascript">

        function toggleActivity(e,column = 'is_breaking_news'){
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/pages/'+itemId+'/toggle';
            Swal.fire({
                // title: 'Are you sure?',
                text: 'Are you sure to perform this action!',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                cancelButtonColor:'grey',
                confirmButtonColor:'red',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        method: 'POST',
                        data: { "_token": "{{ csrf_token() }}", 'content_id': itemId,column },
                        success: function (data) {
                            if (data.status){
                                $('#datatable1').DataTable().ajax.reload( null, false );
                            }
                        },
                        error:function (data){
                            Swal.fire({
                                icon: 'error',
                                title: '',
                                text: data?.responseJSON?.message,
                            })
                        }
                    });
                }

            })
        }

        var datatable1,datatable2,datatable3;
        function initializeDatatable(tableId){
             url = `/admin/pages/datatable/`

            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'page_id' ,width: '5%'},
                    { data: 'title' ,width: '20%'},
                    { data: 'slug',width: '20%' },
                    { data: 'content',name:'description',width: '20%'},
                    { data:'created_at',width: '10%' },
                    { data: 'actions', width : '10%' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'hidden', visible: false },
                    {'max-width': '10%', 'targets': [1,2]},
                ],
                order: [[0, 'desc']],

        });
        }
        function confirmBeforeDelete(){
            $(document).on('click','.delete_item_from_list',function (e){
                let postId = $(e.currentTarget).data('id');
                url = '/admin/pages/'+postId;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You cannot reverse this action',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    cancelButtonColor:'grey',
                    confirmButtonColor:'red',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url,
                            method: 'POST',
                            data: { "_method":'DELETE' ,"_token": "{{ csrf_token() }}", 'id': postId },
                            success: function (data) {
                                if (data.status){
                                    //reset all datatables
                                    $('#datatable1').DataTable().clear().draw(false);
                                }
                            },
                            error:function (data){
                                Swal.fire({
                                    icon: 'error',
                                    title: '',
                                    text: data?.responseJSON?.message,
                                })
                            }
                        });
                    }

                })

            });
        }
        $(document).ready(function(){

            initializeDatatable('datatable1')

            confirmBeforeDelete();


            $(document).on('click','.action',function (e){
                e.preventDefault();
                toggleActivity(e,$(this).data('column'));
            });

        });
    </script>

@endsection
@section('css')
    @include('admin.pages.partials.datatable_pdf_css')
@endsection

