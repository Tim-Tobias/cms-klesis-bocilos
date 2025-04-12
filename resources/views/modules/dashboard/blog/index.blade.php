@extends('app')

@section('title', 'Admin Dashboard - Blog')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/compiled/css/table-datatable-jquery.css')}}">
@endpush

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Blog'" :description="'this is for section blog'"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard', 'url' => '/dashboard'],
              ['name' => 'Blog Section'],
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

                <a class="btn btn-primary btn-sm d-flex" href="/dashboard/blog/create">
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
                            <th>Title</th>
                            <th>Content</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $cat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img style="width: 80px" src="{{ $cat->image }}" alt="">
                            </td>
                            <td>{{ $cat->title }}</td>
                            <td>{!! limitText($cat->content) !!}</td>
                            <td>{{ $cat->category->name }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a class="btn btn-primary btn-sm" href="{{"/dashboard/blog/".$cat->id."/edit"}}">Edit</a>
                                    <form action="{{"/dashboard/blog/".$cat->id}}" method="POST">
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