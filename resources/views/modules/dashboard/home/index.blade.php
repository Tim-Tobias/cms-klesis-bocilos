@extends('app')

@section('title', 'Admin Dashboard - Home')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Home Section'" :description="'this is for section one content'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Home'],
          ]" />
      </div>
  </div>

  <section class="section">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title">
                Content
            </h5>
            
            <div class="d-flex gap-3">
                <button id="saveOrder" class="btn btn-info btn-sm d-none">Save Order</button>

                <a class="btn btn-primary btn-sm d-flex" href="/dashboard/home/create">
                    <i class="bi bi-plus mr-2"></i>
                    Create
                </a>
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
                        @foreach ($home_images as $image)
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
                                    <a class="btn btn-primary btn-sm" href="{{"/dashboard/home/".$image->id."/edit"}}">Edit</a>
                                    <form action="{{"/dashboard/home/".$image->id}}" method="POST">
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