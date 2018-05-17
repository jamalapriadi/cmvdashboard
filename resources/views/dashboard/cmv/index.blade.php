@extends('layouts.tabler')

@section('content')
    <div class="page-header">
        <h1 class="page-title" style="font-style: normal;">
            Dashboard
        </h1>
    </div>

    <div class="row row-cards">
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{$sector}}</div>
                    <div class="text-muted mb-4">SECTOR</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{$category}}</div>
                    <div class="text-muted mb-4">CATEGORY</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format($brand)}}</div>
                    <div class="text-muted mb-4">BRAND</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format($demo)}}</div>
                    <div class="text-muted mb-4">DEMOGRAPHY</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format($ta)}}</div>
                    <div class="text-muted mb-4">TARGET AUDIENCE</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format($variabel)}}</div>
                    <div class="text-muted mb-4">VARIABEL</div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-default">
                {{-- <div class="card-status bg-green"></div> --}}
                <h4 class="card-titles p-3 text-center">TOTAL POPULASI</h4>
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">54.832.000</div>
                </div>
            </div>
        </div>
    </div>
@stop