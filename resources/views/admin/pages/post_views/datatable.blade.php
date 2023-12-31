<div class="card shadow mb-4">
    @if($id == 'datatable1')
        <div class="card-header py-3">
            <select name="author" class="select2" data-column="1" data-tbId="{{$id}}">
                <option value="">Select Author</option>
                @foreach(\App\Models\User::whereIn('user_id',\App\Models\NewsContent::distinct('user_id')->whereNotNull('user_id')->select('user_id')->pluck('user_id')->toArray())->whereNotNull('display_name')->where('approve',1)->where('is_email_verify',1)->select('user_id','display_name','username')->orderBy('display_name')->get()->toArray() as $author)
                    <option value="{{$author['user_id']}}">{{$author['display_name'] . ' ('.$author['username'].')'}}
                    </option>
                @endforeach
            </select>
            <select name="category" class="select2" data-column="2" data-tbId="{{$id}}">
                <option value="">Select Category</option>
                @foreach(\App\Models\SidebarCategory::where('open_status',1)->where('category_id','!=',19)->select('category_id','category_name')->orderBy('category_name')->get()->toArray() as $category)
                    <option value="{{$category['category_id']}}">{{$category['category_name']}}</option>
                @endforeach
            </select>
            <select name="year" class="select2" data-column="3" data-tbId="{{$id}}">
                <option value="">Show All Dates</option>
                @foreach(\App\Models\PostViewsRealtime::selectRaw('DATE_FORMAT(latest_view_time, "%M %Y") AS month_year, COUNT(*) AS count')
    ->groupBy('month_year')
    ->orderByRaw("SUBSTRING_INDEX(month_year, ' ', -1) DESC")
    ->get() as $y)
                    <option value="{{$y->month_year}}">{{$y->month_year}}</option>
                @endforeach
            </select>
            <select name="view_type" class="select2" data-column="4" data-tbId="{{$id}}">
                <option value="" disabled>View Type</option>
                <option value="normal" selected>Visitor</option>
                <option value="robot">Robot</option>
            </select>
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="{{$id ?? 'datatable'}}" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="hidden">Author</th>
                    <th class="hidden">Category</th>
                    <th class="hidden">Year</th>
                    <th class="hidden">Type</th>
                    <th>Title</th>
                    <th>Last Viewed Time</th>
                    <th>Today</th>
                    <th>Week</th>
                    <th>Month</th>
                    <th>Half Year</th>
                    <th>Year</th>
                    <th>Total</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
