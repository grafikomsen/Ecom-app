@extends('admin.layouts.app')
@section('main')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="fs-2 fw-bold">Liste des banniérès</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.banners') }}" class="btn btn-primary btn-sm shadow-sm rounded-1 border-0">
                Actualisée la page
            </a>
        </div>
    </div>

    <!-- Main content -->
    <section class="content h-100">
        <div class="container-fluid h-100">
            <!-- Small boxes (Stat box) -->
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-1 shadow-sm" role="alert">
                    <i class="fa fa-chess-king px-2"></i> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                   <div class="card rounded-1">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-tools shadow-sm">
                                <form action="" method="GET">
                                    <div class="input-group input-group" style="width: 250px;">
                                        <input type="text" name="keyword" value="{{ (!empty(Request::get('keyword'))) ? Request::get('keyword') : '' }}" class="form-control rounded-1 float-right" placeholder="Cherchez ici...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn bg-primary border-0 rounded-1">
                                                <i class="fa fa-search text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm shadow-sm rounded-1 border-0">
                                <i class="fas fa-plus"></i> &nbsp;Creer un banner
                            </a>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        <th>Nom de banner</th>
                                        <th width="100">Image du banner</th>
                                        <th width="100">Date de création</th>
                                        <th width="100">Status</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($banners->isNotEmpty())
                                        @foreach ($banners as $banner)
                                        <tr>
                                            <td>{{ $banner->id }}</td>
                                            <td>{{ $banner->name }}</td>
                                            <td>
                                                @if (!empty($banner->image))
                                                    <img class="img-thumbnail" src="{{ asset('uploads/banners/'.$banner->image) }}" width="50" alt="{{ $banner->name }}">
                                                @else
                                                    <img class="img-thumbnail" src="{{ asset('front/assets/images/pexels-photo.jpeg') }}" width="50" alt="pas d'image">
                                                @endif
                                            </td>
                                            <td>{{ $banner->created_at }}</td>
                                            <td>
                                                @if ($banner->status == 1)
                                                <span class="badge rounded-1 bg-primary">Activé</span>
                                                @else
                                                    <span class="badge rounded-1 bg-danger">Désactivé</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.banners.edit',$banner->id) }}" class="btn btn-sm bg-primary rounded-1">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                <a href="javascript:void(0);" onclick="deletebanner({{ $banner->id }})" class="btn btn-sm btn-danger rounded-1">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-uppercase fw-bolder text-center">La base de doonée est vide</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $banners->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extraJs')
    <script>
        function deletebanner(id){

            let url = '{{ route("admin.banners.destroy","ID") }}';
            let newUrl = url.replace('ID',id);

            if (confirm('Êtes-vous sûr de vouloir supprimer')) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        $("button[type=submit]").prop('desabled', false);
                        if (response['status']) {
                            window.location.href = "{{ route('admin.banners') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection
