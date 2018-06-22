@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Administrador</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{action('AdminController@Index')}}">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Sales stats -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="icon-star font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 info float-right">5,879</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Products</span>
                                                <span class="info float-right"><i class="ft-arrow-up info"></i> 16.89%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="icon-user font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 danger float-right">423</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Orders</span>
                                                <span class="danger float-right"><i class="ft-arrow-up danger"></i> 5.14%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="icon-shuffle font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 success float-right">61%</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Conversion</span>
                                                <span class="success float-right"><i class="ft-arrow-down success"></i> 2.24%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="icon-wallet font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 warning float-right">$6,87M</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Profit</span>
                                                <span class="warning float-right"><i class="ft-arrow-up warning"></i> 43.84%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60"
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales stats -->
            <!-- Sales by Campaigns & Year -->
            <div class="row">
                <div class="col-xl-8 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Smooth Area Chart</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <ul class="list-inline text-center">
                                    <li>
                                        <h6><i class="ft-circle grey lighten-1"></i> iPhone</h6>
                                    </li>
                                    <li>
                                        <h6><i class="ft-circle success"></i> Samsung</h6>
                                    </li>
                                </ul>
                                <div id="smooth-area-chart" class="height-350"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body sales-growth-chart">
                                <div id="mobile-sales" class="height-300"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="chart-title mb-1">
                                <span class="text-muted">Total mobile units sold and total earning statistics.</span>
                            </div>
                            <ul class="list-inline text-center clearfix mt-1">
                                <li class="mr-3">
                                    <span class="text-muted">Total Units Sold</span>
                                    <h2 class="block">18.6 k</h2>
                                </li>
                                <li>
                                    <span class="text-muted">Total Earnings</span>
                                    <h2 class="block">64.54 M</h2>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Sales by Campaigns & Year -->
        </div>
    </div>
@endsection
