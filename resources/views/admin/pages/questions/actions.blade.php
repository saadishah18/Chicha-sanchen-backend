@can('edit_pueblo_content')
    <a title="Edit question" href="{{ route('admin.questions.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan

@can('delete_pueblo_content')
    <a href="#" title="Delete question" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
