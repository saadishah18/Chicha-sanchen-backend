@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage Products</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3">
{{--                @can( 'create_users')--}}
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Add Product</span>
                    </a>
{{--                @endcan--}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
{{--                            <th>Description</th>--}}
                            <th>Category</th>
                            <th>Parent Category</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Featured</th>
                            <th>Active / In-Active</th>
                            <th class="no-sort">Actions</th>
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
                ajax: "{{ route('admin.products.datatable') }}",
                columns: [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    // {
                    //     data: 'description'
                    // },
                    {
                        data: 'category'
                    },
                    {
                        data: 'parent_category'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'featured'
                    },
                    {
                        data: 'active'
                    },
                    {
                        data: 'actions'
                    },
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }],
            });


            $(document).on('click', '.delete_user_from_list', function(e) {
                let userId = $(e.currentTarget).data('id');
                url = '/admin/users/' + userId;
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
                                'user_id': userId
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
            $(document).on('click', '.toggle_approve', function(e) {
                let userId = $(e.currentTarget).data('id');
                url = '/admin/users/' + userId + '/toggle-approve';
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You can reverse this action anytime',
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
                                'user_id': userId
                            },
                            success: function(data) {
                                if (data.status) {
                                    datatable.ajax.reload(null, false);
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
