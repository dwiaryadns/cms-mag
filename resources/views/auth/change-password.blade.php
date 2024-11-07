@extends('layouts.master')

@section('content')

<section class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Change Password</h2>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.password.change') }}" method="POST">
                @csrf

                <div class="mb-3 position-relative">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required>
                    <span class="eye-icon" onclick="togglePassword('old_password')">
                        <i class="bx bx-show" id="toggle-old_password"></i>
                    </span>
                </div>

                <div class="mb-3 position-relative">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <span class="eye-icon" onclick="togglePassword('new_password')">
                        <i class="bx bx-show" id="toggle-new_password"></i>
                    </span>
                </div>

                <div class="mb-3 position-relative">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="new_password_confirmation"
                        name="new_password_confirmation" required>
                    <span class="eye-icon" onclick="togglePassword('new_password_confirmation')">
                        <i class="bx bx-show" id="toggle-new_password_confirmation"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100">Change Password</button>
            </form>
        </div>
    </div>
</section>

@endsection

<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(`toggle-${fieldId}`);
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("bx-show");
            toggleIcon.classList.add("bx-hide");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("bx-hide");
            toggleIcon.classList.add("bx-show");
        }
    }
</script>

<style>
    .position-relative .eye-icon {
        position: absolute;
        right: 10px;
        top: 35px;
        cursor: pointer;
        color: #6c757d;
    }
</style>