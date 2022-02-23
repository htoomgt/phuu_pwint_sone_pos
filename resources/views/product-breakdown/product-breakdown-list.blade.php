@extends('layouts.master')

@section('title',  session('lvl2_page_title'))


@section('content')
    <!-- Content Header (Page header) -->
    <x-page-header />
    <!-- /.content-header -->

    {{-- Main Content start  --}}

    {{-- Main Content end --}}



@endsection


@push('page_js_script')
@include('common.DropdownLists')


@endpush
