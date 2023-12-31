@can('is_published_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this video" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle" data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan
@can('edit_own_videos', 'edit_any_videos')
    <a title="Edit video" href="{{ route('admin.videos.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can( 'delete_own_videos', 'delete_any_videos')
    <a href="#" title="Delete video" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
@can('make_live_stream')
    <a title="{{ $item->mark_as_live ? 'Remove from' : 'Make' }} live stream" data-id="{{ $id }}" href="#"
        class="action btn btn-success btn-circle" data-column="mark_as_live">
        <i class="fa {{ $item->mark_as_live ? 'fa-heartbeat' : 'fa-heart' }}"></i>
    </a>
@endcan
