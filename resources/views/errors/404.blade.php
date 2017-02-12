@extends('layouts.error')

@section('title')
{{___( "Page not Found" )}}
@stop

@section('message')
{{___("Sorry, the page you tried to reach doesn't exist. If it worked previously, it probably have ben removed. If you feel this page should exist, please contact our support team and quote the following reference number")}}
@stop
