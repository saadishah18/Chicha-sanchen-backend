@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage Ad Ons</h1>
        @if (session('success'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('success')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                {{--                @can( 'create_users')--}}
                <a href="{{ route('admin.addons.create') }}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                    <span class="text">Add AdOn</span>
                </a>
                {{--                @endcan--}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Parent</th>
                            <th>Name</th>
                            <th>Values</th>
                            {{--                            <th>Description</th>--}}
                            <th class="no-sort">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>



    <div class="modal fade" id="add_value" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create AdOn Values</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">

                        <div class="col-lg-12">

                            <div id="row">

                                <div class="input-group m-1 ">

                                    <div class="input-group-prepend">

                                        <button class="btn btn-danger"

                                                id="DeleteRow"

                                                type="button">

                                            <i class="bi bi-trash"></i>

                                            Delete

                                        </button>

                                    </div>

                                    <input type="text" class="form-control m-input value_field" name="values[]" value="">
                                    <input type="text" class="form-control m-input price_field" name="price[]" value="" placeholder="Enter Price">
                                </div>
                            </div>


                            <div id="newinput"></div>

                            <button id="add-more" type="button" class="btn  btn-dark">

                        <span class="bi bi-plus-square-dotted">

                        </span> ADD

                            </button>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success submit-values" type="button">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script type="text/javascript">
        $(document).ready(function () {

            var datatable = $('#dataTable').DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.addons.datatable') }}",
                columns: [{
                    data: 'id'
                },
                    {
                        data: 'parent'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'values'
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


            $(document).on('click', '.delete_user_from_list', function (e) {
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
                            success: function (data) {
                                if (data.status) {
                                    datatable.clear().draw();
                                }
                            },
                            error: function (data) {
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
            $(document).on('click', '.toggle_approve', function (e) {
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
                            success: function (data) {
                                if (data.status) {
                                    datatable.ajax.reload(null, false);
                                }
                            },
                            error: function (data) {
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
        $('#add-more').on('click', function () {
            newRowAdd =

                '<div id="row"> <div class="input-group m-1">' +

                '<div class="input-group-prepend">' +

                '<button class="btn btn-danger" id="DeleteRow" type="button">' +

                '<i class="bi bi-trash"></i> Delete</button> </div>' +

                '<input type="text" class="form-control m-input value_field" name="values[]" value=""> ' +
                '<input type="text" class="form-control m-input price_field" name="price[]" value="" placeholder="Enter Price"> </div> </div>';


            $('#newinput').append(newRowAdd);

        });
        $("body").on("click", "#DeleteRow", function () {

            $(this).parents("#row").remove();

        })
        $('.submit-values').click(function() {
            // var modalId = $(this).data('id'); // Get the associated modal ID
            // var formData = $('#form_id_' + modalId).serialize(); // Serialize form data


            var recordId = $('#add_value').data('record-id');
            var formData = { record_id: recordId, values: [], price: [] };
            $('.value_field').each(function() {
                formData.values.push($(this).val());
            });
            $('.price_field').each(function() {
                formData.price.push($(this).val());
            });
            console.log(formData);
            // debugger;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('admin.addons.assign-values')}}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Data Saved');
                    $('#add_value').modal('hide'); // Show the modal
                    window.location.reload();
                },
                error: function(error) {
                    // Handle error
                }
            });
        });
    </script>

@endsection
