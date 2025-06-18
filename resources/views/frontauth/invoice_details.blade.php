@extends('frontauth.layouts.main')
@section('title')
    Invoices
@endsection
@section('content')
    <div class="container-fluid mt-4">

 <div class="invoice-wrapper info-invoice">
    <div class="header">
      <h1>INVOICE</h1>
      <div class="company-info">
        <strong>ELITEQUINE</strong><br />
        Street Address<br />
        Virginia, USA, 20103
      </div>
    </div>

    <div class="section">
      <div>
        <strong>Bill To</strong><br />
        {{ Auth::user()->street }} {{ Auth::user()->city }}<br />
        {{ Auth::user()->state }} <br />
        {{ Auth::user()->country }}
      </div>
      <div>
        <strong>Invoice Number:</strong> {{ $invoice->plan_purchase_on }}<br />
        <strong>Date Created:</strong> {{ date('F d, Y',strtotime($invoice->created_at)) }}<br />
        <strong>Payment Type:</strong> {{ ucfirst($invoice->type) }}
      </div>
      <div class="text-right">
        <strong>Order Total</strong><br />
        <span style="font-size: 24px; font-weight: bold;">${{ number_format($invoice->plan_price,2) }}</span>
      </div>
    </div>

@if($invoice->type == 'plan')
    <table class="table">
      <thead>
        <tr>
          <th>Description</th>
          {{-- <th class="text-right">Quantity</th> --}}
          <th class="text-end">Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ ucfirst($invoice->planData->title ?? "Addons") }}</td>
          {{-- <td class="text-right">1</td> --}}
          <td class="text-end">${{ number_format($invoice->plan_price,2) }}</td>
        </tr>
      </tbody>
    </table>
@else
<?php $addonData=$invoice->addonData; ?>
<table class="table">
      <thead>
        <tr>
          <th>Description</th>
          {{-- <th class="text-right">Quantity</th> --}}
          <th class="text-end">Amount</th>
        </tr>
      </thead>
      <tbody>
@foreach ($addonData as $adds)
    <?php $xDataFake=json_decode($adds->add_on_data,true); ?>
        <tr>
          <td>{!! $xDataFake['description'] !!}</td>
          {{-- <td class="text-right">1</td> --}}
          <td class="text-end">${{ number_format($xDataFake['price'],2) }}</td>
        </tr>
  
@endforeach
      </tbody>
    </table>
@endif
    <div class="text-right total">Total Amount &nbsp;&nbsp; ${{ number_format($invoice->plan_price,2) }}</div>
  </div>
    </div>
@endsection

