@extends('app')

@section('title', 'Admin Dashboard - Edit Category Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Edit Category'" :description="'this is for category'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Category', 'url' => '/dashboard/today-menu/categories'],
              ['name' => 'Edit'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/today-menu/categories/{{ $cat->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group col-12">
                <label for="basicInput">Category</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="basicInput" name="category" placeholder="Enter Category" fdprocessedid="m3kdzr" value="{{ $cat->name }}">
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