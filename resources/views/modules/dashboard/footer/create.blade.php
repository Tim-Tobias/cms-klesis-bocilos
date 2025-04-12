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
          <x-title-content :title="'Footer Content Create'" :description="'this is for section two content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Footer Section', 'url' => '/dashboard/footer'],
              ['name' => 'Create'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/footer" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <div id="snow" class="form-control @error('content') is-invalid @enderror"></div>
                @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

                <input type="hidden" name="content" id="content">

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
</script>
@endpush