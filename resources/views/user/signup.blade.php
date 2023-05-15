@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
            <h1>Sign Up</h1>
            {{-- @if (count($errors) > 0) --}}
                @include('layouts.flash-messages')
            {{-- @endif --}}
            <form class="" action="{{ route('user.signup')}}" method="POST">
                {{-- /*{{ route('user.signup')}}*/ --}}
                @csrf
                <div class="form-group">
                    <label for="Name"> First Name: </label>
                    <input type="text" name="fname" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Name"> Last Name: </label>
                    <input type="text" name="lname" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="addressline" id="address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" name="zipcode" id="zipcode" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="text" name="phone" id="address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                    <input type="submit" value="Sign Up" class="btn btn-primary">
             </form>
        </div>
    </div>
@endsection
