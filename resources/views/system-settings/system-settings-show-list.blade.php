@extends('layouts.master')


@section('title', session('lvl2_page_title'))

@section('content')
     <!-- Content Header (Page header) -->
    <x-page-header />
    <!-- /.content-header -->

    {{-- Main Content start  --}}
    <div class="content">
        <div class="container-fluid">
            {{-- Add New button block start --}}
            <x-add-new-button-block routeName="" buttonText="Add New" targetModel="mdlSystemSettings"/>
            {{-- Add New button block end --}}

            {{-- Datatable block start --}}
            <x-data-table-block
                dataTableHeader="Product Breakdown List"
                :dataTableId="$dataTableId"
                :dataTable="$dataTable"
            />
            {{-- Datatable block end --}}
        </div>
    </div>

    {{-- Main Content end --}}

    {{-- Load Modals Start--}}
        @include('system-settings.system-setting-create')
        @include('system-settings.system-setting-edit')
    {{-- Load Modals End --}}


@endsection


@push('page_js_script')
{{-- Datatable Script --}}
{!! $dataTable->scripts() !!}

@include('system-settings.js_load.system-setting-create-js')
@include('system-settings.js_load.system-setting-update-js')


@endpush
