@can('edit_own_pages', 'edit_any_pages')
    <a title="Edit Notice Content" href="{{ route('admin.pages.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this Notice" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan

@can('delete_own_pages', 'delete_any_pages')
    <a href="#" title="Delete page" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
