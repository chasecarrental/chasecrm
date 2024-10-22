@extends('layouts.master')
@include('laravel-crm::layouts.partials.meta')
@section('css')
    @include('laravel-crm::styles') 
@endsection

@section('content')

    @include('laravel-crm::deliveries.partials.card-index')

@endsection

@section('script')
    @include('laravel-crm::codification') 
@endsection
