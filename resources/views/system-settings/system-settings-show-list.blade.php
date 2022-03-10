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
            <x-add-new-button-block routeName="{{ route('productBreakdown.makeBreakdownPage') }}" buttonText="Make New" />
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


@endsection


@push('page_js_script')
{{-- Datatable Script --}}
{!! $dataTable->scripts() !!}

@endpush
