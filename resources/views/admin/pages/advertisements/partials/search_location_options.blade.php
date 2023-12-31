<option value="">Select Position </option>
@foreach($locations as $location)
    <option value="{{$location['add_setting_id']}}" {{$old_add_setting_id && $old_add_setting_id == $location['add_setting_id'] ? 'selected' : 'null'}}>{{$location['location']}}</option>
@endforeach
