@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tableau de bord</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h3 class="fs-5 fw-bold">Total Sale</h3>
                            <h3 class="fw-bold">{{ number_format($totalRevenue,0,',',' ') }} CFA</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h4 class="fs-5 fw-bold">This mounth Sale</h4>
                            <h3 class="fw-bold">{{ number_format($revenueThisMounth,0,',',' ') }} CFA</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h4 class="fs-5 fw-bold">Revenue last mounth ({{ $lastMounthName }})</h4>
                            <h3 class="fw-bold">{{ number_format($revenueLastMounth,0,',',' ') }} CFA</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="javascript:void(0);" class="small-box-footer">&nbsp;</a>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h4 class="fs-5 fw-bold">Total Orders</h4>
                            <h3 class="fw-bold">{{ $totalOrders }}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.order') }}" class="small-box-footer text-dark">Savoir plus <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h3 class="fs-5 fw-bold">Total Products</h3>
                            <h3 class="fw-bold">{{ $totalProducts }}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.product') }}" class="small-box-footer text-dark">Savoir plus <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-12 mb-4">
                    <div class="small-box card rounded-1 p-4">
                        <div class="inner">
                            <h3 class="fs-5 fw-bold">Total Customers</h3>
                            <h3 class="fw-bold">{{ $userOrders }}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.users') }}" class="small-box-footer text-dark">Savoir plus <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        console.log("Bonjour")
    </script>
@endsection
