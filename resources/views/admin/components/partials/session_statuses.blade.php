@if (session('status'))
@include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status') ?? session('message') ?? ''])
@endif
@if (session('error'))
@include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
@endif
