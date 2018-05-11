@extends('layouts.tabler')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            Dashboard
        </h1>
    </div>

    <div class="row row-cards">
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{count($sector)}}</div>
                    <div class="text-muted mb-4">SECTOR</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{count($category)}}</div>
                    <div class="text-muted mb-4">CATEGORY</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format(count($brand))}}</div>
                    <div class="text-muted mb-4">BRAND</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format(count($demo))}}</div>
                    <div class="text-muted mb-4">DEMOGRAPHY</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format(count($ta))}}</div>
                    <div class="text-muted mb-4">TARGET AUDIENCE</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{number_format(count($variabel))}}</div>
                    <div class="text-muted mb-4">VARIABEL</div>
                </div>
            </div>
        </div>
    </div>
@stop