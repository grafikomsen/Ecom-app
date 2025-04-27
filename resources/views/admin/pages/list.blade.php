@extends('admin.layouts.app')
@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary rounded-1 border-0">Nouvelle page</a>
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
                <form method="GET">
                    <div class="card-header">
                        <div class="card-title float-end">
                            <a class="btn btn-primary rounded-1 border-0 btn-sm" href="{{ route('admin.pages') }}">Actualisé la page</a>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control float-right" placeholder="Cherchez ici...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary rounded-1 border-0">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th>Nom</th>
                                <th width="100">slug</th>
                                <th width="100">Date</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages->isNotEmpty())
                                @foreach ($pages as $page)
                                    <tr>
                                        <td>{{ $page->id }}</td>
                                        <td>{{ $page->name }}</td>
                                        <td>{{ $page->slug }}</td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm rounded-1 border-0" href="{{ route('admin.pages.edit',$page->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm rounded-1 border-0" onclick="deletePage({{ $page->id }})">
                                                <i class="fa fa-trash"></i>
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
                    {{ $pages->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection

@section('customJs')
    <script>
        function deletePage(id){

            let url = '{{ route("admin.pages.destroy","ID") }}';
            let newUrl = url.replace('ID',id);

            if (confirm('Etes-vous sûr de vouloir supprimer')) {
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
                            window.location.href="{{ route('admin.pages') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection

