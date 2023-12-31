@can('edit_plaza_extra_east_content')
    <a title="Edit poster" href="{{ route('admin.manage_plaza.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_plaza_extra_east_content')
    <a href="#" title="Delete poster" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
