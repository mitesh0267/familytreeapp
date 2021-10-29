@extends('admin.auth.app')

@section('title','Reset Password')

@section('content')
<h4 class="card-title mb-1">Reset Password !</h4>

<form id="myForm" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="mb-1">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Enter Email" name="email" disabled="" value="{{ $email }}" /> 
    </div>

    <div class="mb-1">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="login-password">New Password</label>
        </div>
        <div class="input-group input-group-merge form-password-toggle">
            <input type="password" class="form-control form-control-merge" id="password" name="new_password" tabindex="1" placeholder="********" aria-describedby="login-password" /> <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span> 
        </div>
    </div>

    <div class="mb-1">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="login-password">Confirm Password</label>
        </div>
        <div class="input-group input-group-merge form-password-toggle">
            <input type="password" class="form-control form-control-merge" id="password" name="confirm_password" tabindex="2" placeholder="********" aria-describedby="login-password" /> <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span> 
        </div>
    </div>
    
    <div class="mb-1">
        <div class="d-flex justify-content-between">
            <a href="{{ route('login') }}"> <small>Login ?</small> </a>
        </div>
    </div>
    <button class="btn btn-primary w-100 mt-2" type="submit" tabindex="3">Reset Password</button>
</form>
@endsection

@push('script')
<script>
  $(document).ready(function() {

    function validate_change_password_form() {
        var validator = $("#myForm").validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            rules: {
                new_password:{
                    required: true,
                    maxlength: 52,
                    minlength:8,
                },
                confirm_password:{
                    required: true,
                    equalTo: '#myForm input[name="new_password"]',
                    maxlength: 52,
                    minlength:8,
                },
            },
            messages: {
                new_password:{
                    required: "Please enter your new password.",
                    maxlength: "Password is too long.",
                },
                confirm_password:{
                    required: "Please confirm your password.",
                    equalTo: "Please enter same password.",
                    maxlength: "Password is too long.",
                },
            },
        });
        return validator;
    }

    $(document).on('submit', '#myForm', function(event) {
        event.preventDefault();
      
        var validator = validate_change_password_form();
        if (validator.form() != false) {
            $.ajax({
                url: '{{ route('forgot-password.reset-password') }}',
                type: 'POST',
                data: new FormData($("#myForm")[0]),
                processData: false,
                contentType: false
            })
            .done(function(result) {
                if(result.status){
                    toast_success(result.message);
                    setTimeout(function(){
                        window.location.href = "{{ route('login') }}";
                    },1500);
                }else{
                    toast_error(result.message);
                }
            })
            .fail(function() {
                toast_error('something went to wrong.');
            });
        }
    });
    
  });
</script>
@endpush
