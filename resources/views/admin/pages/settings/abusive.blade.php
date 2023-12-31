@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Abusive Words</h1>
        <form class="mt-3" method="post" action="{{ route('admin.settings.update') }}"  enctype="multipart/form-data">
            @csrf
            <div class="col-lg">
                @if (session('status'))
                    @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
                @endif
                @if (session('error'))
                    @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
                @endif
                    <div class="form-group row">
                        <label for="word_comment" class="col-sm-3 col-form-label">Abusive Words (Comment Pending)</label>
                        <div class="col-sm-9">
                            @php
                                $abusiveWord = explode(',',$settings['word_comment']);
                            @endphp
                            <select name="word_comment[]" id="word_comment" class="form-control select2 @error('word_comment') is-invalid @enderror" multiple="multiple" data-placeholder="Abusive Words (Comment Pending)">
                                <option disabled>Select Tags</option>
                                @foreach($abusiveWord as $word)
                                    <option value="{{$word}}" {{(in_array($word,old('word_comment') ?? []) || in_array($word,array_merge(old('word_comment') ?? [],$abusiveWord))) ? 'selected' : ''}}>{{$word}}</option>
                                @endforeach
                            </select>
                            @include('admin.components.error',['error' => 'word_comment'])
                        </div>
                    </div>

                <div class="mb-5 mt-5">
                    <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
                </div>
            </div>

        </form>
    </div>
@endsection
@section('js')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('.select2').select2();
            $("#word_comment").select2({
                tags:true,
                tokenSeparators: [',', ' '],
            });
        }); //ready
    </script>
@endsection

@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection
