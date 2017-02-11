@extends('layouts.error')

@section('title')
{{___( "We're Experiencing Technical Difficulties" )}}
@stop

@section('message')
{{___("Sorry, an error has occured which prevented us from rendering the page you requested. Please contact our support team and quote the following reference number")}}:</p>
@stop

@section('message')
{{___("Unfortunately, we were not able to proceed, due to a technical error. Please contact our support team and quote the following reference number")}}:</p>
@stop
