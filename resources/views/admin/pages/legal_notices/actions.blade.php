@can('edit_own_legal_notices', 'edit_any_legal_notices')
    <a title="Edit Notice Content" href="{{ route('admin.legal_notices.edit', ['id' => $id]) }}"
        class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can( 'is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this Notice" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan

@can('delete_own_legal_notices', 'delete_any_legal_notices')
    <a href="#" title="Delete notice" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
