@extends('app')

@section('title', 'Admin Dashboard - Edit Menu Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Menu Image Edit'" :description="'this is for section three content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Menu', 'url' => '/dashboard/menu'],
              ['name' => 'Edit'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="{{ "/dashboard/menu/" . $data_image->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group col-12 mb-3">
                <label for="basicInput">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="basicInput" value="{{ $data_image->name }}" name="name" placeholder="Enter Name" fdprocessedid="m3kdzr">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <h6>Order</h6>
            <div class="input-group mb-3 col-12">
                <label class="input-group-text" for="inputGroupSelect01">Order</label>
                <select class="form-select @error('order') is-invalid @enderror" name="order" id="inputGroupSelect01">
                    @for ($i = 0; $i < $order; $i++)
                    <option {{ $data_image->order == ($i + 1) ? "selected" : "" }} value="{{ $i + 1 }}">{{$i + 1}}</option>
                    @endfor
                </select>
                @error('order')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="exampleFormControlTextarea1" rows="3">{{ $data_image->description }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <h6>Is Active</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" name="active" value="1" type="checkbox" id="flexSwitchCheckChecked" checked="{{ $data_image->active }}">
                <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
                @error('active')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3 row">
                <div class="col-md-6 col-sm-12">
                    <label for="formFile" class="form-label">File</label>
                    <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="formFile">
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                <div class="d-flex gap-3 align-items-center col-md-6 col-sm-12">
                    <div>
                        <p>Preview:</p>
                        <img id="preview-image" style="width: 100px" src="{{ asset('storage/'. $data_image->file_path) }}" alt="">
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