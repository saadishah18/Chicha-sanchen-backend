@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        @include('admin.pages.partials.back_arrow',['backRoute' => route('admin.questions.index'),'text' => 'Add New Question'])
        <form method="post" action="{{ route('admin.questions.store') }}"  enctype="multipart/form-data">
            @csrf
            @include('admin.components.partials.session_statuses')
            @include('admin.components.form.input',['fieldId' => 'questions','fieldTitle' => 'Question', 'placeholder' => 'Enter Question','required' => true, 'autofocus' => true,'autocomplete' => 'name'])

            <div id="answers_section">
                <div class="form-group row" id="answer_section">
                    <label class="col-sm-2 col-form-label">Answer<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="input-group" id="answers_input_section">
                            <input type="text" class="form-control" name="answers[]" value="{{old('answers')}}" placeholder="Enter Answer" required autofocus autocomplete="name">
                            <button id="remove_answer" type="button" class="btn btn-sm btn-secondary bg-theme">Remove</button>
                        </div>
                        @include('admin.components.error',['error' => 'answers'])
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="add_answer" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
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
                let clonedDiv = $('#answer_section').clone();
                clonedDiv.closest('input[name="answers[]"]').val('')
                clonedDiv.appendTo('#answers_section');
            });

            $(document).on('click','#remove_answer',function (){
                $(this).closest('#answer_section').remove()
            });
        });
    </script>
@endsection
