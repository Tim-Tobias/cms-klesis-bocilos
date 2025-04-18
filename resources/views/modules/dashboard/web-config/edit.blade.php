@extends('app')

@section('title', 'Admin Dashboard - Edit Social Media')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Social Media Create'" :description="'this is for social media'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Home'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="{{ "/dashboard/social-media/" . $social->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="input-group mb-3 col-12">
                <label class="input-group-text" for="inputGroupSelect01">Social Media</label>
                <select class="form-select @error('name') is-invalid @enderror" name="name" id="inputGroupSelect01">
                    <option {{ $social->name === 'instagram' ? 'selected' : '' }} value="instagram">Instagram</option>
                    <option {{ $social->name === 'whatsapp' ? 'selected' : '' }} value="whatsapp">Whatsapp</option>
                </select>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="3">{{ $social->description }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-12 mb-3">
              <label for="basicInput">Path</label>
              <input type="text" class="form-control @error('path') is-invalid @enderror" id="basicInput" value="{{ $social->path }}" name="path" placeholder="Enter Name" fdprocessedid="m3kdzr">
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

@prepend('scripts')
<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
@endprepend

@push('scripts')
<script>
    $(document).ready(function () {
        $('#formFile').change(function (e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview-image')
                        .attr('src', e.target.result)
                        .show();
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush