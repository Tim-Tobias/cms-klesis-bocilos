@extends('app')

@section('title', 'Admin Dashboard - Create Home Section')

@push('style')
<style>
</style>
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Signature Content Create'" :description="'this is for section two content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Signature Section', 'url' => '/dashboard/signature'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/signature" method="POST" enctype="multipart/form-data">
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

            <div class="mb-3 col-12">
                <label for="formFile" class="form-label">File</label>
                <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="formFile">
                @error('description')
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

@prepend('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
@endprepend

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector("#editor"), {
        toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                'blockQuote',
                'undo',
                'redo'
            ]
    }).catch((error) => {
        console.error(error)
    })
</script>
@endpush