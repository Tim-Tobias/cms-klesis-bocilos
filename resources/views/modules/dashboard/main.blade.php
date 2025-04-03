@extends('app')

@section('title', 'Admin Dashboard - Home')

@section('content')
<div class="page-heading">
  <div class="page-title">
      <div class="row">
          <x-title-content :title="'Profile Statistic'" :description="''"/>

          <x-breadcrumb :items="[
              ['name' => 'Dashboard'],
          ]" />
      </div>
  </div>

  <section class="section min-vh-100">
    
  </section>
</div>

@endsection