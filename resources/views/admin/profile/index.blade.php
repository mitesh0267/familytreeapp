@extends('admin.layouts.master')

@section('title','Profile')

@section('content')

<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2 class="">Profile</h2>
      </div>
    </div>
  </div>
</div>


<div class="content-body"><!-- Validation -->
  <section class="bs-validation">
    <div class="row">
      <div class="col-md-6 col-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Update Profile</h4>
          </div>
          <div class="card-body">
            <form id="myProfileForm" >
              @csrf
              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Name</label>
                  <input type="text" name="name" placeholder="Enter name" class="form-control" value="{{ @Auth::user()->name }}" >
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Email</label>
                  <input type="email" name="email" placeholder="Enter email" class="form-control" value="{{ @Auth::user()->email }}" >
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Mobile No</label>
                  <input type="text" name="mobile_no" placeholder="Enter mobile no" class="form-control" value="{{ @Auth::user()->mobile_no }}" >
                </div>
              </div>

              <div class="form-group row text-right">
                <div class="col col-sm-10 col-lg-9">
                  <button type="submit" class="btn btn-space btn-primary">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Change Password</h4>
          </div>
          <div class="card-body">
            <form id="myPasswordForm" >
              @csrf
              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Current Password</label>
                  <input type="password" name="current_password" placeholder="Enter current password" class="form-control">
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>New Password</label>
                  <input type="password" name="new_password" id="new_password" placeholder="Enter new password" class="form-control">
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" placeholder="Enter confirm password" class="form-control">
                </div>
              </div>

              <div class="form-group row text-right">
                <div class="col col-sm-10 col-lg-9">
                  <button type="submit" class="btn btn-space btn-primary">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('script')
<script>
  $(document).ready(function() {
    $('body').on("submit", "#myProfileForm", function (e) {
      e.preventDefault();
      var validator = validate_profile_form();
      if (validator.form() != false) {
        $.ajax({
          url: "{{route('profile.store')}}",
          type: "POST",
          data: new FormData($("#myProfileForm")[0]),
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
            if (data.status) {
              toast_success(data.message)
              setTimeout(function(){
                  window.location.reload();
              },1500)
            } else {
              toast_error(data.message);
            }
          },
          error: function () {
            toast_error("Something went to wrong !");
          },
        });
      }
    });

    function validate_profile_form(){
      var validator = $("#myProfileForm").validate({
          errorClass: "is-invalid",
          validClass: "is-valid",
          rules: {
              name:{
                required: true,
                maxlength: 185,
              },
              email:{
                required:true,
                maxlength: 185,
              },
              mobile_no:{
                required:true,
                digits:true,
                minlength:10,
                maxlength:10,
              }
          },
          messages: {
              
              name:{
                  required: "Please enter name.",
              },
              email:{
                  required:"Please enter email.",
              },
              phone_number:{
                  required:"Please enter phone number.",
                  digits:"Please enter valid phone number.",
                  minlength:"Please enter valid phone number.",
                  maxlength:"Please enter valid phone number.",
              }
          },
      });

      return validator;
    }


    $('body').on("submit", "#myPasswordForm", function (e) {
      e.preventDefault();
      var validator = validate_password_form();
      if (validator.form() != false) {
        $.ajax({
          url: "{{route('profile.change-password')}}",
          type: "POST",
          data: new FormData($("#myPasswordForm")[0]),
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
            if (data.status) {
              toast_success(data.message)
              setTimeout(function(){
                  window.location.reload();
              },1500)
            } else {
              toast_error(data.message);
            }
          },
          error: function () {
            toast_error("Something went to wrong !");
          },
        });
      }
    });

    function validate_password_form(){
      var validator = $("#myPasswordForm").validate({
          errorClass: "is-invalid",
          validClass: "is-valid",
          rules: {
              current_password:{
                required:true,
                minlength:8,
              },
              new_password:{
                required:true,
                minlength:8,
              },
              confirm_password:{
                required:true,
                minlength:8,
                equalTo : "#new_password"
              }
          },
          messages: {
              current_password:{
                required:'Please enter current password.',
                minlength:'Please enter current password greater than 8 digits',
              },
              new_password:{
                required:'Please enter new password.',
                minlength:'Please enter new password greater than 8 digits',
              },
              confirm_password:{
                required:'Please enter confirm password.',
                minlength:'Please enter confirm password greater than 8 digits',
                equalTo : "Enter confirm password not same as password !"
              }
          },
      });

      return validator;
    }    
  });
</script>
@endpush