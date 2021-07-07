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
                                @if ($p->status == 'diproses')
                                <tr style="background-color: yellow;">
                                    @elseif ($p->status == 'selesai')
                                <tr style="background-color: lightgreen;">
                                    @else
                                <tr>
                                    @endif
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama_pesanan }}</td>
                                    <td>{{ $p->nama_pelanggan }}</td>
                                    <td>{{ $p->kategori->nama_kategori }}</td>
                                    <td>{{ $p->keluhan}}</td>
                                    <td>{{ $p->created_at }}</td>
                                    <td>
                                        <a data-toggle="modal" data-target="#modal-info{{$p->id}}"
                                            class="btn btn-info"><i class="fas fa-info-circle"></i></a>

                                        @if ((auth()->user()->level == 'admin' || auth()->user()->level == 'teknisi') &&
                                        $p->status == 'dipesan')
                                        <a class="btn btn-warning" data-toggle="modal" data-target="#modal-fix{{ $p->id }}"><i class="fas fa-tools"
                                            style="color: white"></i></a>
                                        @endif

                                        @if ((auth()->user()->level == 'admin' || auth()->user()->level == 'teknisi') &&
                                        $p->status == 'diproses')
                                        <a data-toggle="modal" data-target="#modal-nota{{$p->id}}"
                                            class="btn btn-success"><i class="fas fa-check"></i></a>
                                        @endif

                                        @if ((auth()->user()->level == 'admin' || auth()->user()->level == 'kasir') &&
                                        $p->status == 'dipesan')
                                        <a data-toggle="modal" id="updateAdmin" data-target="#modal-edit{{$p->id}}"
                                            class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('pesanan.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                        @endif
                                        @if ((auth()->user()->level == 'admin' || auth()->user()->level == 'kasir') &&
                                        $p->status == 'selesai')
                                        <a data-toggle="modal" id="pelunasan" data-target="#modal-pelunasan{{ $p->id }}"
                                            class="btn btn-success"><i class="fas fa-money-bill-wave-alt"></i></a>
                                        @endif
                                        @if ((auth()->user()->level == 'admin' || auth()->user()->level == 'kasir') &&
                                        $p->status == 'lunas')
                                         <a href="{{ route('nota.cetak', $p->id) }}" class="btn btn-default"><i
                                            class="fas fa-print"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-edit{{$p->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modal-judul">Edit data Pesanan
                                                    {{ $p->nama_pesanan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route ('pesanan.update', $p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nama_pesanan">Nama Pesanan</label>
                                                        <input type="text" class="form-control" name="nama_pesanan"
                                                            id="nama_pesanan" value="{{ $p->nama_pesanan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                                        <input type="text" class="form-control" name="nama_pelanggan"
                                                            id="nama_pelanggan" value="{{ $p->nama_pelanggan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat_pelanggan">Alamat Pelanggan</label>
                                                        <textarea class="form-control" name="alamat_pelanggan"
                                                            id="alamat_pelanggan">{{ $p->alamat_pelanggan }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_hp_pelanggan">No. HP Pelanggan</label>
                                                        <input type="text" class="form-control" name="no_hp_pelanggan"
                                                            id="no_hp_pelanggan" value="{{ $p->no_hp_pelanggan }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_barang">Nama Barang</label>
                                                        <input type="text" class="form-control" name="nama_barang"
                                                            id="nama_barang" value="{{ $p->nama_barang }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="level">Kategori</label>
                                                        <select class="form-control" name="id_kategori"
                                                            id="id_kategori">
                                                            @foreach ($kategori as $k)
                                                            <option {{ $k->id == $p->id_kategori  ? 'selected':'' }}
                                                                value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keluhan">Keluhan</label>
                                                        <textarea class="form-control" name="keluhan"
                                                            id="keluhan">{{ $p->keluhan }}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
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
                                                <h4 class="modal-title" id="modal-judul">Detail {{ $p->nama_pesanan }}
                                                </h4>
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
                                <div class="modal fade" id="modal-nota{{ $p->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi Penyelesaian Service
                                                    {{ $p->nama_pelanggan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('nota.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="id_pesanan">Id Pesanan</label>
                                                        <input type="text" readonly class="form-control"
                                                            name="id_pesanan" id="id_pesanan" value="{{ $p->id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                                        <p>{{ $p->nama_pelanggan }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="diagnosa">Diagnosa</label>
                                                        <textarea class="form-control" name="diagnosa" id="diagnosa"
                                                            placeholder="Masukkan hasil diagnosa"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="harga">Harga Total</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Rp</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="harga"
                                                                id="harga" placeholder="Masukkan Harga Total">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="modal-fix{{ $p->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi Perbaikan
                                                    {{ $p->nama_pesanan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('pesanan.fix', $p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="id_pesanan">Id Pesanan</label>
                                                        <input type="text" readonly class="form-control"
                                                            name="id_pesanan" id="id_pesanan" value="{{ $p->id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                                        <p>{{ $p->nama_pelanggan }}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="estimasi_selesai">Estimasi Penyelesaian</label>
                                                            <input type="datetime-local" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" max="{{ date('Y-m-d', strtotime('+1 Week')) }}T{{ date('H:i') }}" value="{{ date('Y-m-d', strtotime('+3 Days')) }}T{{ date('H:i') }}" class="form-control" name="estimasi_selesai"
                                                                id="estimasi_selesai" placeholder="Masukkan Harga Total">
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="modal-pelunasan{{ $p->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Pembayaran
                                                    {{ $p->nama_pelanggan }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('nota.pelunasan', $p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="id_pesanan">Id Pesanan</label>
                                                        <input type="text" readonly class="form-control"
                                                            name="id_pesanan" id="id_pesanan" value="{{ $p->id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nama_pelanggan">Nama Pelanggan</label>
                                                        <p>{{ $p->nama_pelanggan }}</p>
                                                    </div>
                                                    @if ($p->status == 'selesai')
                                                    <div class="form-group">
                                                        <label for="harga">Harga Total</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Rp</span>
                                                            </div>
                                                            <input readonly type="text" class="form-control" name="harga"
                                                                id="harga" value="{{ number_format($p->nota->harga, 0, ',', '.') }}">
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="nominal">Nominal Pembayaran</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Rp</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="nominal"
                                                                id="nominal" placeholder="Input Nominal Pembayaran">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
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
                @if (auth()->user()->level != 'teknisi')
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-register">
                    <i class="fas fa-plus"></i>&nbsp;Tambahkan Data Pesanan Baru</a>
                </button>
                @endif
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
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan"
                            placeholder="Masukkan Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="alamat_pelanggan">Alamat Pelanggan</label>
                        <textarea class="form-control" name="alamat_pelanggan" id="alamat_pelanggan"
                            placeholder="Masukkan Alamat Pelanggan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp_pelanggan">No. HP Pelanggan</label>
                        <input type="text" class="form-control" name="no_hp_pelanggan" id="no_hp_pelanggan"
                            placeholder="Masukkan No. HP Pelanggan">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                            placeholder="Masukkan Nama Barang">
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
                        <textarea class="form-control" name="keluhan" id="keluhan"
                            placeholder="Masukkan Keluhan"></textarea>
                    </div>
                    <input hidden type="text" name="status" id="status" value="dipesan">
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
