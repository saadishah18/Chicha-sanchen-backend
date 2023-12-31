<div class="card shadow mb-4">
    @if ($id == 'datatable1')
        <div class="card-header py-3">
            @can('create_posts')
                <a href="{{ route('admin.posts.create', ['newsTypeId' => request()->newsTypeId]) }}"
                    class="btn btn-info btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New Post</span>
                </a>
            @endcan
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="{{ $id ?? 'datatable' }}" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>News Id</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Tags</th>
                        <th class="no-sort">Thumbnail</th>
                        <th><i class="fas fa-comment"></i></th>
                        <th>Publish Date</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th class="no-sort"></th>
                        <th class="no-sort"></th>
                        <th class="no-sort">
                            <select name="author" class="select2" data-column="2">
                                <option value="">Select Author</option>
                                @foreach (\App\Models\User::whereIn(
        'user_id',
        \App\Models\NewsContent::distinct('user_id')->whereNotNull('user_id')->select('user_id')->pluck('user_id')->toArray(),
    )->whereNotNull('display_name')->where('approve', 1)
    // ->where('is_email_verify', 1)
    ->select('user_id', 'display_name', 'username')->orderBy('display_name')->get()->toArray() as $author)
                                    <option value="{{ $author['user_id'] }}">
                                        {{ $author['display_name'] . ' (' . $author['username'] . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </th>
                        <th class="no-sort">
                            <select name="category" class="select2" data-column="3">
                                <option value="">Select Category</option>
                                @foreach (\App\Models\SidebarCategory::where('open_status', 1)->where('category_id', '!=', 19)->select('category_id', 'category_name')->orderBy('category_name')->get()->toArray() as $category)
                                    <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </th>
                        <th class="no-sort"></th>
                        <th class="no-sort"></th>
                        <th class="no-sort"></th>
                        <th class="no-sort">
                            <select name="year" class="select2" data-column="7">
                                <option value="">Select Year</option>
                                @foreach (range(now()->year, 2013) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
