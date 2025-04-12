@extends('app')

@section('title', 'Admin Dashboard - Create Social Media Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Social Media Create'" :description="'this is for social media'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Social Media'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/social-media" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group col-12">
                <label for="basicInput">Name</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="basicInput" name="name" placeholder="Enter Name" fdprocessedid="m3kdzr">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group col-12">
              <label for="basicInput">Path</label>
              <input type="text" class="form-control @error('path') is-invalid @enderror" id="basicInput" name="path" placeholder="Enter Name" fdprocessedid="m3kdzr">
              @error('path')
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