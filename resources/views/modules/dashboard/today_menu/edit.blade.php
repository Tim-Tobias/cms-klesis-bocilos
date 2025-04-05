@extends('app')

@section('title', 'Admin Dashboard - Edit Menu Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Edit Menu'" :description="'this is for menu'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Menu', 'url' => '/dashboard/today-menu'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/today-menu/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group col-12">
                <label for="basicInput">Name</label>
                <input type="text" value="{{ $menu->name }}" class="form-control @error('name') is-invalid @enderror" id="basicInput" name="name" placeholder="Enter name" fdprocessedid="m3kdzr">
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
                    <option {{ $menu->id_category === $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('id_category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 row">
                <div class="col-md-6 col-sm-12">
                    <label for="formFile" class="form-label">File</label>
                    <input class="form-control @error('file_path') is-invalid @enderror" type="file" name="file_path" id="formFile">
                    @error('file_path')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                <div class="d-flex gap-3 align-items-center col-md-6 col-sm-12">
                    <div>
                        <p>Preview:</p>
                        <img id="preview-image" style="width: 100px" src="{{ asset('storage/'. $menu->file_path) }}" alt="">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary btn-sm" type="submit">Save</button>
        </form>
        </div>
    </div>
  </section>
</div>
@endsection