<li data-id="{{$categoryOrder->id}}" class="d-flex justify-content-between align-items-center w-100 bg-white border form-control h-100 my-2" style="max-height: 70px">
    <i class="fas fa-fw fa-list mr-2 cursor-pointer sorting-handle"></i>
    <div class="w-100 pt-2">
        <div class="form-group row">
            <div class="col-sm-10">
                <select name="category_id" class="form-control select2">
                    <option value="">Select Category</option>
                    @foreach($categories  as $cat)
                        <option value="{{$cat->category_id}}" {{$categoryOrder->category_id == $cat->category_id ? 'selected' : ''}}>{{$cat->category_name}}</option>
                    @endforeach
                </select>
                @include('admin.components.error',['error' => 'category_id'])
            </div>
        </div>
    </div>
    <div class="w-100 d-flex justify-content-end ">
        <div class="form-group row">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{'is_displayed_'.$categoryOrder->id}}" id="{{'is_displayed_'.$categoryOrder->id}}" value="1" {{$categoryOrder->is_displayed ? 'checked' : ''}}>
                <label class="form-check-label" for="{{'is_displayed_'.$categoryOrder->id}}">Show </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{'is_displayed_'.$categoryOrder->id}}" id="{{'not_displayed_'.$categoryOrder->id}}" value="0" {{!$categoryOrder->is_displayed ? 'checked' : ''}}>
                <label class="form-check-label" for="{{'not_displayed_'.$categoryOrder->id}}">Hide</label>
            </div>
        </div>
    </div>
</li>
