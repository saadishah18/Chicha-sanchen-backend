<div class="card shadow mb-4">
    @if ($id == 'datatable1')
        <div class="card-header py-3">
            @can('create_obituaries')
                <a href="{{ route('admin.obituaries.create') }}" class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            @endcan
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="{{ $id ?? 'datatable' }}" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="hidden">#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th class="no-sort">Thumbnail</th>
                        <th>Payment Status</th>
                        <th>Contact Number</th>
                        <th>Publish Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
