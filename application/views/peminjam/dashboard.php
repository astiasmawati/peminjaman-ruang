<!-- reset jadwal -->
<?php
$jadwal = $this->db->query("SELECT * FROM jadwal INNER JOIN peminjaman on jadwal.id_peminjaman=peminjaman.id_peminjaman INNER JOIN user on peminjaman.id_user=user.id_user INNER JOIN ruangan on peminjaman.id_perangkat = ruangan.id_perangkat AND status_jadwal!=3")->result();
foreach ($jadwal as $q) :
  // atur jadwal
  $nowtime = strtotime(date('H:i:s')) + strtotime(date('Y-m-d'));
  $dbstart = strtotime($q->jam_mulai) + strtotime($q->tanggal);
  $dbend = strtotime($q->jam_berakhir) + strtotime($q->tanggal);
  $id_jadwal = $q->id_jadwal;
  if ($dbend < $nowtime) {
    $this->db->update('ruangan', ['status_perangkat' => 'Nganggur'], ['id_perangkat' => $q->id_perangkat]);
    $this->db->update('jadwal', ['status_jadwal' => 3], ['id_jadwal' => $id_jadwal]);
  } elseif ($nowtime >= $dbstart and $nowtime <= $dbend) {
    $this->db->update('ruangan', ['status_perangkat' => 'Dipakai'], ['id_perangkat' => $q->id_perangkat]);
    $this->db->update('jadwal', ['status_jadwal' => 1], ['id_jadwal' => $id_jadwal]);
  }
endforeach;
?>

<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index.php" class="navbar-brand">

        <span class="brand-text font-weight-light">pinjams</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?php echo base_url('peminjam') ?>" class="nav-link">Beranda</a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('peminjam/jadwal') ?>" class="nav-link">Jadwal</a>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a href="#" data-toggle="modal" data-target="#logout" class="btn btn-danger btn-flat"><i class="fas fa-power-off"></i>&nbsp;&nbsp;Keluar</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Perangkat</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Beranda</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="row">
          <?php foreach ($ruangan as $r) : ?>
            <div class="col-md-4">
              <div class="card card-success">
                <div class="card-header">
                  <!-- menampilkan nama ruangan pada card -->
                  <h3 class="card-title"><?= $r->perangkat ?> - <?php echo $r->merk; ?></h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body text-center">
                  <img src="files/site/<?= ($r->image) ?>" width="200"><br><br>
                  Stok : <?php echo $r->stok; ?><br><br>
                  <?php 
									if ($r->stok==0) { ?>
									<p>STOK HABIS</p>
									<button class="btn btn-primary" data-id_perangkat="<?= $r->id_perangkat ?>" data-toggle="modal" data-target="#pinjam" disabled>Pinjam</button>
									<?php } else {
										$status0 = $this->db->query('SELECT * FROM peminjaman INNER JOIN ruangan on peminjaman.id_perangkat=ruangan.id_perangkat WHERE peminjaman.id_user=' . $user . ' AND ruangan.id_perangkat=' . $r->id_perangkat . ' AND status_peminjaman=0')->row_array();
										$status1 = $this->db->query('SELECT * FROM peminjaman INNER JOIN ruangan on peminjaman.id_perangkat=ruangan.id_perangkat WHERE peminjaman.id_user=' . $user . ' AND ruangan.id_perangkat=' . $r->id_perangkat . ' AND status_peminjaman=1')->row_array();
										if ($status0) {
									?>
										<p>Menunggu konfirmasi</p>
										<button class="btn btn-info" data-toggle="modal" data-target="#pinjam" disabled="">Menunggu konfirmasi</button>
                    <a href="<?= base_url('peminjam/batalpinjam/' . $user . '/' . $r->id_perangkat) ?>" class="btn btn-danger" onclick="return confirm('Batalkan peminjaman?')" title="Batalkan peminjaman"><i class="fas fa-times"></i></a>
									<?php
										}
                  	elseif ($status1) {
									?>
										<p>Sedang Berlangsung</p>
										<button class="btn btn-primary" data-id_perangkat="<?= $r->id_perangkat ?>" data-toggle="modal" data-target="#pinjam" disabled>Pinjam</button>
									<?php
										} else {
									?>
										<p>Silakan Pinjam</p>
										<button class="btn btn-primary" data-id_perangkat="<?= $r->id_perangkat ?>" data-toggle="modal" data-target="#pinjam<?= $r->id_perangkat ?>">Pinjam</button>
									<?php
										}
                  }	
									?>
                </div>
              </div>
              <!-- modal pinjam ruangan -->
							<div class="modal fade" id="pinjam<?= $r->id_perangkat ?>">
								<div class="modal-dialog modal-md">
										<div class="modal-content">
												<form role="form" action="<?= base_url('peminjam/pinjam') ?>" method="POST" enctype="multipart/form-data">
														<div class="modal-header">
																<h4 class="modal-title">Pinjam perangkat</h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																</button>
														</div>
														<div class="modal-body">
															<div class="card-body">
																	<input type="hidden" name="id_user" value="<?= isset($user) ? $user : '' ?>">
																	<input type="hidden" name="username" value="<?= isset($username) ? $username : '' ?>">
																	<div class="form-group">
																			<label>Perangkat</label>
																			<input type="hidden" name="id_perangkat" value="<?= $r->id_perangkat ?>" />
																			<input type="text" name="nama_perangkat" value="<?= $r->perangkat ?> - <?= $r->merk ?>"  class="form-control" readonly />
																	</div>
																	<div class="form-group">
																			<input type="date" id="tgl" name="tgl" class="form-control verifydate" value="<?php echo date('Y-m-d', time()); ?>" hidden>
																	</div>
																	<div class="form-group">
																			<label>Tanggal Pengembalian</label>
																			<input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo date('Y-m-d', time()); ?>">
																	</div>
																	<div class="form-group">
																			<label>Keterangan Peminjaman</label>
																			<select name="keterangan" id="keterangan" class="form-control">
																					<option value="Tugas">Tugas</option>
																					<option value="Praktik">Praktik</option>
																					<option value="Pengambilan Nilai">Pengambilan Nilai</option>
																			</select>
																	</div>
															</div>
														</div>
														<div class="modal-footer justify-content-between">
																<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
																<button type="submit" name="tambah" class="btn btn-primary pinjam">Pinjam</button>
														</div>
												</form>
										</div>
										<!-- modal pinjam ruangan -->
										<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
              <!-- /.card -->
            </div>
          <?php endforeach; ?>

          <!-- FITUR BOOKING -->

          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
  </div>
  <!-- ./wrapper -->
