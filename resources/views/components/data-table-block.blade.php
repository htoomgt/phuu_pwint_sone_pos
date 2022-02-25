<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">{{$dataTableHeader}}</h5>
            </div>
            <div class="card-body " style="">
                {{-- Datatable here --}}
                {{ $dataTable->table(['id' => $dataTableId, 'class' => 'display table table-responsive table-striped collpase',
                'style' => 'width:100%;']) }}



            </div>
        </div>
    </div>
</div>
