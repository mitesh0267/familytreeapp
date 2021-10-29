@extends('admin.auth.app')

@section('title','Sign up')

@section('content')
<h4 class="card-title mb-1">Create New Account</h4>

<form id="myForm" class="mt-2">
  @csrf
  <div class="mb-1">
    <label class="form-label">Name</label>
    <input
      type="text"
      class="form-control"
      name="name"
      placeholder="Enter Name"
    />
  </div>
  <div class="mb-1">
    <label class="form-label">Email</label>
    <input
      type="email"
      class="form-control"
      name="email"
      placeholder="Enter Email"
    />
  </div>

  <div class="mb-1">
    <label class="form-label">Mobile No</label>
    <input
      type="text"
      class="form-control"
      name="mobile_no"
      placeholder="Enter Phone Number"
    />
  </div>

  <div class="mb-1">
    <label class="form-label">Password</label>
    <div class="input-group input-group-merge form-password-toggle">
      <input
        type="password"
        id="password"
        class="form-control form-control-merge"
        name="password"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
      />
      <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
    </div>
  </div>

  <div class="mb-1">
    <label class="form-label">Confirm Password</label>
    <div class="input-group input-group-merge form-password-toggle">
      <input
        type="password"
        class="form-control form-control-merge"
        name="confirm_password"
        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
      />
      <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
    </div>
  </div>

  <div class="mb-1">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name = "is_read_terms_and_conditions" tabindex="4" value="1" />
      <label class="form-check-label" for="register-privacy-policy">
        I agree to <a href="#">privacy policy & terms</a>
      </label>
    </div>
  </div>

  <div class="mb-1 text-center">
    <div class="form-check">
      <input type="submit" value="Sign Up" class="btn btn-primary">
    </div>
  </div>
</form>

<p class="text-center mt-2">
  <span>Already have an account?</span>
  <a href="{{ route('login') }}">
    <span>Sign in instead</span>
  </a>
</p>  
@endsection

@push('script')
<script>
  $(document).ready(function() {
    $('body').on("submit", "#myForm", function (e) {
      e.preventDefault();
      var validator = validate_form();
      if (validator.form() != false) {
        $.ajax({
          url: "{{route('register.store')}}",
          type: "POST",
          data: new FormData($("#myForm")[0]),
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
              if (data.status) {
                  toast_success(data.message)
                  setTimeout(function(){
                      window.location.href = '{{route('login')}}';
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
    function validate_form(){
      var validator = $("#myForm").validate({
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
              },
              password:{
                required:true,
                minlength:8,
              },
              confirm_password:{
                required:true,
                minlength:8,
                equalTo : "#password"
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
              },

              password:{
                required:'Please enter password.',
                minlength:'Please enter password greater than 8 digits',
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