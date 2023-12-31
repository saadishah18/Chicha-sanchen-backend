@can('edit_roles')
    <a title="Edit Role" href="{{ route('admin.roles.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_roles')
    <a href="#" title="Delete role" data-id="{{ $id }}" class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
