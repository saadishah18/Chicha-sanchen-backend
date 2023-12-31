<div class="card shadow mb-4">
    @if ($id == 'datatable1')
        <div class="card-header py-3">
            @can('create_real_estate_listings')
                <a href="{{ route('admin.real_estates.create') }}" class="btn btn-info btn-icon-split">
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
                        <th>Email</th>
                        <th>Address</th>
                        <th>Type</th>
                        <th class="no-sort">Thumbnail</th>
                        <th>Payment Status</th>
                        <th>Publish Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
