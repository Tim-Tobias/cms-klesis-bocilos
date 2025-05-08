@extends('app')

@section('title', 'Admin Dashboard - Edit User Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'User Edit'" :description="'this is for user'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'User', 'url' => '/dashboard/users'],
              ['name' => 'Edit'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/users/{{ $user->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group col-12">
              <label for="basicInput">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="basicInput" name="name" placeholder="Enter name" fdprocessedid="m3kdzr" value="{{ $user->name }}">
              @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group col-12">
              <label for="basicInput">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="basicInput" name="email" placeholder="Enter email" fdprocessedid="m3kdzr" value="{{ $user->email }}">
              @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group col-12">
              <label for="basicInput">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="basicInput" name="password" placeholder="Enter password" fdprocessedid="m3kdzr" value="{{ old('password') }}">
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

@push('scripts')
<script>
    var snow = new Quill("#snow", {
        theme: "snow",
    });

    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('#content').value = snow.root.innerHTML;
    });

    document.getElementById('formFile').addEventListener('change', function(event) {
        const input = event.target;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]); // ubah ke base64 preview
        }
    });
</script>
@endpush