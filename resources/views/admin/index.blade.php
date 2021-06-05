@extends('layouts.app')
@section('title', 'Admin')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Seluruh Admin</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                <tr>
                                    <td>{{ $a->id }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->level }}</td>
                                    <td>{{ $a->created_at }}</td>
                                    <td>
                                        <a href="" class="btn btn-info"><i class="fas fa-info-circle"></i></a>
                                        <a href="" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.destroy', $a->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <a href="{{ route('admin.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;Tambahkan Data Admin</a>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection
