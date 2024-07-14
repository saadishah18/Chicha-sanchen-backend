
<!-- Bootstrap core JavaScript-->
<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('admin/js/sb-admin-2.js')}}"></script>

<!-- Custom scripts for all pages-->
<script>
    {{--// @vite('public/admin/js/sb-admin-2.js')--}}
</script>

<!-- Page level plugins -->
<script src="{{asset('admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr/latest/toastr.min.js" integrity="sha512-Tcjel dejected1s7kgjbzfnpqmRWn5qVJK2-vgONkWqPqYVyw9xuNMeVOU+j6NpKYrzvLM3ιKnqQtySnCeOGLmYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
<!-- Page level custom scripts -->
{{--<script src="{{asset('admin/js/demo/datatables-demo.js')}}"></script>--}}
