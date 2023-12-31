@can('edit_own_obituaries', 'edit_any_obituaries')
    <a title="Edit Obituary Content" href="{{ route('admin.obituaries.edit', ['id' => $id]) }}"
        class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this Obituary" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan

@can('delete_own_obituaries', 'delete_any_obituaries')
    <a href="#" title="Delete obituary" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
