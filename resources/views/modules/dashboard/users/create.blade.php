@extends('app')

@section('title', 'Admin Dashboard - Create User Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'User Create'" :description="'this is for User'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'User', 'url' => '/dashboard/user/categories'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/users" method="POST">
            @csrf
            @method('POST')

            <div class="form-group col-12">
              <label for="basicInput">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="basicInput" name="name" placeholder="Enter name" fdprocessedid="m3kdzr">
              @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group col-12">
              <label for="basicInput">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="basicInput" name="email" placeholder="Enter email" fdprocessedid="m3kdzr">
              @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group col-12">
              <label for="basicInput">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="basicInput" name="password" placeholder="Enter password" fdprocessedid="m3kdzr">
              @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <button class="btn btn-primary btn-sm" type="submit">Save</button>
        </form>
        </div>
    </div>
  </section>
</div>
@endsection