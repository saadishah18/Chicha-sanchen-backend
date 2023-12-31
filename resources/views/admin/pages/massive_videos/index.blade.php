@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Massive Video ad at Homepage
        </h1>
        @if (session('status'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif
        <div class="card-header py-3">
            @can('upload_massive_videos_for_homepage')
                <a href="{{ route('admin.massive_videos.create') }}" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New Video</span>
                </a>
            @endcan
        </div>
        @include('admin.pages.massive_videos.datatable', ['id' => 'datatable1'])



    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">
        function toggleActivity(e, column = 'is_breaking_news') {
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/massive-videos/' + itemId + '/toggle';
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

        function initializeDatatable(tableId) {
            url = `/admin/massive-videos/datatable/`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'id',
                        width: '1%'
                    },
                    {
                        data: 'title',
                        width: '15%'
                    },
                    {
                        data: 'thumbnail',
                        width: '5%'
                    },
                    {
                        data: 'heading',
                        width: '15%'
                    },
                    {
                        data: 'actions',
                        width: '10%'
                    },
                ],
                columnDefs: [{
                        targets: 'no-sort',
                        orderable: false
                    },
                    // {'max-width': '10%', 'targets': [3]}
                ],
                order: [
                    [1, 'asc']
                ],

            });
        }

        function tablesToReset() {
            $('#datatable1').DataTable().clear().draw(false);
        }

        function confirmBeforeDelete(tablesToResetFunction) {
            $(document).on('click', '.delete_item_from_list', function(e) {
                let postId = $(e.currentTarget).data('id');
                url = '/admin/massive-videos/' + postId;
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

            initializeDatatable('datatable1')

            confirmBeforeDelete(tablesToReset);

            $(document).on('click', '.action', function(e) {
                e.preventDefault();
                toggleActivity(e, $(this).data('column'));
            });
        });
    </script>
@endsection
