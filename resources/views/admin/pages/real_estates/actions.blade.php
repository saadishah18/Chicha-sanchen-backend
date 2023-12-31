@can('edit_own_real_estate_listings', 'edit_any_real_estate_listings')
    <a title="Edit Real Estate Content" href="{{ route('admin.real_estates.edit', ['id' => $id]) }}"
        class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this property" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan

@can('delete_own_real_estate_listings', 'delete_any_real_estate_listings')
    <a href="#" title="Delete property" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
