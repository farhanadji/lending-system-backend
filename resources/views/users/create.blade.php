@extends("layouts.global")

@section("title") Create User @endsection

@section("content")
<div class="col-md-8">
    <form class="bg-white shadow-sm p-3" action="{{route('users.store')}}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input 
        class="form-control" 
        placeholder="Full Name" 
        type="text" 
        name="name" 
        id="name"/>
        <br>

        <label for="">Role</label>
        <select class="form-control" id="role">
        <option value="ADMIN">Admin</option>
        <option value="CUSTOMER">Customer</option>
        </select>

        <hr class="my-3">

        <label for="email">Email</label>
        <input 
        class="form-control" 
        placeholder="user@mail.com" 
        type="text" 
        name="email" 
        id="email"/>
        <br>

        <label for="password">Password</label>
        <input 
        class="form-control" 
        placeholder="password" 
        type="password" 
        name="password" 
        id="password"/>
        <br>

        <label for="password_confirmation">Password Confirmation</label>
        <input 
        class="form-control" 
        placeholder="password confirmation" 
        type="password" 
        name="password_confirmation" 
        id="password_confirmation"/>
        <br>

        <input 
            class="btn btn-primary" 
            type="submit" 
            value="Save"/>

    </form> 
</div>
@endsection