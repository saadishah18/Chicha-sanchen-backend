@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage Tags</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @can('create_tags')
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Add New Tag</span>
                    </a>
                @endcan
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">
        $(document).ready(function() {

            var datatable = $('#dataTable').DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tags.datatable') }}",
                columns: [{
                        data: 'tag_id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'slug'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'actions'
                    },
                ]
            });


            $(document).on('click', '.delete_item_from_list', function(e) {
                let tagId = $(e.currentTarget).data('id');
                url = '/admin/tags/' + tagId;
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
                                'id': tagId
                            },
                            success: function(data) {
                                if (data.status) {
                                    datatable.clear().draw();
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
        });
    </script>
@endsection
