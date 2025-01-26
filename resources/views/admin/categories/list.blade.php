@extends('admin.layouts.app')
@section('main')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.categorie.create') }}" class="btn btn-primary rounded-1 border-0">Nouvelle catégorie</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.messages')
            <div class="card rounded-1">
                <form action="" method="GET">
                    <div class="card-header">
                        <div class="card-title float-end">
                            <a class="btn btn-primary rounded-1 border-0 btn-sm" href="{{ route('admin.categorie') }}">Actualisé la page</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control rounded-1 float-right" placeholder="Cherchez ici...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary border-0 rounded-1">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0 rounded-1">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Nom</th>
                                <th>Lien</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            @if ($category->status)
                                                <i class="fa fa-check-circle text-primary"></i>
                                            @else
                                                <i class="fa fa-check-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm rounded-1 border-0" href="{{ route('admin.categorie.edit',$category->id) }}">
                                                <i class="fa fa-edit text-white"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm rounded-1 border-0" onclick="deleteCategory({{ $category->id }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="5">Records not found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection

@section('customJs')
    <script>
        function deleteCategory(id){

            let url = '{{ route("admin.categorie.destroy","ID") }}';
            let newUrl = url.replace('ID',id);

            if (confirm('Are you sure you want to delete')) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $("button[type=submit]").prop('desabled', false);
                        if (response['status']) {
                            window.location.href="{{ route('admin.categorie') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection
