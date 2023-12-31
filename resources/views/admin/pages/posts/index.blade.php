@extends('admin.layouts.admin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Manage News Post</h1>
        @if (session('status'))
            @include('admin.pages.partials.alert',['type' => 'success', 'message' => session('status')])
        @endif
        @if (session('error'))
            @include('admin.pages.partials.alert',['type' => 'danger', 'message' => session('error')])
        @endif
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="tab1" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All Post</a>
                <a class="nav-item nav-link" id="tab2" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Published Post</a>
                <a class="nav-item nav-link" id="tab3" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Saved Post</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="tab1">
                @include('admin.pages.posts.datatable',['id' => 'datatable1'])
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="tab2">
                @include('admin.pages.posts.datatable',['id' => 'datatable2'])
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="tab3">
                @include('admin.pages.posts.datatable',['id' => 'datatable3'])
            </div>
        </div>

    </div>
@endsection
@section('js')
    @include('admin.layouts.partials.sweetalert')
    <script src="{{asset('admin/js/select2.min.js')}}"></script>
    <script type="text/javascript">

        function toggleActivity(e,column = 'is_breaking_news'){
            let itemId = $(e.currentTarget).data('id');
            url = '/admin/posts/'+itemId+'/toggle';
            Swal.fire({
                // title: 'Are you sure?',
                text: 'Are you sure to perform this action!',
                showCancelButton: true,
                confirmButtonText: 'Yes, do it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                cancelButtonColor:'grey',
                confirmButtonColor:'red',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        method: 'POST',
                        data: { "_token": "{{ csrf_token() }}", 'content_id': itemId,column },
                        success: function (data) {
                            if (data.status){
                                $('#datatable1').DataTable().ajax.reload( null, false );
                                $('#datatable2').DataTable().ajax.reload( null, false );
                                $('#datatable3').DataTable().ajax.reload( null, false );
                            }
                        },
                        error:function (data){
                            Swal.fire({
                                icon: 'error',
                                title: '',
                                text: data?.responseJSON?.message,
                            })
                        }
                    });
                }

            })
        }

        var datatable1,datatable2,datatable3;
        function initializeDatatable(tableId,newsTypeId,section){
             url = `/admin/posts/datatable/${newsTypeId}/${section}`
            $(`#${tableId}`).DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    { data: 'content_id' ,width: '5%'},
                    { data: 'title' ,width: '5%'},
                    { data: 'journalist',name:'author' ,width: '5%'},
                    { data: 'category',name:'category', width: '10%'},
                    { data: 'tags', width: '20%' },
                    { data: 'thumbnail',width: '5%'},
                    { data: 'comments_count',width: '5%'},
                    { name: 'publish_date',data:'schedule_date',width: '10%' },
                    { data: 'actions', width : '25%' },
                ],
                columnDefs: [
                    { targets: 'no-sort', orderable: false },
                    // {'max-width': '10%', 'targets': [3]}
                ],
                order: [[7, 'desc']],

        });
        }
        function tablesToReset(){
            $('#datatable1').DataTable().clear().draw(false);
            $('#datatable2').DataTable().clear().draw(false);
            $('#datatable3').DataTable().clear().draw(false);
        }
        function confirmBeforeDelete(tablesToResetFunction){
            $(document).on('click','.delete_item_from_list',function (e){
                let postId = $(e.currentTarget).data('id');
                url = '/admin/posts/'+postId;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You cannot reverse this action',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    cancelButtonColor:'grey',
                    confirmButtonColor:'red',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url,
                            method: 'POST',
                            data: { "_method":'DELETE' ,"_token": "{{ csrf_token() }}", 'id': postId },
                            success: function (data) {
                                if (data.status){
                                    //reset given/all datatables
                                    tablesToResetFunction();
                                }
                            },
                            error:function (data){
                                Swal.fire({
                                    icon: 'error',
                                    title: '',
                                    text: data?.responseJSON?.message,
                                })
                            }
                        });
                    }

                })

            });
        }
        $(document).ready(function(){

            initializeDatatable('datatable1',"{{request()->newsTypeId}}",'all')
            initializeDatatable('datatable2',"{{request()->newsTypeId}}",'published')
            initializeDatatable('datatable3',"{{request()->newsTypeId}}",'saved')

            confirmBeforeDelete(tablesToReset);

            $('.select2').select2();

            $(document).on('click','.action',function (e){
                e.preventDefault();
                toggleActivity(e,$(this).data('column'));
            });

            $(document).on('click','.action_notify',async function (e){
                e.preventDefault();
                let launchIcon =  $(e.currentTarget).find('i');
                let anchorElem  = $(e.currentTarget);
                let spinner =  $(e.currentTarget).find('span');

                let activeLaunchIcon = () => anchorElem.removeClass('btn-secondary').addClass('btn-success');
                let inactiveLaunchIcon = () =>  anchorElem.removeClass('btn-success').addClass('btn-secondary');
                await inactiveLaunchIcon();

                let showLaunchIcon = () => launchIcon.removeClass('d-none');
                let hideLaunchIcon = () => launchIcon.addClass('d-none');

                let showSpinner = () => spinner.removeClass('d-none')
                let hideSpinner = () => spinner.addClass('d-none')




                let newsId = await $(e.target).data('id')
                let newsTitle = await $(e.target).data('title');
                let inputData = await (`<div class="form-group col">
                                <div class="form-group row">
                                    <label for="send_news_title" class="col-form-label"></label>
                                    <div class="col-sm-12">
                                        <textarea rows="5" class="form-control" name="title" id="send_news_title"  placeholder="News Title" >`+(newsTitle ?? '')+`</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-6 col-form-label">Make it breaking news</label>
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="is_breaking_news" id="is_breaking_news" value="1">
                                            <label class="form-check-label" for="is_breaking_news"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>`);


                setTimeout(()=> {
                    Swal.fire({
                        titleText: 'News Title',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true,
                        html: inputData,
                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                resolve({content_id:newsId,
                                    title:$('#send_news_title').val(),
                                    is_breaking_news:$('#is_breaking_news').is(':checked')
                                })
                            })
                        },
                    }).then(async function (result) {
                        if (result.isConfirmed) {
                            //set loading
                            await hideLaunchIcon();
                            await showSpinner();

                            const {content_id, title,is_breaking_news} = result.value;
                            url = `/admin/posts/${content_id}/send-notification`;
                            $.ajax({
                                url,
                                method: 'POST',
                                data: { "_token": "{{ csrf_token() }}", id:content_id,title,is_breaking_news  },
                                success: async function (data) {
                                    if (data.status){
                                        Swal.fire({
                                            icon: 'success',
                                            title: '',
                                            text: 'Notification has been sent',
                                        })
                                        await activeLaunchIcon();
                                        await showLaunchIcon();
                                        await hideSpinner();

                                    }
                                },
                                error: async function (data){
                                    Swal.fire({
                                        icon: 'error',
                                        title: '',
                                        text: data?.responseJSON?.message,
                                    })
                                    await activeLaunchIcon();
                                    await showLaunchIcon();
                                    await hideSpinner();
                                }
                            });
                        }
                        if (result.dismiss) {
                            activeLaunchIcon();
                        }

                    })
                },200)
            });
            $(document).on('change','.select2',function (e){
                var i =$(this).attr('data-column');
                var v =$(this).val();
                let tableId = $(this).closest('table').attr('id');
                $('#'+tableId).DataTable().columns(i).search(v).draw(false);
            });

        });
    </script>
@endsection
@section('css')
    <link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet" />
@endsection

