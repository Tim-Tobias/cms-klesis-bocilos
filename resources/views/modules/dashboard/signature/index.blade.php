@extends('app')

@section('title', 'Admin Dashboard - Signature')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Signature Section'" :description="'this is for section one content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Signature'],
          ]" />
      </div>
  </div>

  <section class="section col-md-6 col-sm-12">
    <div class="card">
        <div class="card-body">
            @if (isset($background->file_path))
            <img style="width: 250px" class="mb-3" src="{{asset('storage/'. $background->file_path)}}" alt="">
            @endif

            <form action="/dashboard/signature/edit-background" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="mb-3">
                    <label for="formFile" class="form-label">Background File</label>
                    <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" id="formFile">
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </form>
        </div>
    </div>
  </section>

  <section class="section">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title">
                Signature Image
            </h5>
            
            <div class="d-flex gap-3">
                <button id="saveOrder" class="btn btn-info btn-sm d-none">Save Order</button>

                @if (count($images) < 3)
                <a class="btn btn-primary btn-sm d-flex" href="/dashboard/signature/create">
                    <i class="bi bi-plus mr-2"></i>
                    Create
                </a>
                @endif
            </div>
        </div>

        <div class="card-body overflow-auto">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                        <tr>
                            <td>{{ $image->order }}</td>
                            <td><img src="{{ asset('storage/' . $image->file_path) }}" width="100" /></td>
                            <td>{{ $image->name }}</td>
                            <td>{{ $image->description }}</td>
                            <td>
                                @if ($image->active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-error">Deactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a class="btn btn-primary btn-sm" href="{{"/dashboard/signature/".$image->id."/edit"}}">Edit</a>
                                    <form action="{{"/dashboard/signature/".$image->id}}" method="POST">
                                        @csrf
                                        @method("DELETE")

                                        <button type="submit" class="btn btn-danger btn-sm" href="">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </section>
</div>
@endsection