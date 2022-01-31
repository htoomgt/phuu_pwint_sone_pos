@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')


@endsection


@push('page_js_script')
@include('common.DropdownLists')


@endpush
