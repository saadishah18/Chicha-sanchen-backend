@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        {{--        @if ($errors->any())--}}
        {{--            <div class="alert alert-danger">--}}
        {{--                <ul>--}}
        {{--                    @foreach ($errors->all() as $error)--}}
        {{--                        <li>{{ $error }}</li>--}}
        {{--                    @endforeach--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--        @endif--}}
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.tags.index'),'text' => 'Edit Tag'])
        <form method="post" action="{{ route('admin.tags.update',['id' => $tag->tag_id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="col-lg-9">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('status')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('error')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{old('name', $tag->name)}}" placeholder="Enter your name" required autofocus>
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug', $tag->slug)}}" placeholder="Enter your slug" required autofocus>
                    @error('slug')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"  placeholder="Enter your description" >{{old('description', $tag->description)}}</textarea>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>


            </div>
        </form>

    </div>
@endsection
@section('js')
    <script src="{{asset('js/slugify.js')}}"></script>
    <script>
        $(document).ready(function (){
            putSlugInInputField('#name');
        });
    </script>
@endsection
