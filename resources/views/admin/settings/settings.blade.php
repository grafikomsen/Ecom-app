@extends('admin.layouts.app')
@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="fs-2 fw-bold">Paramétre du site</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.settings') }}" class="btn btn-primary btn-sm shadow-sm rounded-1 border-0">
                Actualisée la page
            </a>
        </div>
    </div>

    <!-- Main content -->
    <section class="content h-100">
        <div class="container-fluid h-100">
            <!-- Small boxes (Stat box) -->
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-0 shadow-sm" role="alert">
                    <i class="fa fa-chess-king px-2"></i> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                   <div class="card rounded-1">
                        <div class="card-body table-responsive rounded-1">
                            <table class="table table-hover text-nowrap table-striped rounded-1">
                                <thead>
                                    <tr>
                                        <th>Titre du site Web</th>
                                        <th>Image Seo</th>
                                        <th width="100">Status</th>
                                        <th width="100">Date de modification</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($settings->isNotEmpty())
                                        @foreach ($settings as $setting)
                                        <tr>
                                            <td>{{ $setting->website_title }}</td>
                                            <td>
                                                @if (!empty($setting->image))
                                                    <img class="img-thumbnail" src="{{ asset('uploads/settings/'.$setting->image) }}" width="50" alt="{{ $setting->name }}">
                                                @else
                                                    <img class="img-thumbnail" src="{{ asset('front/assets/images/pexels-photo.jpeg') }}" width="50" alt="pas d'image">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($setting->status == 1)
                                                <span class="badge rounded-1 bg-primary">Activé</span>
                                                @else
                                                    <span class="badge rounded-1 bg-danger">Désactivé</span>
                                                @endif
                                            </td>
                                            <td>{{ $setting->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('admin.settings.edit',$setting->id) }}" class="btn btn-sm bg-primary rounded-1">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                                {{-- <a href="javascript:void(0);" onclick="deleteSetting({{ $setting->id }})" class="btn btn-sm btn-danger rounded-0">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a> --}}
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
        function deleteSetting(id){

            let url = '{{ route("admin.settings.destroy","ID") }}';
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
                            window.location.href = "{{ route('admin.settings') }}";
                        }
                    }
                })
            }
        }
    </script>
@endsection
