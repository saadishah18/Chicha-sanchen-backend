@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.survey.index'),'text' => 'Survey Details'])
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @include('admin.components.partials.session_statuses')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Question</th>
                            <th>Answer</th>
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
                ajax: "{{route('admin.survey.details.datatable',['id' => $id])}}",
                columns: [
                    { data: 'id',width:'2%' },
                    { data: 'question',width:'2%' },
                    { data: 'answer',width:'2%' },
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
                            columns: [ 0, 1, 2],
                        }
                    },
                    {
                        text:'<i class="fas fa-file-pdf"></i> Download PDF',
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [ 0, 1, 2],
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

