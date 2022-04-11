@extends('panel::layouts.master')
@php
    function getCurrencyName($id){
        if ($id === 1){
            return 'Bitcoin';
        }
        elseif ($id === 2){
            return 'LiteCoin';
        }
        else{
            return 'Monero';
        }
    }
@endphp
@section('content')
    <h2>Payment Providers
        <a href="{{route('panel.payments.create')}}?offline=1" class="btn btn-link btn-xs"><i class="mdi mdi-plus"></i> Add offline payments</a>
    </h2>

    <div class="row mb-5 pb-5">

        <div class="col-sm-10">


            @foreach($payment_providers as $payment_provider)
            <div class="card card-body p-0 mb-3">
                <div class="row">
                    <div class="col-sm-4 d-flex">
                        <div class="p-3 w-100  bg-light border-right ">
                            <a href=""  >
                            <img src="{{ $payment_provider->logo }}"  class="img-fluid img-thumbnail"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="pt-3 pl-0">

                        <h6 class="mt-2">{{getCurrencyName($payment_provider->currency)}}</h6>
                        <p class="small text-muted">User/Password : {{$payment_provider->username}}/{{$payment_provider->password}}</p>
                        <p class="small text-muted">Hostname/port : {{$payment_provider->host}} / {{$payment_provider->port}}</p>
                        <a href="/panel/payments/{{$payment_provider->id}}/edit" class="btn btn-primary btn-sm">Enter payment details <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                        <a href="/panel/payments/{{$payment_provider->id}}/edit" class="btn btn-primary btn-sm">{{$payment_provider->is_enabled? 'Disable' : 'Enable'}} <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                        <br />
                        <br />
                    </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
</div>
@stop
