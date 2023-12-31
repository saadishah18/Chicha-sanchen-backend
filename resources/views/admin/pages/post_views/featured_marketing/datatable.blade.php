<div class="card shadow mb-4">
    <div class="card-body">
        @php
            $dataShow = $data['data_show'];
        @endphp
        <div class="table-responsive">
            <table class="table table-bordered" id="{{$id ?? 'datatable'}}" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Redirect Url</th>
                    <th>Marketing</th>
                    <th>Caribbean</th>
                    <th>US/VI</th>
                    <th>Caribbean</th>
                    <th>US/VI</th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2">Display</th>
                    <th colspan="2">Clicked</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Section 1</td>
                    <td><a target="_blank" href="{{$dataShow->url_one}}">{{$dataShow->url_one}}</a></td>
                    <td>
                        @if($dataShow->file_type_one_em == 1)
                            {!! $dataShow->embed_url_one !!}
                        @else
                            @if($dataShow->file_type_one=="image")
                                <img style="object-fit: contain" onerror="this.onerror=null; this.src=this.style.display = 'none'; this.insertAdjacentHTML('afterend', 'Image could not be loaded.');" src="{{"{$dataShow->getImageOneUrl()}?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=250&amp;w=240"}}" width="250" height="250" />
                            @else
                                <video  controls style="width: 506px !important;height: 329px !important;">
                                    <source src="{{$dataShow->getImageOneUrl()}}" type="video/mp4"/>
                                    <source src="{{$dataShow->getImageOneUrl()}}" type="video/ogg"/>
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td>{{$data['section_one_total_display_cari']}}</td>
                    <td>{{$data['section_one_total_display']}}</td>
                    <td>{{$data['section_one_total_cari']}}</td>
                    <td>{{$data['section_one_total']}}</td>
                </tr>
                <tr>
                    <td>Section 2</td>
                    <td><a target="_blank" href="{{$dataShow->url_two}}">{{$dataShow->url_two}}</a></td>
                    <td>
                        @if($dataShow->file_type_two_em == 1)
                            {!! $dataShow->embed_url_two !!}
                        @else
                            @if($dataShow->file_type_two == "image")
                                <img style="object-fit: contain" onerror="this.onerror=null; this.src=this.style.display = 'none'; this.insertAdjacentHTML('afterend', 'Image could not be loaded.');" src="{{"{$dataShow->getImageTwoUrl()}?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=250&amp;w=240"}}" width="250" height="250" />
                            @else
                                <video  controls style="width: 506px !important;height: 329px !important;">
                                    <source src="{{$dataShow->getImageTwoUrl()}}" type="video/mp4"/>
                                    <source src="{{$dataShow->getImageTwoUrl()}}" type="video/ogg"/>
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td>{{$data['section_two_total_display_cari']}}</td>
                    <td>{{$data['section_two_total_display']}}</td>
                    <td>{{$data['section_two_total_cari']}}</td>
                    <td>{{$data['section_two_total']}}</td>
                </tr>
                <tr>
                    <td>Section 3</td>
                    <td><a target="_blank" href="{{$dataShow->url_three}}">{{$dataShow->url_three}}</a></td>
                    <td>
                        @if($dataShow->file_type_three_em == 1)
                            {!! $dataShow->embed_url_three !!}
                        @else
                            @if($dataShow->file_type_three == "image")
                                <img style="object-fit: contain" onerror="this.onerror=null; this.src=this.style.display = 'none'; this.insertAdjacentHTML('afterend', 'Image could not be loaded.');" src="{{"{$dataShow->getImageThreeUrl()}?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=250&amp;w=240"}}" width="250" height="250" />
                            @else
                                <video  controls style="width: 506px !important;height: 329px !important;">
                                    <source src="{{$dataShow->getImageThreeUrl()}}" type="video/mp4"/>
                                    <source src="{{$dataShow->getImageThreeUrl()}}" type="video/ogg"/>
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td>{{$data['section_three_total_display_cari']}}</td>
                    <td>{{$data['section_three_total_display']}}</td>
                    <td>{{$data['section_three_total_cari']}}</td>
                    <td>{{$data['section_three_total']}}</td>
                </tr>
                <tr>
                    <td>Section 4</td>
                    <td><a target="_blank" href="{{$dataShow->url_four}}">{{$dataShow->url_four}}</a></td>
                    <td>
                        @if($dataShow->file_type_four_em == 1)
                            {!! $dataShow->embed_url_four !!}
                        @else
                            @if($dataShow->file_type_four == "image")
                                <img style="object-fit: contain" onerror="this.onerror=null; this.src=this.style.display = 'none'; this.insertAdjacentHTML('afterend', 'Image could not be loaded.');" src="{{"{$dataShow->getImageFourUrl()}?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=250&amp;w=240"}}" width="250" height="250" />
                            @else
                                <video  controls style="width: 506px !important;height: 329px !important;">
                                    <source src="{{$dataShow->getImageFourUrl()}}" type="video/mp4"/>
                                    <source src="{{$dataShow->getImageFourUrl()}}" type="video/ogg"/>
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
