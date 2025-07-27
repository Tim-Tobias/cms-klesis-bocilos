@extends('app')

@section('title', 'Admin Dashboard - Create Social Media Section')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Social Media Create'" :description="'this is for social media'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Social Media'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-body">
          <form action="/dashboard/social-media" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="input-group mb-3 col-12">
                <label class="input-group-text" for="inputGroupSelect01">Social Media</label>
                <select class="form-select @error('name') is-invalid @enderror" name="name" id="inputGroupSelect01">
                    <option value="instagram">Instagram</option>
                    <option value="whatsapp">Whatsapp</option>
                    <option value="tiktok">Tiktok</option>
                    <option value="facebook">Facebook</option>
                </select>
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

            <div class="form-group col-12">
              <label for="basicInput">Path</label>
              <input type="text" class="form-control @error('path') is-invalid @enderror" id="basicInput" name="path" placeholder="Enter Name" fdprocessedid="m3kdzr">
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