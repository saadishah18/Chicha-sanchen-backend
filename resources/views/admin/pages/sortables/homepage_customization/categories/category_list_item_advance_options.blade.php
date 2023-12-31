<li class="d-flex justify-content-between align-items-center w-100 bg-white border form-control h-100 my-2" style="max-height: 120px">
    <i class="fas fa-fw fa-list mr-2"></i>
    <div class="w-100 pt-2">
        <div class="form-group">
            1
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_breaking_news" id="is_breaking_news">
                <label class="form-check-label" for="is_breaking_news">Category</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_breaking_news" id="not_breaking_news">
                <label class="form-check-label" for="not_breaking_news">Advertisement</label>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <select name="category_id" id="category_id" class="form-control select2">
                    <option value="">Select Category</option>
                    <option value="Left content">Category 1</option>
                    <option value="Right content">Category 2</option>
                </select>
                @include('admin.components.error',['error' => 'category_id'])
            </div>
        </div>
    </div>
    <div class="w-100">
        <div class="form-group row">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_breaking_news" id="is_breaking_news">
                <label class="form-check-label" for="is_breaking_news">Category</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_breaking_news" id="not_breaking_news">
                <label class="form-check-label" for="not_breaking_news">Advertisement</label>
            </div>
        </div>
        <div class="form-group row">
            <select name="category_id" id="category_id" class="form-control select2">
                <option value="">Select Main Category</option>
                <option value="Left content">Left content</option>
                <option value="Left content">Right content</option>
            </select>
            @include('admin.components.error',['error' => 'category_id'])
        </div>

    </div>
    <div class="w-100 d-flex justify-content-end align-items-end">
        <button class="btn btn-secondary">-</button>
        <button class="btn btn-primary ml-2">+</button>
    </div>
</li>
