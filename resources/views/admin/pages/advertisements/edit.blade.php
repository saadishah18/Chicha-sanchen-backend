@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @if( $ad && isset( $ad->advertisement_id))
            @include('admin.components.errors')
            @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.ads.index'),'text' => 'Edit Advertisement'])
            <form method="post" action="{{ route('admin.ads.update',['id' => $ad->advertisement_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-9">
{{--                @dd($ad)--}}
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="page">Page<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="page" class="form-control" id="page">
                            <option value="">Select Page</option>
                            @foreach(getPagesForAdvertisementFilter() as $page)
                                <option value="{{$page['page']}}" {{old('page',$ad->page) == $page['page'] ? 'selected' : ''}}>{{$page['page']}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'page'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="add_setting_id">Position<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="add_setting_id" class="form-control" id="add_setting_id">
                            <option value="">Select Position </option>
                            <option value="{{$ad->add_setting_id}}" selected>{{$ad->setting->location}}</option>
                        </select>
                        @include('admin.components.error',['error' => 'page'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ads Type</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline ads_type">
                            <input class="form-check-input" type="radio" name="type" id="custom" value="0" {{old('type', $ad->type) == 0 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="custom">Custom Ad</label>
                        </div>
                        <div class="form-check form-check-inline ads_type">
                            <input class="form-check-input" type="radio" name="type" id="google" value="1" {{old('type', $ad->type) == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="google">Google Ad</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'type'])
                </div>
                <div class="form-group row" id="redirect_url_div">
                    <label for="redirect_url" class="col-sm-2 col-form-label">Redirect Url<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="redirect_url" id="redirect_url" value="{{old('redirect_url',$ad->redirect_url)}}" placeholder="Redirect Url" >
                        @include('admin.components.error',['error' => 'redirect_url'])
                    </div>
                </div>
                <div class="form-group row" id="custom_ad_image_div">
                    <div id="image-container" class="text-center mb-5 d-flex  w-100">
                        <div class="col-sm-2">
                            <label class="col-form-label"> Advertisement Image </label>
                        </div>
                        <div class=" border-dashed p-10 col-sm-10">
                            <div class="flex-column">
                                <img width="400px" id="image_preview" class="object-cover img-space" onerror="this.onerror=null; this.src=this.style.display = 'none'" src="{{$ad->getAttachmentUrl()}}" alt="Advertisement Image">
                            </div>
                            <label class="col-form-label  cursor-pointer" for="advertisement_pic">
                                <div id="edit-icon" class="edit-icon  translate-middle hidden">
                                    <div><i class="fas fa-image"></i> Please upload advertisement image</div>
                                </div>
                            </label>
                            <p class="text-gray-500 py-0 my-0">Note: Only png,jpeg,gif and bmp file format are allowed.</p>
                            <p class="text-gray-500 py-0 my-0">Image can be maximum 5MB size.</p>
                            <p class="text-gray-500">Image should be 420px x 280px</p>
                            <input type="hidden" name="advertisement_pic_uploaded" value="{{$ad->getAttachmentUrl()}}">
                            <input id="advertisement_pic"  name="advertisement_pic" type="file" accept="image/png,image/jpg,image/jpeg,image/webp"  class="d-none" />
                            @include('admin.components.error',['error' => 'advertisement_pic'])
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="display: none;" id="ad_script">
                    <label for="advertisement_script" class="col-sm-2 col-form-label">Enter Google Advertisement Code</label>
                    <div class="col-sm-10">
                        <textarea rows="5" class="form-control" name="advertisement_script" id="advertisement_script"  placeholder="Google Advertisement script" >{{old('advertisement_script',$ad->advertisement_script)}}</textarea>
                        @include('admin.components.error',['error' => 'advertisement_script'])
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">

        const customAdImagePreview = document.getElementById('image_preview');
        const customAdImageInput = document.getElementById('advertisement_pic');
        customAdImageInput.addEventListener('change', () => {
            $('#image_preview').css('display','block');
            const file = customAdImageInput.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                customAdImagePreview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        function showRedirectUrlSection(){
            $('#redirect_url_div').show();
            $('#custom_ad_image_div').show();
            $('#ad_script').hide();

        }
        function showGoogleAdSection(){
            $('#redirect_url_div').hide();
            $('#custom_ad_image_div').hide();
            $('#ad_script').show();

        }

        $(document).ready(function() {

            $('.select2').select2();

            $('.ads_type').click(function() {
                if($('#custom').is(':checked')) {
                    showRedirectUrlSection();
                    $('#redirect_url').val('');
                }else{
                    showGoogleAdSection();
                    $('#advertisement_pic').val('');
                }
            });
            setTimeout(async ()=> {
                await $('#page').trigger('change');
            },1000)

            function getAdType(){
                let ad_type = 0;
                if($('#custom').is(':checked')) {
                    ad_type = 0;
                }else if($('#google').is(':checked')) {
                    ad_type = 1;
                }
                return ad_type;
            }
            function getLocationType(){
                let location_type = null;
                if($('#location_type_1').is(':checked')) {
                    location_type = 1;
                }else if($('#location_type_2').is(':checked')) {
                    location_type = 2;
                }else if($('#location_type_3').is(':checked')) {
                    location_type = 3;
                }
                return location_type;
            }
            @if( $ad && isset( $ad->advertisement_id))
            $(document).on("change","#page", function(event) {
                /* Act on the event */
                event.preventDefault();
                var elem = $(this);
                var page = elem.val();

                let location_type = getLocationType();
                let url ="/admin/advertisement/get-locations";
                $.ajax({
                    url,
                    method: 'POST',
                    data: { "_token": "{{ csrf_token() }}",'page':page,'location_type':location_type,old_add_setting_id:'{{$ad->add_setting_id}}' },
                    success: function (data) {
                        if (data.status){
                            $("#add_setting_id").html(data.locations);
                        }
                    },
                    error:function (data){
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: data?.responseJSON?.message,
                        })
                    }
                });
            });
            @endif
            @if($ad)
            if ('{{$ad->type}}' == 0){
                showRedirectUrlSection()
            }else{
                showGoogleAdSection();
            }
            @endif

        }); //ready
    </script>
@endsection

@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
    <style>
        .border-dashed{
            border:dashed;
        }
        .p-10{
            padding: 4rem;
        }
        .cursor-pointer{
            cursor: pointer;
        }
        .img-space{
            margin: 1rem auto 1rem auto;
        }
    </style>
@endsection

