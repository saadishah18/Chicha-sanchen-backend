<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.partials.head')

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
@include('admin.layouts.partials.admin_sidebar')
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">


            <!-- Topbar -->
        @include('admin.layouts.partials.header')
        <!-- End of Topbar -->

            <!-- Begin Page Content -->
        @yield('content')
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->

        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.partials.js')
@yield('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "onclick": null,
        "extendedTimeOut": "1000",
        "tapToDismiss": false
    };
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // toastr.success('adfs', 'New Order');

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('febd34ec5f890afb6f21', {
        cluster: 'ap2',
        authEndpoint: '/pusher/auth', // The authentication endpoint you defined
    });
    let userID = '{{auth()->id()}}'
    var channel = pusher.subscribe('order-updates-'+userID);
    channel.bind('order-completed', function(data) {
        // alert(JSON.stringify(data));
        toastr.success(data, 'New Order');
        {{--toastr.success("{{ Session::get('message') }}");--}}
    });
</script>
</body>

</html>
