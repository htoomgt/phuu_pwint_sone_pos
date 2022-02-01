@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')
<h1> Edit Product Break down Page!</h1>

@endsection


@push('page_js_script')
@include('common.DropdownLists')


@endpush
