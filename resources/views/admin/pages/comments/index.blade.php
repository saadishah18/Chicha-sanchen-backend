@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Comments</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All Comments</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Approved</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Vic Picks Comments</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                @include('admin.pages.comments.datatable',['id' => 'datatable1'])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                @include('admin.pages.comments.datatable',['id' => 'datatable2'])
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                @include('admin.pages.comments.datatable',['id' => 'datatable3'])
            </div>
        </div>


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">

        function toggleActivity(classSelector = '.toggle_approve',urlPart = 'toggle-approve'){
            $(document).on('click',classSelector,function (e){
                e.preventDefault();
                let itemId = $(e.currentTarget).data('id');
                url = '/admin/comments/'+itemId+'/'+urlPart;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You can reverse this action anytime',
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
                            data: { "_token": "{{ csrf_token() }}", 'user_id': itemId },
                            success: function (data) {
                                if (data.status){
                                    $('#datatable1').DataTable().ajax.reload( null, false );
                                    $('#datatable2').DataTable().ajax.reload( null, false );
                                    $('#datatable3').DataTable().ajax.reload( null, false );
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
        function initializeDatatable(id,type){
             url = `/admin/comments/datatable/${type}`
            $(`#${id}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'comment_id' },
                    { data: 'name' },
                    { data: 'user_thoughts' }, //title
                    { data: 'comment', width: '20%' },       //description
                    { data: 'in_response_to',width: '20%' },
                    { data: 'created_at' },
                    { data: 'actions', width : '17%' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
                order: [[5, 'desc']],
        });
        }
        function confirmBeforeDelete(){
            $(document).on('click','.delete_item_from_list',function (e){
                let commentId = $(e.currentTarget).data('id');
                url = '/admin/comments/'+commentId;
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
                            data: { "_method":'DELETE' ,"_token": "{{ csrf_token() }}", 'id': commentId },
                            success: function (data) {
                                if (data.status){
                                    //reset all datatables
                                    $('#datatable1').DataTable().clear().draw(false);
                                    $('#datatable2').DataTable().clear().draw(false);
                                    $('#datatable3').DataTable().clear().draw(false);
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

            initializeDatatable('datatable1','all')
            initializeDatatable('datatable2','approved')
            initializeDatatable('datatable3','vic_pick')

            confirmBeforeDelete();

            toggleActivity('.toggle_approve','toggle-approve');
            toggleActivity('.toggle_vic_pick','toggle-featured');
            toggleActivity('.toggle_abusive','toggle-abusive');

        });
    </script>
@endsection

