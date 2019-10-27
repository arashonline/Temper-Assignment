@extends('layouts.app')

@section('content')
    <example-component {{auth()->check() && in_array(auth()->user()->email,config('temper'))?'temper="true" analytic="'.url('analytic').'"':'temper=""'}}></example-component>
@endsection
