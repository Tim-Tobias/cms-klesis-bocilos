@extends('app')

@section('title', 'Admin Dashboard - Edit Home Section')

@push('style')
<style>
</style>
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'About Content Edit'" :description="'this is for section two content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'About Section', 'url' => '/dashboard/about'],
              ['name' => 'Edit'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/about/{{ $content->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <textarea name="content" id="editor" rows="5" class="form-control @error('content') is-invalid @enderror">
                    {{ $content->content }}
                </textarea>
                @error('content')
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