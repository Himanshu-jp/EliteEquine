@extends('frontauth.layouts.main')
@section('title')
    Invoices
@endsection
@section('content')
    <div class="container-fluid mt-4">


        <div class="row">
            <h4 class="mb-3">Your Invoice</h4>
            <div class="table-responsive invoice-tbl">
                <table class="table table-bordered table-hover align-middle text-strat">
                    <thead class="table-light">
                        <tr>
                            {{-- <th>S/No</th> --}}
                            <th>Invoice</th>
                            {{-- <th>Subscription ID</th> --}}
                            <th>Plan Name</th>
                            <th class="text-end">Invoice</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction as $item)
                            <tr>
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                <td>Order-{{ $item->plan_purchase_on }}</td>
                                {{-- <td>{{ $item->subscription_id }}</td> --}}
                                <td>{{ @$item->planData->title ?? 'Addon Invoice' }}</td>
                                <td class="text-end"><a href="{{ route('invoiceDetails',[ base64_encode($item->id)]) }}"  target="_blank"
                                        class="btn btn-primary btbn">View invoice</a></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
        <div class="row invoiceData">
            {{-- <div class="invoice-wrapper info-invoice">
    <!-- Header -->
    <div class="header">
      <h1>INVOICE</h1>
      <div class="company-info">
        <strong>ELITEQUINE</strong><br />
        Street Address<br />
        Virginia, USA, 20103
      </div>
    </div>

    <!-- Info Section -->
    <div class="section">
      <div>
        <strong>Bill To</strong><br />
        Chad Keenum<br />
        United States<br />
        Virginia<br />
        Middleburg
      </div>
      <div>
        <strong>Invoice Number:</strong> 1749585021<br />
        <strong>Date Created:</strong> June 10, 2025<br />
        <strong>Payment Type:</strong> bank
      </div>
      <div class="text-right">
        <strong>Order Total</strong><br />
        <span style="font-size: 24px; font-weight: bold;">$0.00</span>
      </div>
    </div>

    <!-- Table -->
    <table class="table">
      <thead>
        <tr>
          <th>Description</th>
          <th class="text-right">Quantity</th>
          <th class="text-right">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Subscription: PROMO: Free Featured Unlimited - Quarterly</td>
          <td class="text-right">1</td>
          <td class="text-right">$0.00</td>
        </tr>
      </tbody>
    </table>

    <!-- Total -->
    <div class="text-right total">Total Amount &nbsp;&nbsp; $0.00</div>
  </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.text-box').forEach(function(box) {
            const textContainer = box.querySelector('.text-container');
            const toggleBtn = box.querySelector('.toggle-btn');

            toggleBtn.addEventListener('click', function() {
                textContainer.classList.toggle('expanded');
                toggleBtn.textContent = textContainer.classList.contains('expanded') ? 'Show less' :
                    'Show more';
            });
        });
    </script>
   
@endsection
