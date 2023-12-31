@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @php
            $pageTypes1 = getPagesForAdvertisementFilter(1);
            $pageTypes2 = getPagesForAdvertisementFilter(2);
        @endphp
        <h1 class="h3 mb-2 text-gray-800">Video List</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif
        <div class="card-header py-3">
            @can('upload_videos')
                <a href="{{ route('admin.videos.create') }}" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New Video</span>
                </a>
            @endcan
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Virgin Island Videos</a>
                <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Caribbean Videos</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="tab1">
                @include('admin.pages.videos.datatable', ['id' => 'datatable1', 'pages' => $pageTypes1])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="tab2">
                @include('admin.pages.videos.datatable', ['id' => 'datatable2', 'pages' => $pageTypes2])
            </div>
        </div>


    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">
        function toggleActivity(e, column = 'is_breaking_news') {
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/videos/' + itemId + '/toggle';
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

        function initializeDatatable(tableId, newsTypeId = null) {
            url = `/admin/videos/datatable/`
            if (newsTypeId != null) {
                url += newsTypeId
            }
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'content_id',
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
                        data: 'mark_as_live',
                        width: '1%'
                    },
                    {
                        data: 'comments_count',
                        width: '1%'
                    },
                    {
                        name: 'publish_date',
                        data: 'schedule_date',
                        width: '4%'
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
                    [5, 'desc']
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
                url = '/admin/videos/' + postId;
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

            $(document).on('click', '.action', function(e) {
                e.preventDefault();
                toggleActivity(e, $(this).data('column'));
            });
        });
    </script>
@endsection
