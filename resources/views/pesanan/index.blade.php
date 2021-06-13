@extends('layouts.app')
@section('title', 'Pesanan')
@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Seluruh Pesanan</h3>
                      </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-stripped" id="example1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Kategori</th>
                                    <th>Keluhan</th>
                                    <th>Dipesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama_pesanan }}</td>
                                    <td>{{ $p->nama_pelanggan }}</td>
                                    <td>{{ $p->kategori->nama_kategori }}</td>
                                    <td>{{ $p->keluhan}}</td>
                                    <td>{{ $p->created_at }}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#modal-info{{$p->id}}"
                                            class="btn btn-info"><i class="fas fa-info-circle"></i></a>
                                        <a data-toggle="modal" id="updateAdmin" data-target="#modal-edit{{$p->id}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('pesanan.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-edit{{$p->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modal-judul">Edit data Pesanan {{ $p->nama_pesanan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route ('pesanan.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nama_pesanan">Nama Pesanan</label>
                                                        <input type="text" class="form-control" name="nama_pesanan" id="nama_pesanan" value="{{ $p->nama_pesanan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                                        <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" value="{{ $p->nama_pelanggan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat_pelanggan">Alamat Pelanggan</label>
                                                        <textarea class="form-control" name="alamat_pelanggan" id="alamat_pelanggan">{{ $p->alamat_pelanggan }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_hp_pelanggan">No. HP Pelanggan</label>
                                                        <input type="text" class="form-control" name="no_hp_pelanggan" id="no_hp_pelanggan" value="{{ $p->no_hp_pelanggan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_barang">Nama Barang</label>
                                                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="{{ $p->nama_barang }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="level">Kategori</label>
                                                        <select class="form-control" name="id_kategori" id="id_kategori">
                                                            @foreach ($kategori as $k)
                                                            <option {{ $k->id == $p->id_kategori  ? 'selected':'' }} value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keluhan">Keluhan</label>
                                                        <textarea class="form-control" name="keluhan" id="keluhan">{{ $p->keluhan }}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="modal-info{{$p->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modal-judul">Detail {{ $p->nama_pesanan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="nama_pesanan">Nama Pesanan</label>
                                                    <p>{{ $p->nama_pesanan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_pelanggan">Nama Pelanggan</label>
                                                    <p>{{ $p->nama_pelanggan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="alamat_pelanggan">Alamat Pelanggan</label>
                                                    <p>{{ $p->alamat_pelanggan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="no_hp_pelanggan">No. HP Pelanggan</label>
                                                    <p>{{ $p->no_hp_pelanggan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_barang">Nama Barang</label>
                                                    <p>{{ $p->nama_barang }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_kategori">Kategori</label>
                                                    <p>{{ $p->kategori->nama_kategori }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keluhan">Keluhan</label>
                                                    <p>{{ $p->keluhan }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dibuat">Dipesan pada</label><br>
                                                    <p>{{ $p->created_at }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <label for="diupdate">Terakhir update</label><br>
                                                    <p>{{ $p->updated_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-register">
                    <i class="fas fa-plus"></i>&nbsp;Tambahkan Data Pesanan Baru</a>
                </button>
                {{-- <a href="{{ route('admin.create') }}" class="btn btn-success"><i
                    class="fas fa-plus"></i>&nbsp;Tambahkan Data Admin</a> --}}
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<div class="modal fade" id="modal-register">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Masukkan Data Pesanan Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_pesanan">Nama Pesanan</label>
                        <input type="text" class="form-control" name="nama_pesanan" id="nama_pesanan" placeholder="Masukkan Nama Pesanan">
                    </div>
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Masukkan Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="alamat_pelanggan">Alamat Pelanggan</label>
                        <textarea class="form-control" name="alamat_pelanggan" id="alamat_pelanggan" placeholder="Masukkan Alamat Pelanggan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp_pelanggan">No. HP Pelanggan</label>
                        <input type="text" class="form-control" name="no_hp_pelanggan" id="no_hp_pelanggan" placeholder="Masukkan No. HP Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Masukkan Nama Barang">
                    </div>
                    <div class="form-group">
                        <label for="level">Kategori</label>
                        <select class="form-control" name="id_kategori" id="id_kategori">
                            <option selected disabled hidden>Pilih Kategori</option>
                            @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keluhan">Keluhan</label>
                        <textarea class="form-control" name="keluhan" id="keluhan" placeholder="Masukkan Keluhan"></textarea>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
