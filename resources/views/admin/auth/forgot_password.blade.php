@extends('admin.auth.app')

@section('title','Forgot Password')

@section('content')
<h4 class="card-title mb-1">Forgot Password !</h4>

<form id="myForm" method="post">
    @csrf
    <div class="mb-1">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Enter Email" name="email" tabindex="1" autofocus /> </div>
    <div class="mb-1">
        <div class="d-flex justify-content-between">
            <a href="{{ route('login') }}"> <small>Login ?</small> </a>
        </div>
    </div>
    <button class="btn btn-primary w-100" type="submit">Send Password Reset Link</button>
</form>
@endsection

@push('script')
<script>
  $(document).ready(function() {
    $(document).on('submit', '#myForm', function(event) {
        event.preventDefault();
      
        $.ajax({
            url: '{{ route('forgot-password.email') }}',
            type: 'POST',
            data: new FormData($("#myForm")[0]),
            processData: false,
            contentType: false
        })
        .done(function(result) {
            if(result.status){
                toast_success(result.message);
                setTimeout(function(){
                    window.location.href = "{{ route('forgot-password.index') }}";
                },1500);
            }else{
                toast_error(result.message);
            }
        })
        .fail(function() {
            toast_error('something went to wrong.');
        });
    }); 
  });
</script>
@endpush