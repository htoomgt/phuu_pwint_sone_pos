<div class="row">
    <div class="col-lg-12">
        @if($routeName)
        <a id="btnAddNew" class="btn btn-outline-primary" href="{{$routeName}}" >
            <i class="fa fa-plus"></i>
           {{$buttonText}}
        </a>
        @endif

        @if($targetModel)
            <button
                 class="btn btn-outline-primary"
                data-toggle="modal" data-target="#{{$targetModel}}"
            >
                {{$buttonText}}
            </button>
        @endif


    </div>

</div>
