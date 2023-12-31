    <!-- Include necessary libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{--    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
    {{--    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script> --}}
    {{--    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script> --}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> --}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>
    <style>
        .export-form {
            display: inline-block;
            margin-right: 10px;
            /* Adjust the margin as needed */
        }

        .export-button {
            display: inline-block;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="table-responsive">

                <form id="export_advertisement_data_csv" class="export-form" method="post"
                    action="{{ route('download-ad-csv') }}">
                    @csrf
                    <input type="hidden" name="checkedRows" id="csvCheckedRows" value="">
                    <button type="button" id="csvButton" class="export-button">Download Selected as CSV</button>
                </form>
                <form id="export_advertisement_data_pdf" class="export-form" method="post"
                    action="{{ route('download-ad-pdf') }}">
                    @csrf
                    <input type="hidden" name="checkedRows" id="pdfCheckedRows" value="">
                    <button type="button" id="pdfButton" class="export-button">Download Selected as PDF</button>
                </form>

                <table class="table table-bordered" id="{{ $id ?? 'datatable1' }}" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="select-checkbox">Select</th>
                            <th>Id</th>
                            <th>Page</th>
                            <th>Location</th>
                            <th>Redirect Url</th>
                            <th class="no-sort">Advertisement Pic</th>
                            <th class="no-sort hidden">Advertisement Url</th>
                            <th>US/VI</th>
                            <th>US/VI</th>
                            <th>Publish Date</th>
                            <th class="no-sort">Actions</th>

                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th></th>
                            <th class="no-sort">
                                <select name="page" class="select2" data-column="1">
                                    <option value="">Page</option>
                                    @foreach (getPagesForAdvertisementFilter($pageType) as $page)
                                        <option value="{{ $page['page'] }}">{{ $page['page'] }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Display</th>
                            <th class="text-center">Clicked</th>
                            <th></th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#pdfButton').on('click', function() {
            @isset($id)
                let table = $('#{{ $id }}').DataTable();
            @endisset
            let allRows = table.rows().data().toArray();
            let checkedRows = [];
            allRows.forEach(function(row, index) {
                var checkbox = table.row(index).node().querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    checkedRows.push(row);
                }
            });
            if (checkedRows.length > 0) {

                console.log(checkedRows);
                var checkedRowsJson = JSON.stringify(checkedRows);
                console.log(checkedRowsJson);


                $('#pdfCheckedRows').val(checkedRowsJson);

                $('#export_advertisement_data_pdf').submit();
            } else {
                // alert('No rows are selected. Downloading entire table data as PDF.');
            }
        });


        $('#csvButton').on('click', function() {

            @isset($id)
                let table = $('#{{ $id }}').DataTable();
            @endisset
            let allRows = table.rows().data().toArray();
            let checkedRows = [];
            allRows.forEach(function(row, index) {
                var checkbox = table.row(index).node().querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    checkedRows.push(row);
                }
            });
            // console.log(checkedRows.length);

            if (checkedRows.length > 0) {

                console.log(checkedRows);
                var checkedRowsJson = JSON.stringify(checkedRows);
                console.log(checkedRowsJson);

                $('#csvCheckedRows').val(checkedRowsJson);

                $('#export_advertisement_data_csv').submit();
            } else {
                // alert('No rows are selected. Downloading entire table data as CSV.');
            }
        });
    </script>
