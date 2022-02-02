@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')
    <h1>Make Product breakdown list </h1>

@endsection


@push('page_js_script')
@include('common.DropdownLists')


@endpush
