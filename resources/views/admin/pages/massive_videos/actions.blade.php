@can('delete_massive_videos_at_homepage')
    <a href="#" title="Delete video" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
@can('active/unactive_button')
    <a title="{{ $item->status ? 'Active' : 'Inactivate' }} this video" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->status ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="status">
        <i class="fas {{ $item->status ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan
