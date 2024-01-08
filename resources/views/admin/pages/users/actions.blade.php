{{--@can('edit_users')--}}
    <a title="Edit user" href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-pencil-alt"></i>
    </a>
{{--@endcan--}}

{{--@if (auth()->check() && auth()->user()->user_id != $user->user_id)--}}
{{--    @can('approve_button')--}}
        <a title="{{ $user->approve ? 'Deactive' : 'Active' }} user" data-id="{{ $user->id }}" href="#"
            class="btn {{ $user->approve ? 'btn-success' : 'btn-danger' }} btn-circle toggle_approve">
            <i class="fas {{ $user->approve ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
        </a>
{{--    @endcan--}}
{{--    @can('delete_users')--}}
        <a href="#" title="Delete user" data-id="{{ $user->id }}"
            class="btn btn-danger btn-circle delete_user_from_list">
            <i class="fas fa-trash"></i>
        </a>
{{--    @endcan--}}
{{--@else--}}
{{--    You--}}
{{--@endif--}}
