@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Pueblo</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif
        <div class="card-header pl-0 py-3 right">
            @can('manage_pueblo_section_content')
                <a href="{{ route('admin.manage_pueblo.create') }}" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add Pueblo</span>
                </a>
            @endcan
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Virgin Island Pueblo</a>
                <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Caribbean Pueblo</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="tab1">
                @include('admin.pages.pueblo.datatable', ['id' => 'datatable1'])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="tab2">
                @include('admin.pages.pueblo.datatable', ['id' => 'datatable2'])
            </div>
        </div>


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        function toggleActivity(e, column = 'is_breaking_news') {
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/manage-pueblo/' + itemId + '/toggle';
            Swal.fire({
                // title: 'Are you sure?',
                text: 'Are you sure to perform this action!',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                cancelButtonColor: 'grey',
                confirmButtonColor: 'red',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'content_id': itemId,
                            column
                        },
                        success: function(data) {
                            if (data.status) {
                                $('#datatable1').DataTable().ajax.reload(null, false);
                                $('#datatable2').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(data) {
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

        var datatable1, datatable2, datatable3;

        function initializeDatatable(tableId, newsTypeId) {
            url = `/admin/manage-pueblo/datatable/${newsTypeId}`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'title',
                        width: '20%'
                    },
                    {
                        data: 'poster_img',
                        width: '10%'
                    },
                    {
                        name: 'publish date',
                        data: 'created_date',
                        width: '10%'
                    },
                    {
                        data: 'actions',
                        width: '5%'
                    },
                ],
                columnDefs: [{
                        targets: 'no-sort',
                        orderable: false
                    },
                    // {'max-width': '10%', 'targets': [3]}
                ],
                order: [
                    [2, 'desc']
                ],

            });
        }

        function tablesToReset() {
            $('#datatable1').DataTable().clear().draw(false);
            $('#datatable2').DataTable().clear().draw(false);
        }

        function confirmBeforeDelete(tablesToResetFunction) {
            $(document).on('click', '.delete_item_from_list', function(e) {
                let postId = $(e.currentTarget).data('id');
                url = '/admin/manage-pueblo/delete/' + postId;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You cannot reverse this action',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    cancelButtonColor: 'grey',
                    confirmButtonColor: 'red',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url,
                            method: 'POST',
                            data: {
                                "_method": 'DELETE',
                                "_token": "{{ csrf_token() }}",
                                'id': postId
                            },
                            success: function(data) {
                                if (data.status) {
                                    //reset given/all datatables
                                    tablesToResetFunction();
                                }
                            },
                            error: function(data) {
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
        $(document).ready(function() {

            initializeDatatable('datatable1', 5)
            initializeDatatable('datatable2', 6)

            confirmBeforeDelete(tablesToReset);

            $('.select2').select2();

            $(document).on('click', '.action', function(e) {
                e.preventDefault();
                toggleActivity(e, $(this).data('column'));
            });
            $(document).on('change', '.select2', function(e) {
                var i = $(this).attr('data-column');
                var v = $(this).val();
                let tableId = $(this).closest('table').attr('id');
                $('#' + tableId).DataTable().columns(i).search(v).draw(false);
            });

        });
    </script>
@endsection
@section('css')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
@endsection
