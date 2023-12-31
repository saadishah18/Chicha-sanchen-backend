@can('edit_own_galleries', 'edit_any_galleries')
    <a title="Edit category" href="{{ route('admin.galleries.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_own_galleries', 'delete_any_galleries')
    <a href="#" title="Delete category" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
@can('is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this gallery" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan
