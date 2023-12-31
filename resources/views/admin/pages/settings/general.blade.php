@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Settings</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link {{!session('tab') ? 'active': ''}} {{session('tab')  && session('tab') == 'general' ? 'active' : ''}}" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">General Settings</a>
                <a class="nav-item nav-link {{session('tab')  && session('tab') == 'social' ? 'active' : ''}}" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Social Settings</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show {{!session('tab') ? 'active': ''}} {{session('tab') == 'general' ? 'active' : ''}} " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <form class="mt-3" method="post" action="{{ route('admin.settings.update') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg">
                       @include('admin.components.partials.session_statuses')
                        <input type="hidden" name="tab" value="general">

                        {{--1--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'website_url', 'fieldTitle' => 'Site Address (URL)', 'fieldName' => 'website_url', 'placeholder' => 'Website url', 'readonly' => true, 'disabled' => true, 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['website_url'] ])
                        {{--2--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'admin_email', 'fieldTitle' => 'Admin Email', 'placeholder' => 'Admin Email', 'readonly' => true, 'disabled' => true, 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['admin_email'] ])

                        {{--3--}}

                        @include('admin.components.form.input', [ 'fieldId' => 'support_email', 'fieldTitle' => 'Support Email', 'required' => true, 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['support_email'] ])

                        {{--4--}}

                        @include('admin.components.form.input', [ 'fieldId' => 'noreply_email', 'fieldTitle' => 'No Reply Email', 'required' => true, 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['noreply_email'] ])

                        {{--5--}}
                        <div class="form-group row">
                            <label for="footer_text" class="col-sm-3 col-form-label">Footer Text</label>
                            <div class="col-sm-9">
                                <textarea rows="5" class="form-control" name="footer_text"  placeholder="Footer text" >{{$settings['footer_text']}}</textarea>
                                @include('admin.components.error',['error' => 'footer_text'])
                            </div>
                        </div>

                        {{--6--}}

                        @include('admin.components.form.input', [ 'fieldId' => 'copyright', 'fieldTitle' => 'Copyright', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['copyright'] ])

                            <hr/>
                        {{--7--}}
                        <div class="form-group row">
                            <label for="favicon" class="col-sm-3 col-form-label">Upload Favicon</label>
                            <div class="col-sm-9">
                                <img src="{{getSettings('favicon')->getFaviconUrl()}}" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="favicon" id="favicon_image_preview">
                                <div class="pt-2 bg-gray-100 mt-2">
                                    <input type="file" name="favicon" id="favicon" accept="image/*">
                                </div>
                                @include('admin.components.error',['error' => 'favicon'])
                            </div>
                        </div>
                        <hr/>

                            {{--8--}}
                            <div class="form-group row">
                                <label for="logo" class="col-sm-3 col-form-label">Upload Logo</label>
                                <div class="col-sm-9">
                                    <img src="{{getSettings('logo')->getLogoUrl()}}" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="logo" id="logo_image_preview">
                                    <div class="pt-2 bg-gray-100 mt-2">
                                        <input type="file" name="logo" id="logo" accept="image/*">
                                    </div>
                                    @include('admin.components.error',['error' => 'logo'])
                                </div>
                            </div>

                            {{--9--}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Site Status</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="site_status" id="yesRadio" value="1" {{$settings['site_status'] == 1 ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="yesRadio">On</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="site_status" id="noRadio" value="0" {{$settings['site_status'] == 0 ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="noRadio">Off</label>
                                    </div>
                                </div>
                                @include('admin.components.error',['error' => 'site_status'])
                            </div>
                            <hr/>


                            {{--10--}}
                            <div class="form-group row">
                                <label for="site_background" class="col-sm-3 col-form-label">Upload Background Image</label>
                                <div class="col-sm-9">
                                    <img height="80px" src="{{getSettings('site_background')->getSiteBackgroundUrl()}}" onerror="this.onerror=null; this.src=this.src=this.style.display = 'none'" alt="site_background" id="site_background_image_preview">
                                    <div class="pt-2 bg-gray-100 mt-2">
                                        <input type="file" name="site_background" id="site_background" accept="image/*">
                                    </div>
                                    @include('admin.components.error',['error' => 'site_background'])
                                </div>
                            </div>
                            {{--11--}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Background Image Status</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="background_status" id="yesRadio" value="1" {{$settings['background_status'] == 1 ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="yesRadio">On</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="background_status" id="noRadio" value="0" {{$settings['background_status'] == 0 ? 'checked' : ''}} required>
                                        <label class="form-check-label" for="noRadio">Off</label>
                                    </div>
                                </div>
                                @include('admin.components.error',['error' => 'background_status'])
                            </div>
                            <hr/>




                        {{--11--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'background_url', 'fieldTitle' => 'Background URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['background_url']])

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="tab-pane fade {{session('tab') == 'social' ? 'show active' : ''}}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form class="mt-3" method="post" action="{{ route('admin.settings.update') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg">
                        @include('admin.components.partials.session_statuses')
                        <input type="hidden" name="tab" value="social">

                        {{--1--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'fb_url', 'fieldTitle' => 'Facebook URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['fb_url'] ])
                        {{--2--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'twitter_url', 'fieldTitle' => 'Twitter URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['twitter_url'] ])

                        {{--3--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'instagram_url', 'fieldTitle' => 'Instagram URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['instagram_url'] ])

                        {{--4--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'pinterest_url', 'fieldTitle' => 'Pinterest URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['pinterest_url'] ])

                        {{--5--}}
                        @include('admin.components.form.input', [ 'fieldId' => 'linkedin_url', 'fieldTitle' => 'LinkedIn URL', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9', 'value' => $settings['linkedin_url'] ])
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>


    </div>
@endsection
@section('js')
    <script>
        const faviconImagePreview = document.getElementById('favicon_image_preview');
        const faviconInput = document.getElementById('favicon');

        const logoImagePreview = document.getElementById('logo_image_preview');
        const logoInput = document.getElementById('logo');

        const siteBackgroundInput = document.getElementById('site_background');
        const siteBackgroundImagePreview = document.getElementById('site_background_image_preview');

        faviconInput.addEventListener('change', () => {
            $('#favicon_image_preview').css('display','block');
            const file = faviconInput.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                faviconImagePreview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        });

        siteBackgroundInput.addEventListener('change', () => {
            $('#site_background_image_preview').css('display','block');
            const file = siteBackgroundInput.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                siteBackgroundImagePreview.src = reader.result;
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        });

        logoInput.addEventListener('change', () => {
            $('#logo_image_preview').css('display','block');
            const file = logoInput.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                logoImagePreview.src = reader.result;
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
