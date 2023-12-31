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
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.tags.index'),'text' => 'Create Tag'])
        <form method="post" action="{{ route('admin.tags.store') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg-9">

                @include('admin.components.partials.session_statuses')
                @include('admin.components.form.input', [ 'fieldId' => 'name', 'fieldTitle' => 'Name','placeholder' => 'Enter tag name', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9','required' => true, 'autocomplete' => 'name'])
                @include('admin.components.form.input', [ 'fieldId' => 'slug', 'fieldTitle' => 'Slug','placeholder' => 'Slug', 'labelCols' => 'col-sm-3', 'inputCols' => 'col-sm-9','required' => true, 'autocomplete' => 'name'])

                <div class="form-group  row">
                    <label for="description" class="form-label col-sm-3">Description</label>
                   <div class="col-sm-9">
                       <textarea class="form-control" id="description" name="description"  placeholder="Description" >{{old('description')}}</textarea>
                       @include('admin.components.error',['error'=> 'description'])
                   </div>
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
