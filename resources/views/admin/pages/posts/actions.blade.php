@can('breaking_news_button')
    <a title="{{ $item->is_breaking_news ? 'Remove from' : 'Make' }} breaking news" data-id="{{ $id }}"
        href="#" class="action btn {{ $item->is_breaking_news ? 'btn-danger' : 'btn-success' }} btn-circle"
        data-column="is_breaking_news">
        <i class="fas {{ $item->is_breaking_news ? 'fa-comment-dots' : 'fa-flag' }}"></i>
    </a>
@endcan
@can('messive_news_button')
    <a title="{{ $item->mark_as_massive ? 'Remove from' : 'Make' }} massive breaking news" data-id="{{ $id }}"
        href="#" class="action btn {{ $item->mark_as_massive ? 'btn-danger' : 'btn-success' }} btn-circle"
        data-column="mark_as_massive">
        <i class="fas {{ $item->mark_as_massive ? 'fa-rocket' : 'fa-rocket' }}"></i>
    </a>
@endcan
@can('publish_news_button')
    <a title="{{ $item->is_published ? 'Unpublish' : 'Publish' }} this post" data-id="{{ $id }}" href="#"
        class="action btn {{ $item->is_published ? 'btn-success ' : 'btn-warning' }} btn-circle"
        data-column="is_published">
        <i class="fas {{ $item->is_published ? 'fa-check-square' : 'fa-square' }}"></i>
    </a>
@endcan
@can('edit_own_posts', 'edit_any_posts')
    <a title="Edit post" href="{{ route('admin.posts.edit', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
@endcan
@can('freeze_comments_button')
    <a title="{{ $item->frees_comment ? 'Unfrees' : 'Un Freeze' }} Comments" data-id="{{ $id }}" href="#"
        class="action btn btn-info btn-circle" style="color: #fff; background-color: purple; border-color: purple;"
        data-column="frees_comment">
        <i class="fas {{ $item->frees_comment ? 'fa-comment-dots' : 'fa-comment-slash' }}"></i>
    </a>
@endcan
@can('mark_imp_button')
    <a title="{{ $item->mark_as_imp ? 'Remove from major' : 'Make major' }} breaking news" data-id="{{ $id }}"
        href="#" class="action btn {{ $item->mark_as_imp ? 'btn-danger' : 'btn-success' }} btn-circle"
        data-column="mark_as_imp">
        <i class="fa {{ $item->mark_as_imp ? 'fa-heartbeat' : 'fa-heart' }}"></i>
    </a>
@endcan
