@can('hide_advertisements')
    <a title="{{ $item->is_display ? 'Hide' : 'Show' }} this ad" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_display ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_display">
        <i class="fas {{ $item->is_display ? 'fa-check' : 'fa-times' }}"></i>
    </a>
@endcan
@can('edit_own_advertisements', 'edit_any_advertisements')
    <a title="Edit video" href="{{ route('admin.ads.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_own_advertisements', 'delete_any_advertisements')
    <a href="#" title="Delete video" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
