<!-- BEGIN: Vendor JS-->
<script src="{{ asset('assets') }}/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('assets') }}/app-assets/js/core/app-menu.min.js"></script>
<script src="{{ asset('assets') }}/app-assets/js/core/app.min.js"></script>
<script src="{{ asset('assets') }}/app-assets/js/scripts/customizer.min.js"></script>
<!-- END: Theme JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>    

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<script src="{{asset('assets/app-assets/js/common/function.js')}}"></script>

<script>
  $(window).on('load',  function(){
    if (feather) {
      feather.replace({ width: 14, height: 14 });
    }
  })
</script>

@stack('script')