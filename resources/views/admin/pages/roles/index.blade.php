@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage User Roles</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
        @endif
        @include('admin.pages.roles.datatable',['id' => 'datatable1'])


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">


        var datatable1;
        function initializeDatatable(tableId){
             url = `/admin/roles/datatable/`

            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'role_id' ,width: '5%'},
                    { data: 'role_name'},
                    { data:'created_at',width: '20%' },
                    { data: 'actions', width : '15%' },
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
                url = '/admin/roles/'+postId;
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

        });
    </script>
@endsection
