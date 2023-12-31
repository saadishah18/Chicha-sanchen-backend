@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @php
            $pageTypes1 = getPagesForAdvertisementFilter(1);
            $pageTypes2 = getPagesForAdvertisementFilter(2);
        @endphp
        <h1 class="h3 mb-1 text-gray-800">Advertisement</h1>
        {{-- @if (session('status'))
            @include('admin.pages.partials.alert', ['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert', ['type' => 'danger', 'message' => session('error')])
        @endif --}}
        <div style="float: right">
            @can('create_advertisements')
                <a href="{{ route('admin.ads.create') }}" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            @endcan
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Virgin Island Advertisement</a>
                <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Caribbean Advertisement</a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="tab1">
                @include('admin.pages.advertisements.datatable', [
                    'id' => 'datatable1',
                    'pageType' => 1,
                    'pages' => $pageTypes1,
                    'buttonId' => 'downloadSelected1',
                ])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="tab2">
                @include('admin.pages.advertisements.datatable', [
                    'id' => 'datatable2',
                    'pageType' => 2,
                    'pages' => $pageTypes2,
                    'buttonId' => 'downloadSelected2',
                ])
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    @include('admin.layouts.partials.sweetalert')
    @include('admin.pages.partials.datatable_pdf_js')
    <script src="https://cdn.datatables.net/1.11.6/js/dataTables.checkboxes.min.js"></script>

    <script type="text/javascript">
        function toggleActivity(e, column = 'is_breaking_news') {
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/advertisement/' + itemId + '/toggle';
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
                            'advertisement_id': itemId,
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

        function initializeOrReinitializeDatatable(tableId, newsTypeId = null) {
            url = `/admin/advertisement/datatable/`
            if (newsTypeId != null) {
                url += newsTypeId
            }
            // Check if DataTable already exists and destroy it
            if ($.fn.DataTable.isDataTable(`#${tableId}`)) {
                $(`#${tableId}`).DataTable().destroy();
            }
            var table = $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: url,
                    error: function(xhr, error, thrown) {
                        console.log('DataTables AJAX Error:', error);
                        console.log('Error details:', thrown);
                    }
                },
                columns: [{
                        data: null,
                        className: 'row-select-checkbox',
                        orderable: false,
                        width: '1%',
                        render: function(data, type, row) {
                            // Return a checkbox input for each row
                            return '<input type="checkbox">';
                        }
                    },
                    {
                        data: 'advertisement_id',
                        width: '1%'
                    },
                    {
                        data: 'page',
                        width: '1%'
                    },
                    {
                        data: 'location',
                        width: '1%'
                    },
                    {
                        data: 'redirect_url',
                        width: '5%'
                    },
                    {
                        data: 'thumbnail',
                        width: '5%'
                    },
                    {
                        data: 'thumbnail_url'
                    },

                    {
                        data: 'used_usvi',
                        width: '1%'
                    },
                    {
                        data: 'clicked_usvi',
                        width: '1%'
                    },
                    {
                        data: 'created_at',
                        width: '4%'
                    },
                    {
                        data: 'actions',
                        width: '10%'
                    },
                ],
                columnDefs: [
                    {
                        targets: 0, // Assuming the checkboxes are in the first column
                        orderable: false, // Disable sorting on the checkbox column
                        className: 'select-checkbox',
                    },
                    {
                        targets: 'no-sort',
                        orderable: false
                    },
                    {
                        targets: 'hidden',
                        visible: false,
                        searchable: false,
                        orderable: false
                    },
                ],
                order: [
                    [7, 'desc']
                ],
                dom: 'Bfrtip',
                // buttons: [{
                //         text: '<i class="fas fa-file-csv"></i> Download Advertisement CSV',
                //         extend: 'csv',
                //         filename: 'Advertisements csv', // Set custom filename for CSV
                //         exportOptions: {
                //             columns: [1, 2, 3, 4, 5, 6, 7],
                //             format: {
                //                 header: function(data, columnIdx) {
                //                     var customNames = {
                //                         7: 'Display US/VI',
                //                         9: 'Clicked US/VI'
                //                     };
                //                     return customNames[columnIdx] || data;
                //                 }
                //             },
                //         }
                //     },
                //     {
                //         text: '<i class="fas fa-file-pdf"></i> Download Advertisement PDF',
                //         extend: 'pdfHtml5',
                //         filename: 'Advertisements pdf', // Set custom filename for CSV
                //         orientation: 'landscape',
                //         pageSize: 'LEGAL',
                //         title: 'Advertisements', // Set custom PDF title
                //         exportOptions: {
                //             columns: [1, 2, 3, 4, 5, 6, 7],
                //             format: {
                //                 header: function(data, columnIdx) {
                //                     var customNames = {
                //                         7: 'Display US/VI',
                //                         9: 'Clicked US/VI'
                //                     };
                //                     return customNames[columnIdx] || data;
                //                 }
                //             },
                //             modifier: {
                //                 selected: null
                //             }
                //         },
                //     },
                // ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input',
                }
            });
            return table;


        }

        function tablesToReset() {
            $('#datatable1').DataTable().clear().draw(false);
            $('#datatable2').DataTable().clear().draw(false);
        }

        function confirmBeforeDelete(tablesToResetFunction) {
            $(document).on('click', '.delete_item_from_list', function(e) {
                let adId = $(e.currentTarget).data('id');
                url = '/admin/advertisement/' + adId;
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
                                'id': adId
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

            // Initialize or reinitialize DataTables
            var datatable1 = initializeOrReinitializeDatatable('datatable1', 5);
            var datatable2 = initializeOrReinitializeDatatable('datatable2', 6);

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
    @include('admin.pages.partials.datatable_pdf_css')
    <style>
        table.table td {
            word-break: break-word;
        }
    </style>
@endsection
