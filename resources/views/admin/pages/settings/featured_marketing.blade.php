@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Settings</h1>

        <form method="POST" action="{{route('admin.settings.update_featured_marketing')}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link {{!session('tab') ? 'active': ''}} {{session('tab')  && session('tab') == 'vi_tab' ? 'active' : ''}}" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">VI</a>
{{--                    <a class="nav-item nav-link {{session('tab')  && session('tab') == 'caribbean_tab' ? 'active' : ''}}" id="nav-caribbean-tab" data-toggle="tab" href="#nav-caribbean" role="tab" aria-controls="nav-caribbean" aria-selected="false">Caribbean</a>--}}
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="datatable1" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '1. Image/GIF/Video',
                                            'script_id' => 'vi_1_script',
                                            'script' => $dataShow->embed_url_one,
                                            'embed_key' => '1_embed_url_one',
                                            'image_section_id' => 'vi_1_image',
                                            'image_section_number' => '1_image_one',
                                            'iteration' => 'One',
                                            'url' => $dataShow->url_one,
                                            'url_key' => '1_url_one',
                                            'image_url' => $dataShow->getImageOneUrl(),
                                            'status_number' => '1_status_one',
                                            'status' => $dataShow->status_one,
                                            'status_checkbox_id' => 'vi_1_checkbox',
                                            'switch_view_button_id' => 'vi_1',
                                            'file_type_em' =>$dataShow->file_type_one_em,
                                            'file_type' =>$dataShow->file_type_one,
                                            'ads_type' => 'vi'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '2. Image/GIF/Video',
                                            'script_id' => 'vi_2_script',
                                            'script' => $dataShow->embed_url_two,
                                            'embed_key' => '1_embed_url_two',
                                            'image_section_id' => 'vi_2_image',
                                            'image_section_number' => '1_image_two',
                                            'iteration' => 'Two',
                                            'url' => $dataShow->url_two,
                                            'url_key' => '1_url_two',
                                            'image_url' => $dataShow->getImageTwoUrl(),
                                            'status_number' => '1_status_two',
                                            'status' => $dataShow->status_two,
                                            'status_checkbox_id' => 'vi_2_checkbox',
                                            'switch_view_button_id' => 'vi_2',
                                            'file_type_em' =>$dataShow->file_type_two_em,
                                            'file_type' =>$dataShow->file_type_two,
                                            'ads_type' => 'vi'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '3. Image/GIF/Video',
                                            'script_id' => 'vi_3_script',
                                            'script' => $dataShow->embed_url_three,
                                            'embed_key' => '1_embed_url_three',
                                            'image_section_id' => 'vi_3_image',
                                            'image_section_number' => '1_image_three',
                                            'iteration' => 'Three',
                                            'url' => $dataShow->url_three,
                                            'url_key' => '1_url_three',
                                            'image_url' => $dataShow->getImageThreeUrl(),
                                            'status_number' => '1_status_three',
                                            'status' => $dataShow->status_three,
                                            'status_checkbox_id' => 'vi_3_checkbox',
                                            'switch_view_button_id' => 'vi_3',
                                            'file_type_em' =>$dataShow->file_type_three_em,
                                            'file_type' =>$dataShow->file_type_three,
                                            'ads_type' => 'vi'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '4. Image/GIF/Video',
                                            'script_id' => 'vi_4_script',
                                            'script' => $dataShow->embed_url_four,
                                            'embed_key' => '1_embed_url_four',
                                            'image_section_id' => 'vi_4_image',
                                            'image_section_number' => '1_image_four',
                                            'iteration' => 'Four',
                                            'url' => $dataShow->url_four,
                                            'url_key' => '1_url_four',
                                            'image_url' => $dataShow->getImageFourUrl(),
                                            'status_number' => '1_status_four',
                                            'status' => $dataShow->status_four,
                                            'status_checkbox_id' => 'vi_4_checkbox',
                                            'switch_view_button_id' => 'vi_4',
                                            'file_type_em' =>$dataShow->file_type_four_em,
                                            'file_type' =>$dataShow->file_type_four,
                                            'ads_type' => 'vi'
                                        ])
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-caribbean" role="tabpanel" aria-labelledby="nav-caribbean-tab">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '1. Image/GIF/Video',
                                            'script_id' => 'caribbean_1_script',
                                            'script' => $dataShowCaribbean->embed_url_one,
                                            'embed_key' => '2_embed_url_one',
                                            'image_section_id' => 'caribbean_1_image',
                                            'image_section_number' => '2_image_one',
                                            'iteration' => 'One',
                                            'url' => $dataShowCaribbean->url_one,
                                            'url_key' => '2_url_one',
                                            'image_url' => $dataShowCaribbean->getImageOneUrl(),
                                            'status_number' => '2_status_one',
                                            'status' => $dataShowCaribbean->status_one,
                                            'status_checkbox_id' => 'caribbean_1_checkbox',
                                            'switch_view_button_id' => 'caribbean_1',
                                            'file_type_em' => $dataShowCaribbean->file_type_one_em,
                                            'file_type' =>$dataShowCaribbean->file_type_one,
                                            'ads_type' => 'caribbean'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '2. Image/GIF/Video',
                                            'script_id' => 'caribbean_2_script',
                                            'script' => $dataShowCaribbean->embed_url_two,
                                            'embed_key' => '2_embed_url_two',
                                            'image_section_id' => 'caribbean_2_image',
                                            'image_section_number' => '2_image_two',
                                            'iteration' => 'Two',
                                            'url' => $dataShowCaribbean->url_two,
                                            'url_key' => '2_url_two',
                                            'image_url' => $dataShowCaribbean->getImageTwoUrl(),
                                            'status_number' => '2_status_two',
                                            'status' => $dataShowCaribbean->status_two,
                                            'status_checkbox_id' => 'caribbean_2_checkbox',
                                            'switch_view_button_id' => 'caribbean_2',
                                             'file_type_em' => $dataShowCaribbean->file_type_two_em,
                                            'file_type' =>$dataShowCaribbean->file_type_two,
                                            'ads_type' => 'caribbean'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '3. Image/GIF/Video',
                                            'script_id' => 'caribbean_3_script',
                                            'script' => $dataShowCaribbean->embed_url_three,
                                            'embed_key' => '2_embed_url_three',
                                            'image_section_id' => 'caribbean_3_image',
                                            'image_section_number' => '2_image_three',
                                            'iteration' => 'Three',
                                            'url' => $dataShowCaribbean->url_three,
                                            'url_key' => '2_url_three',
                                            'image_url' => $dataShowCaribbean->getImageThreeUrl(),
                                            'status_number' => '2_status_three',
                                            'status' => $dataShowCaribbean->status_three,
                                            'status_checkbox_id' => 'caribbean_3_checkbox',
                                            'switch_view_button_id' => 'caribbean_3',
                                            'file_type_em' => $dataShowCaribbean->file_type_three_em,
                                            'file_type' =>$dataShowCaribbean->file_type_three,
                                            'ads_type' => 'caribbean'
                                        ])
                                    </tr>
                                    <tr>
                                        @include('admin.pages.settings.featured_marketing.item',[
                                            'title' => '4. Image/GIF/Video',
                                            'script_id' => 'caribbean_4_script',
                                            'script' => $dataShowCaribbean->embed_url_four,
                                            'embed_key' => '2_embed_url_four',
                                            'image_section_id' => 'caribbean_4_image',
                                            'image_section_number' => '2_image_four',
                                            'iteration' => 'Four',
                                            'url' => $dataShowCaribbean->url_four,
                                            'url_key' => '2_url_four',
                                            'image_url' => $dataShowCaribbean->getImageFourUrl(),
                                            'status_number' => '2_status_four',
                                            'status' => $dataShowCaribbean->status_four,
                                            'status_checkbox_id' => 'caribbean_4_checkbox',
                                            'switch_view_button_id' => 'caribbean_4',
                                            'file_type_em' => $dataShowCaribbean->file_type_four_em,
                                            'file_type' =>$dataShowCaribbean->file_type_four,
                                            'ads_type' => 'caribbean'
                                        ])
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class=" tab-pane show active" role="tabpanel">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary bg-theme p-2 m-2 btn-small">Save changes</button>
                        <div class="col-sm-10 m-2 p-2 ">
                            <p><b>Note:</b></p>
                            <p><b>1 embed video</b> = width="475" height="315"</p>
                            <p><b>2 embed video</b> = width="237" height="315"</p>
                            <p><b>3 embed video</b> =
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for first two video =&gt; width="237" height="157"
                                <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for last video =&gt;width="475" and height="157"</p>
                            <p><b>4 embed video</b> = width="237" height="157"</p>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
@endsection
@section('js')
    <script>
        function handleImageUpload(mainId = 'image_one'){
            const imageInput = document.getElementById(mainId);
            const imagePreview = document.getElementById(mainId+'_preview');
            const imageCancel = document.getElementById(mainId+'_cancel');

            imageInput.addEventListener('change', () => {
                $('#'+mainId+'_cancel').css('display','block');
                const file = imageInput.files[0];
                const reader = new FileReader();

                reader.onload = () => {
                    imagePreview.src = reader.result;
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            });
            imageCancel.addEventListener('click', (e) => {
                $('#'+mainId+'_cancel').css('display','none');
                imagePreview.src = $('#'+mainId+'_preview').data('saved_url');
                document.getElementById(mainId).value = "";
            });
        }

        function switchVisibility(mainButton){
            $(document).on('click','#'+mainButton,function (e){
                let visibleSection = $(this).data('visible_section')
                if (visibleSection == 'iframe'){
                    $(this).find('input.file_type_em').attr('value',0)
                    $(this).find('span').html('Go to Embed video')
                    $(this).data('visible_section','image');
                    $('#'+mainButton+'_image').css({'display':'block'});
                    $('#'+mainButton+'_script').css({'display':'none'});
                }else{
                    $(this).find('input.file_type_em').attr('value',1)
                    $(this).find('span').html('Go to Image')
                    $(this).data('visible_section','iframe');
                    $('#'+mainButton+'_script').css({'display':'block'});
                    $('#'+mainButton+'_image').css({'display':'none'});


                }
            });
        }

        function switchVisibilityFunctionality(mainButton){
            let visibleSection = $(`#${mainButton}`).data('visible_section')
            if (visibleSection == 'iframe'){
                $(`#${mainButton}`).find('input.file_type_em').attr('value',1)
                $(`#${mainButton}`).find('span').html('Go to Image')
                $(`#${mainButton}`).data('visible_section','iframe');
                $('#'+mainButton+'_script').css({'display':'block'});
                $('#'+mainButton+'_image').css({'display':'none'});
            }else{
                $(`#${mainButton}`).find('input.file_type_em').attr('value',0)
                $(`#${mainButton}`).find('span').html('Go to Embed video')
                $(`#${mainButton}`).data('visible_section','image');
                $('#'+mainButton+'_image').css({'display':'block'});
                $('#'+mainButton+'_script').css({'display':'none'});
            }
        }



        $(document).ready(function (){
            //vi
            switchVisibility('vi_1')
            switchVisibilityFunctionality('vi_1')
            handleImageUpload('1_image_one');

            switchVisibility('vi_2')
            switchVisibilityFunctionality('vi_2')
            handleImageUpload('1_image_two');

            switchVisibility('vi_3')
            switchVisibilityFunctionality('vi_3')
            handleImageUpload('1_image_three');

            switchVisibility('vi_4')
            switchVisibilityFunctionality('vi_4')
            handleImageUpload('1_image_four');

            //caribbean
            // switchVisibility('caribbean_1')
            // switchVisibilityFunctionality('caribbean_1')
            // handleImageUpload('2_image_one');
            //
            // switchVisibility('caribbean_2')
            // switchVisibilityFunctionality('caribbean_2')
            // handleImageUpload('2_image_two');
            //
            // switchVisibility('caribbean_3')
            // switchVisibilityFunctionality('caribbean_3')
            // handleImageUpload('2_image_three');
            //
            // switchVisibility('caribbean_4')
            // switchVisibilityFunctionality('caribbean_4')
            // handleImageUpload('2_image_four');
        });
    </script>
@endsection
