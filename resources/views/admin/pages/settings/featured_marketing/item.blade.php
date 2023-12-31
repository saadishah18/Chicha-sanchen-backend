<td>{{$title ?? ''}}</td>
<td width="60%">
    <div id="{{$script_id}}">
        <textarea rows="5" class="form-control" name="{{$embed_key ?? ''}}"  placeholder="Embed Iframe" >{{$script}}</textarea>
    </div>
    <div id="{{$image_section_id}}" style="display: none">

        <div class="pt-2 bg-gray-100 mt-2">
            <input type="file" name="{{$image_section_number}}" id="{{$image_section_number}}" accept="image/*">
        </div>

        @if($file_type == "image")
            <img style="max-width: 400px; margin-top:10px;" data-saved_url="{{$image_url}}" src="{{$image_url}}" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="{{$image_section_number}}" id="{{$image_section_number}}_preview">
        @else
            <video  controls style="width: 506px !important;height: 329px !important;">
                <source src="{{$image_url}}" type="video/mp4"/>
                <source src="{{$image_url}}" type="video/ogg"/>
                Your browser does not support the video tag.
            </video>
        @endif
        <button type="button" class="btn btn-secondary btn-icon-split mt-2" id="{{$image_section_number}}_cancel" style="display: none">
            <span class="text">Remove this image</span>
        </button>
        <div class="form-group row pt-2">
            <label for="{{$image_section_number}}_url" class="col-sm-3 col-form-label tex-dark">Url {{$iteration}}</label>
            <input class="col-sm-9" type="text" name="{{$url_key}}" id="{{$image_section_number}}_url" value="{{$url}}" />
        </div>
    </div>
</td>
<td>
    <div class="form-group row text-center">
        <div class="col-sm-9">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="{{$status_number}}" {{$status ? 'checked' : ''}} id="{{$status_checkbox_id}}" value="{{$status}}">
                <label class="form-check-label" for="{{$status_checkbox_id}}">Show on frontend</label>
            </div>
            <button type="button" class="btn btn-secondary btn-icon-split" id="{{$switch_view_button_id}}" data-visible_section="{{$file_type_em ? 'iframe' : 'image'}}">
                <input type="hidden" name="{{($ads_type == 'vi' ? '1':'2').'_file_type_'.strtolower($iteration).'_em'}}" class="file_type_em" value="{{$file_type_em}}">
                <span class="text">Go to Image</span>
            </button>
        </div>
        @include('admin.components.error',['error' => $status_number])
    </div>
</td>
