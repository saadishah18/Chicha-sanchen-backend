<a title="Edit Ad Ons" href="{{ route('admin.addons.edit', ['id' => $adOne->id]) }}" class="btn btn-info btn-circle">
    <i class="fas fa-pencil-alt"></i>
</a>

<button title="Add values" class="btn btn-primary add-values-btn" data-record-id="{{$adOne->id}}">
    <i class="fas fa-arrow-alt-circle-up"></i>Add Values
</button>


<script>
    $(document).on('click', '.add-values-btn', function() {
        $('.input-group').find('input').val('');
        $('#newinput').empty();
        var recordId = $(this).data('record-id');
        $('#add_value').data('record-id', recordId); // Store the record ID on the modal
        $('#add_value').modal('show'); // Show the modal
    });
    // function addValue(id){
    //     $('#add_value').addClass('add-on-'+id);
    //     $('#add_value').modal('show');
    // }
    // $('#add_value').on('show.bs.modal', function (e) {
    //     var recordId = $(this).data('record-id'); // Retrieve the stored record ID
    //
    //     // Clear previous dynamic content
    //     var dynamicInputContainer = $('#dynamic-input-container');
    //     dynamicInputContainer.empty();
    //
    //     // Add the initial input field
    //     dynamicInputContainer.append('<div class="form-group">' +
    //         '<div class="col-md-8"> ' +
    //         '<input type="text" class="input-field form-control value" name="value[]"> ' +
    //         '</div> ' +
    //         '<div class="col-md-2"> <button type="button" class="btn btn-sm add-more btn-success"><i class="fa fa-plus"></i></button> ' +
    //         '</div> ' +
    //         '</div>');
    // });
    // $(document).on('click', '.add-more', function () {
    //     // Clone the template
    //     let newFields = $('#dynamic-input-container .form-group:first').clone();
    //
    //     // Clear the input value in the cloned field
    //     newFields.find('input').val('');
    //
    //     // Append the cloned field to the container
    //     $('#dynamic-input-container').append(newFields);
    // });


    // $(document).on('click', '.add-more', function() {
    //   let newFileds = '<div class="form-group">' +
    //       '<div class="col-md-8"> ' +
    //       '<input type="text" class="input-field form-control value" name="value[]"> ' +
    //       '</div> ' +
    //       '<div class="col-md-2"> <button type="button" class="btn btn-sm add-more btn-success"><i class="fa fa-plus"></i></button> ' +
    //       '</div> ' +
    //       '</div>';
    //     $('#dynamic-input-container').append(newFileds);
    //
    // });



    // When the remove button is clicked


</script>
