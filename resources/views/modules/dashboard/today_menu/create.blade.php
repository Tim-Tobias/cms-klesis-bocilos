@extends('app')

@section('title', 'Admin Dashboard - Create Category Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Category Create'" :description="'this is for category'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Category', 'url' => '/dashboard/today-menu/categories'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/today-menu" method="POST" enctype="multipart/form-data">
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

            <h6>Category</h6>
            <div class="input-group mb-3 col-12">
                <label class="input-group-text" for="inputGroupSelect01">Category</label>
                <select class="form-select @error('id_category') is-invalid @enderror" name="id_category" id="inputGroupSelect01">
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('id_category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 col-12">
                <label for="formFile" class="form-label">File</label>
                <input class="form-control @error('file_path') is-invalid @enderror" type="file" name="file_path" id="formFile">
                @error('file_path')
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