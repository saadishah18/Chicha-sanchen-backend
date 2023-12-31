@can('edit_tags')
    <a title="Edit tag" href="{{ route('admin.tags.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_tags')
    <a href="#" title="Delete tag" data-id="{{ $id }}" class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
