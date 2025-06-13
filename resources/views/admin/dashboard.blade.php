@extends('admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Users -->
          <x-admin.dashboard-box :count="$totalUsers" label="Users" icon="fa-users" route="users.index" color="bg-info"/>

          <!-- Blogs -->
          <x-admin.dashboard-box :count="$totalBlogs" label="Blogs" icon="fa-blog" route="blogs.index" color="bg-success"/>

          <!-- Enquiries -->
          <x-admin.dashboard-box :count="$totalEnquiries" label="Enquiries" icon="fa-envelope-open-text" route="enquiries.index" color="bg-primary"/>

          <!-- Subscription Plans -->
          <x-admin.dashboard-box :count="$totalSubscriptions" label="Subscription Plans" icon="fa-credit-card" route="subscription_plans.index" color="bg-info"/>

          <!-- Subscription Addons -->
          <x-admin.dashboard-box :count="$totalAddons" label="Subscription Addons" icon="fa-puzzle-piece" route="subscription-addons.index" color="bg-primary"/>

          <!-- Categories -->
          <x-admin.dashboard-box :count="$totalCategories" label="Categories" icon="fa-layer-group" route="categories.index" color="bg-dark"/>

          <!-- Subcategories -->
          <x-admin.dashboard-box :count="$totalSubcategories" label="Subcategories" icon="fa-sitemap" route="sub-categories.index" color="bg-light text-dark"/>
        </div>

        <!-- Chart -->
        <div class="row mt-4">
          <div class="col-md-6"> <!--  'offset-md-3' Center the chart and make it smaller -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Summary Chart</h3>
              </div>
              <div class="card-body text-center">
                <canvas id="productChart" style="max-height: 500px; max-width: 500px; margin: auto;"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('productChart').getContext('2d');
    const productChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Total Products', 'Live Products', 'Sold Products', 'Expired Products'],
            datasets: [{
                label: 'Product Stats',
                data: [
                    {{ $totalProducts }},
                    {{ $liveProducts }},
                    {{ $soldProducts }},
                    {{ $expiredProducts }}
                ],
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#dc3545',
                    '#6c757d'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    enabled: true,
                }
            }
        }
    });
});
</script>
