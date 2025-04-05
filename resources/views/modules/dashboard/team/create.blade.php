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
          <x-title-content :title="'About Content Create'" :description="'this is for section team'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'About Section', 'url' => '/dashboard/about'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/team" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <textarea name="content" id="editor" rows="5" class="form-control @error('content') is-invalid @enderror"></textarea>
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