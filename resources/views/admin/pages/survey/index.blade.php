@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Survey</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('status')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Location</th>
                            <th>Age</th>
                            <th>Gender</th>
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
    @include('admin.pages.partials.datatable_pdf_js')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#dataTable').DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.survey.datatable')}}",
                columns: [
                    { data: 'id',width:'20%' },
                    { data: 'location',width:'20%' },
                    { data: 'age',width:'20%' },
                    { data: 'gender',width:'20%' },
                    { data: 'actions',width: '20%' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false }
                ],
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text:'<i class="fas fa-file-csv"></i> Download CSV',
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3],
                        }
                    },
                    {
                        text:'<i class="fas fa-file-pdf"></i> Download PDF',
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3],
                        },
                    },
                ],
            });


        });
    </script>
@endsection
@section('css')
    @include('admin.pages.partials.datatable_pdf_css')
@endsection

