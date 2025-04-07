@extends('app')

@section('title', 'Admin Dashboard - Menu')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Menu Section'" :description="'this is for section one content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Menu'],
          ]" />
      </div>
  </div>

  <div class="row">
      <section class="section col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                @if (isset($background->file_path))
                <img style="width: 250px" class="mb-3" src="{{asset('storage/'. $background->file_path)}}" alt="">
                @endif
    
                <form action="/dashboard/menu/edit-background" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Background</label>
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

      <section class="section col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                @if (isset($file->file_path))
                <iframe src="{{ asset('storage/'.$file->file_path) }}" width="100%" height="100%" style="border: none;"></iframe>
                @endif
    
                <form action="/dashboard/menu/edit-file" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Menu</label>
                        <input class="form-control @error('file_pdf') is-invalid @enderror" type="file" name="file_pdf" id="formFile" accept="application/pdf">
                        @error('file_pdf')
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
  </div>

  <section class="section">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title">
                Menu Image
            </h5>
            
            <div class="d-flex gap-3">
                <button id="saveOrder" class="btn btn-info btn-sm d-none">Save Order</button>

                @if (count($images) < 5)
                <a class="btn btn-primary btn-sm d-flex" href="/dashboard/menu/create">
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
                            <th>Highlight</th>
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
                                @if ($image->highlight)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Deactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($image->active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Deactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a class="btn btn-primary btn-sm" href="{{"/dashboard/menu/".$image->id."/edit"}}">Edit</a>
                                    <form action="{{"/dashboard/menu/".$image->id}}" method="POST">
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