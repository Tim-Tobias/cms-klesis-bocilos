@extends('app')

@section('title', 'Admin Dashboard - Create Category Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Category Create'" :description="'this is for category'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Category', 'url' => '/dashboard/blog/categories'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/blog/categories" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group col-12">
                <label for="basicInput">Category</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="basicInput" name="category" placeholder="Enter Category" fdprocessedid="m3kdzr">
                @error('category')
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