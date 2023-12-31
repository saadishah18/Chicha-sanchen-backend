@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage Real Estate</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
        @endif
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Virgin Islands Real Estate</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Caribbean Real Estate</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Real Estate Contact Messages</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                @include('admin.pages.real_estates.datatable',['id' => 'datatable1'])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                @include('admin.pages.real_estates.datatable',['id' => 'datatable2'])
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                @include('admin.pages.real_estates.messages_datatable',['id' => 'datatable3'])
            </div>
        </div>


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">

        function toggleActivity(e,column = 'is_breaking_news'){
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/real-estates/'+itemId+'/toggle';
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
                                $('#datatable2').DataTable().ajax.reload( null, false );
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
        function initializeDatatable(tableId,newsTypeId = null){
             url = `/admin/real-estates/datatable/`
            if (newsTypeId != null){
                url += newsTypeId
            }
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'real_estate_id' },
                    { data: 'title' },
                    { data: 'author',width: '10%'},
                    { data: 'email',width: '10%'},
                    { data: 'address',width: '10%'},
                    { data: 'p_type',name:'type',width: '10%'},
                    { data: 'thumbnail',width: '10%'},
                    { data: 'payment_status',width: '10%'},
                    { name: 'publish_date',data:'created_at' },
                    { data: 'actions', width : '17%' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'hidden', visible: false },
                    {'max-width': '10%', 'targets': [2]},
                    { className: "d-flexs", "targets": [ 9 ] }
                ],
                order: [[0, 'desc']],

        });
        }
        function initializeMessagesDatatable(tableId){
             url = `/admin/real-estates/messages`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'title' },
                    { data: 'contact_name' },
                    { data: 'contact_email' },
                    { data: 'contact_number' },
                    { data: 'contact_message' },
                    { data:'created_date' },
                ],
                columnDefs: [
                    {'max-width': '10%', 'targets': [2]},
                    { targets: 'hidden', visible: false },
                ],
                order: [[0, 'desc']],

        });
        }
        function confirmBeforeDelete(){
            $(document).on('click','.delete_item_from_list',function (e){
                let postId = $(e.currentTarget).data('id');
                url = '/admin/real-estates/'+postId;
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
                                    $('#datatable2').DataTable().clear().draw(false);
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

            initializeDatatable('datatable1',5)
            initializeDatatable('datatable2',6)
            initializeMessagesDatatable('datatable3')

            confirmBeforeDelete();

            $('.select2').select2();

            $(document).on('click','.action',function (e){
                e.preventDefault();
                toggleActivity(e,$(this).data('column'));
            });

        });
    </script>
@endsection
@section('css')

@endsection

