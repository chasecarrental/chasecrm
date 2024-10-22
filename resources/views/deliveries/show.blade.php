@extends('layouts.master')
@include('laravel-crm::layouts.partials.meta')
@section('css')
    @include('laravel-crm::codification') 
@endsection

@section('content')

    @include('laravel-crm::deliveries.partials.card-show')

@endsection

@section('script')
    @include('laravel-crm::codification') 
@endsection
