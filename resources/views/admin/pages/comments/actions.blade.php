@can('approve_comment_button')
    <a title="{{ $item->is_approve ? 'Disapprove' : 'Approve' }} this comment" data-id="{{ $id }}" href="#"
        class="btn {{ $item->is_approve ? 'btn-success ' : 'btn-warning' }} btn-circle toggle_approve">
        <i class="fas {{ $item->is_approve ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
    </a>
@endcan
@can('edit_own_comments', 'edit_any_comments')
    <a title="Edit comment" href="{{ route('admin.comments.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('delete_own_comments', 'delete_any_comments')
    <a href="#" title="Delete comment" data-id="{{ $id }}"
        class="btn btn-danger btn-circle delete_item_from_list">
        <i class="fas fa-trash"></i>
    </a>
@endcan
@can( 'vic_pick_button')
    <a title="{{ $item->is_featured ? 'Remove from Vic Pick' : 'Vic Pick' }}" data-id="{{ $id }}" href="#"
        class="btn {{ $item->is_featured ? 'btn-success ' : 'btn-warning' }}  btn-circle toggle_vic_pick">
        <i class="fas {{ $item->is_featured ? 'fa-heart' : 'fa-heartbeat' }}"></i>
    </a>
@endcan
@can('abusive_button')
    <a title="{{ $item->abusive_status ? 'Unmark from' : 'Mark as' }}  abusive comment" data-id="{{ $id }}"
        href="#" class="btn {{ $item->abusive_status ? 'btn-danger ' : 'btn-warning' }} btn-circle toggle_abusive">
        <i class="fas {{ $item->abusive_status ? 'fa-comment-slash' : 'fa-square' }}"></i>
    </a>
@endcan
