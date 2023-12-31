@can('edit_category')
    <a title="Edit category" href="{{ route('admin.categories.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_category')
    <a href="#" title="Delete category" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
