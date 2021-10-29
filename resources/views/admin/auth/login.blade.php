@extends('admin.auth.app')

@section('title','Login')

@section('content')
<h4 class="card-title mb-1">Welcome to FamilyTree! 👋</h4>

  <form id="myForm" class="mt-2">
    @csrf
    <div class="mb-1">
      <label for="login-email" class="form-label">Email</label>
      <input
        type="email"
        class="form-control"
        id="login-email"
        name="email"
        tabindex="1"
        autofocus
        placeholder="Enter Email"
      />
    </div>

    <div class="mb-1">
      <div class="d-flex justify-content-between">
        <label class="form-label" for="login-password">Password</label>
        <a href="{{ route('forgot-password.index') }}">
          <small>Forgot Password?</small>
        </a>
      </div>
      <div class="input-group input-group-merge form-password-toggle">
        <input
          type="password"
          class="form-control form-control-merge"
          id="login-password"
          name="password"
          tabindex="2"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
          aria-describedby="login-password"
        />
        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
      </div>
    </div>
    <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
  </form>

  <p class="text-center mt-2">
    <span>New on our platform?</span>
    <a href="{{ route('register') }}">
      <span>Create an account</span>
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
          url: "{{route('login.check-login')}}",
          type: "POST",
          data: new FormData($("#myForm")[0]),
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
              if (data.status) {
                  toast_success(data.message)
                  setTimeout(function(){
                      window.location.href = '{{route('home')}}';
                  },500)
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
              
              email:{
                required:true,
              },
              password:{
                required:true,
                minlength:8,
              }
          },
          messages: {
              email:{
                  required:"Please enter email.",
              },
              password:{
                required:'Please enter password.',
                minlength:'Please enter password greater than 8 digits',
              }
          },
      });

      return validator;
    }  
  });
</script>
@endpush