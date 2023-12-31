<div class="form-group row {{$mainDivClasses ?? ''}}">
    <label for="{{$fieldId}}" class="{{$labelCols ?? 'col-sm-2'}} col-form-label">{{$fieldTitle}}@if(isset($required) && $required)<span class="text-danger">*</span>@endif</label>
    <div class="{{$inputCols ?? 'col-sm-10'}}">
        <input type="{{$inputType ?? 'text'}}" class="form-control" id="{{$fieldId}}" name="{{$fieldName ?? $fieldId}}" value="{{old($fieldId,$value ?? '')}}" placeholder="{{$placeholder ?? $fieldTitle ?? ''}}"
               {{isset($required) && $required ? 'required' : ''}}
               {{isset($autofocus) && $autofocus ? 'autofocus' : ''}}
               {{isset($readonly) && $readonly ? 'readonly' : ''}}
               {{isset($disabled) && $disabled ? 'disabled' : ''}}
               autocomplete="{{$autocomplete ?? null}}"
        />
        @include('admin.components.error',['error' => $errorKey ?? $fieldId])
    </div>
</div>
