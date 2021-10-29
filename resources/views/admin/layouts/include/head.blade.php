<link rel="apple-touch-icon" href="{{ asset('assets') }}/app-assets/images/ico/apple-icon-120.html">
<link rel="shortcut icon" type="image/x-icon" href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/ico/favicon.ico">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/vendors/css/vendors.min.css">
<!-- END: Vendor CSS-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/vendors.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/components.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/themes/dark-layout.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/themes/bordered-layout.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/themes/semi-dark-layout.min.css">

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/assets/css/style.css">
<!-- END: Custom CSS-->

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css">

<style>
  	.is-invalid{
    	color: red !important;
  	}

  	.required{
        color: red !important;
    }

  	.header-navbar .navbar-container ul.navbar-nav li.dropdown-user .dropdown-menu {
	    width: 14rem;
	    margin-top: 10px;
	}
</style>
    
@stack('css')