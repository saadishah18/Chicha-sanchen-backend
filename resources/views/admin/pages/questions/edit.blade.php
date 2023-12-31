@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.questions.index'),'text' => 'Edit Question'])
        {{--just to copy when new answer input field is required--}}
        <div class="d-none form-group row answer_item">
            <label class="col-sm-3 col-form-label">Answer<span class="text-danger">*</span></label>
            <div class="col-sm-9" id="answers_input_section">
                <div class="input-group">
                    <input type="text" class="form-control" name="answers[]" value="{{old('answers')}}" placeholder="Enter Answer" required  autocomplete="name">
                    <button id="remove_answer" type="button" class="btn btn-sm btn-secondary bg-theme">Remove</button>
                </div>
                @include('admin.components.error',['error' => 'answers'])
            </div>
        </div>
        {{----}}
        <form method="post" action="{{ route('admin.questions.update',['id' => $question->id]) }}"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label for="questions" class="col-sm-3 form-label">Question<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="questions" name="questions" value="{{old('questions', $question->questions)}}" placeholder="Enter question" required  autocomplete="name">
                    @include('admin.components.error',['error' => 'questions'])
                </div>
            </div>
            <div id="answers_section">
                @foreach($question->answers as $answer)
                    <div class="form-group row answer_item">
                        <label class="col-sm-3 col-form-label">Answer<span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="answers[]" value="{{old('answers',$answer)}}" placeholder="Enter Answer" required  autocomplete="name">
                                <button id="remove_answer" type="button" class="btn btn-sm btn-secondary bg-theme">Remove</button>
                            </div>
                            @include('admin.components.error',['error' => 'answers'])
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group row">
                <label for="add_answer" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <button id="add_answer" type="button" class="btn btn-sm btn-info bg-theme">Add New Answer</button>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary bg-theme">Save changes</button>
            </div>
        </form>

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function (){
            $(document).on('click','#add_answer',function (){
                let clonedDiv = $($('.answer_item')[0]).clone();
                clonedDiv.removeClass('d-none');
                clonedDiv.appendTo('#answers_section');
            });

            $(document).on('click','#remove_answer',function (){
                $(this).closest('.answer_item').remove()
            });
        });
    </script>
@endsection
