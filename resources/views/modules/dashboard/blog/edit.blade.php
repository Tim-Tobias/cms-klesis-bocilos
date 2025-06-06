@extends('app')

@section('title', 'Admin Dashboard - Create Blog Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Blog Create'" :description="'this is for blog section'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Blog', 'url' => '/dashboard/blog/categories'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/blog/{{ $blog->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <img id="preview-image" src="{{ $blog->image }}" width="200" alt="Preview Image" class="mb-3">

            <div class="mb-3 col-12">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="formFile" accept="image/*">
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group col-12">
                <label for="basicInput">Title</label>
                <input type="text" value="{{ $blog->title }}" class="form-control @error('title') is-invalid @enderror" id="basicInput" name="title" placeholder="Enter title" fdprocessedid="m3kdzr">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <h6>Category</h6>
            <div class="input-group mb-3 col-12">
                <label class="input-group-text" for="inputGroupSelect01">Category</label>
                <select class="form-select @error('blog_category_id') is-invalid @enderror" name="blog_category_id" id="inputGroupSelect01">
                    @foreach ($categories as $cat)
                    <option {{ $blog->blog_category_id == $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('blog_category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <div id="snow" class="form-control @error('content') is-invalid @enderror">
                    {!! $blog->content !!}
                </div>
                @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <input type="hidden" name="content" id="content">

            <h6>Is Active</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" name="active" {{ $blog->active ? "checked" : "" }} value="1" type="checkbox" id="flexSwitchCheckChecked">
                <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
                @error('active')
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