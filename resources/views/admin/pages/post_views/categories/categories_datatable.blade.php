<div class="card shadow mb-4">
    @if($id == 'datatable1')
        <div class="card-header py-3">
            <select name="category" class="select2" data-column="1" data-tbId="{{$id}}">
                <option value="">Select Category</option>
                @foreach(\App\Models\SidebarCategory::where('open_status',1)->where('category_id','!=',19)->select('category_id','category_name')->orderBy('category_name')->get()->toArray() as $category)
                    <option value="{{$category['category_id']}}">{{$category['category_name']}}</option>
                @endforeach
            </select>

            <select name="view_type" class="select2" data-column="2" data-tbId="{{$id}}">
                <option value="" disabled>View Type</option>
                <option value="normal" selected>Visitor</option>
                <option value="robot">Robot</option>
            </select>
{{--            <select name="sort_type" class="select2" data-column="3" data-tbId="{{$id}}">--}}
{{--                <option value="" disabled>View Type</option>--}}
{{--                <option value="most" selected>Most</option>--}}
{{--                <option value="latest">Latest</option>--}}
{{--            </select>--}}
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="{{$id ?? 'datatable'}}" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="hidden">Category</th>
                    <th class="hidden">Type</th>
                    <th class="hidden">Sort</th>
                    <th>Title</th>
                    <th>Total Views</th>
                    <th>By Year</th>
                    <th>By Half Year</th>
                    <th>By Month</th>
                    <th>By Week</th>
                    <th>Today</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
