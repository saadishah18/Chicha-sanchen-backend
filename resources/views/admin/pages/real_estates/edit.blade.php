@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.real_estates.index'),'text' => 'Edit Property'])
        <form method="post" action="{{ route('admin.real_estates.update',['id' => $realEstate->real_estate_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="col-lg-9">

                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="p_type">Place<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="p_type" id="p_type" class="form-control select2 @error('p_type') is-invalid @enderror" data-placeholder="Select Place">
                            <option value="">Select Place </option>
                            @foreach(\App\Models\NewsType::whereIn('type',[2,3])->select('news_type_id','news_type')->get() as $newsType)
                                <option value="{{$newsType->news_type_id}}" {{old('p_type',$realEstate->p_type) ==  $newsType->news_type_id  ? 'selected' : ''}}>{{$newsType->news_type}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'p_type'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" value="{{old('title',$realEstate->title)}}" placeholder="Title" required>
                        @include('admin.components.error',['error' => 'title'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Slug<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" value="{{old('slug',$realEstate->slug)}}" placeholder="Slug" required>
                        @include('admin.components.error',['error' => 'slug'])
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tags" class="col-sm-2 col-form-label">Author<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="user_id" id="user_id" class="form-control select2 @error('user_id') is-invalid @enderror" data-placeholder="Select Author">
                            <option disabled>Select Author</option>
                            @foreach(getAuthors() as $author)
                                <option value="{{$author->user_id}}" {{(old('user_id',$realEstate->user_id) == $author->user_id) ? 'selected' : ''}}>{{$author->display_name . ' ('.$author->username.')'}}</option>
                            @endforeach
                        </select>
                        @include('admin.components.error',['error' => 'user_id'])
                    </div>
                </div>



                <div class="form-group row">
                    <label for="content" class="col-sm-2 col-form-label">Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control content" id="content" name="content"  placeholder="Enter content" >{{old('content',$realEstate->content)}}</textarea>
                        @include('admin.components.error',['error' => 'content'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">Type<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="type" class="form-control  @error('type') is-invalid @enderror" id="type">
                            <option value="" selected="selected">Select Type</option>
                            <option value="rent"  {{ old('type',$realEstate->type) == 'rent' ? 'selected' : ''}}>For Rent</option>
                            <option value="sell" {{ old('type',$realEstate->type) == 'sell' ? 'selected' : ''}}>For Sell</option>
                        </select>
                        @include('admin.components.error',['error' => 'type'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="location" class="col-sm-2 col-form-label">Location<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="location" id="location" value="{{old('location',$realEstate->location)}}" placeholder="Slug" required>
                        @include('admin.components.error',['error' => 'location'])
                    </div>
                </div>

                <div class="form-group row d-none" id="latitudeArea">
                    <label class="col-sm-2 col-form-label">Latitude</label>
                    <div class="col-sm-10">
                        <input type="text" id="lat" name="lat" class="form-control">
                    </div>
                </div>

                <div class="form-group row d-none" id="longitudeArea">
                    <label class="col-sm-2 col-form-label">Longitude</label>
                    <div class="col-sm-10">
                        <input type="text" id="long" name="long" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price">Price<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Enter price" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price',$realEstate->price)}}">
                        @include('admin.components.error',['error' => 'price'])
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">Total Beds<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control @error('total_beds') is-invalid @enderror" id="total_beds" name="total_beds">
                            <option value="">Select Bedrooms</option>
                            <option value="Any Beds" {{old('total_beds',$realEstate->total_beds) == 'Any Beds' ? 'selected' : ''}}>Any Beds</option>
                            <option value="Studio" {{old('total_beds',$realEstate->total_beds) == 'Studio' ? 'selected' : ''}}>Studio</option>
                            <option value="1" {{old('total_beds',$realEstate->total_beds) == '1' ? 'selected' : ''}}>1 Bed</option>
                            <option value="1+" {{old('total_beds',$realEstate->total_beds) == '1+' ? 'selected' : ''}}>1+ Beds</option>
                            <option value="2" {{old('total_beds',$realEstate->total_beds) == '2' ? 'selected' : ''}}>2 Beds</option>
                            <option value="2+" {{old('total_beds',$realEstate->total_beds) == '2+' ? 'selected' : ''}}>2+ Beds</option>
                            <option value="3" {{old('total_beds',$realEstate->total_beds) == '3' ? 'selected' : ''}}>3 Beds</option>
                            <option value="3+" {{old('total_beds',$realEstate->total_beds) == '3+' ? 'selected' : ''}}>3+ Beds</option>
                            <option value="4" {{old('total_beds',$realEstate->total_beds) == '4' ? 'selected' : ''}}>4 Beds</option>
                            <option value="4+" {{old('total_beds',$realEstate->total_beds) == '4+' ? 'selected' : ''}}>4+ Beds</option>
                            <option value="5" {{old('total_beds',$realEstate->total_beds) == '5' ? 'selected' : ''}}>5 Beds</option>
                            <option value="5+" {{old('total_beds',$realEstate->total_beds) == '5+' ? 'selected' : ''}}>5+ Beds</option>
                        </select>
                        @include('admin.components.error',['error' => 'total_beds'])
                    </div>
                </div>
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">Total Baths<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control @error('total_baths') is-invalid @enderror" id="total_baths" name="total_baths">
                            <option value="">Select Bathrooms</option>
                            <option value="Any Baths" {{old('total_baths',$realEstate->total_baths) == 'Any Baths' ? 'selected' : ''}}>Any Baths</option>
                            <option value="1" {{old('total_baths',$realEstate->total_baths) == '1' ? 'selected' : ''}}>1 Bath</option>
                            <option value="1+" {{old('total_baths',$realEstate->total_baths) == '1+' ? 'selected' : ''}}>1+ Baths</option>
                            <option value="2" {{old('total_baths',$realEstate->total_baths) == '2' ? 'selected' : ''}}>2 Baths</option>
                            <option value="2+" {{old('total_baths',$realEstate->total_baths) == '2+' ? 'selected' : ''}}>2+ Baths</option>
                            <option value="3" {{old('total_baths',$realEstate->total_baths) == '3' ? 'selected' : ''}}>3 Baths</option>
                            <option value="3+" {{old('total_baths',$realEstate->total_baths) == '3+' ? 'selected' : ''}}>3+ Baths</option>
                            <option value="4" {{old('total_baths',$realEstate->total_baths) == '4' ? 'selected' : ''}}>4 Baths</option>
                            <option value="4+" {{old('total_baths',$realEstate->total_baths) == '4+' ? 'selected' : ''}}>4+ Baths</option>
                            <option value="5" {{old('total_baths',$realEstate->total_baths) == '5' ? 'selected' : ''}}>5 Baths</option>
                            <option value="5+" {{old('total_baths',$realEstate->total_baths) == '5+' ? 'selected' : ''}}>5+ Baths</option>
                        </select>
                        @include('admin.components.error',['error' => 'total_baths'])
                    </div>
                </div>


                <div class="form-group row">
                    <label for="attachment" class="col-sm-2 col-form-label">Featured Image</label>
                    <div class="col-sm-10">

                        <textarea class="form-control attachement" id="attachment" name="attachment"  placeholder="Upload Featured Image" >{{old('attachment',view('components.partials.image',['url' => $realEstate->getAttachmentUrl(),'class' => '','errorUrl' => ''])->render())}}</textarea>
                        @include('admin.components.error',['error' => 'attachment'])
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="is_published" value="1" {{$realEstate->is_published == 1 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="is_published">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_published" id="save" value="0" {{$realEstate->is_published == 0 ? 'checked' : ''}} required>
                            <label class="form-check-label" for="save">Save</label>
                        </div>
                    </div>
                    @include('admin.components.error',['error' => 'is_published'])
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>

    </div>
@endsection
@section('js')
    @include('admin.pages.partials.post_tiny_mce')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script src="{{asset('js/slugify.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            putSlugInInputFieldForRealEstate('#title','#slug','#p_type',$('#p_type').val());
        }); //ready
    </script>
@endsection

@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection
