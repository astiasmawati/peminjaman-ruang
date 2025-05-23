<?php
$peminjaman = $this->db->query("SELECT * FROM peminjaman INNER JOIN user, ruangan WHERE peminjaman.id_user=user.id_user AND peminjaman.id_perangkat=ruangan.id_perangkat AND peminjaman.status_peminjaman!=2 ORDER BY tanggal ASC")->result();
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?= $root; ?></a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header text-center">
                <h2>Request Peminjaman</h2>
            </div>
            <div class="card-body">
                <?php echo $this->session->flashdata('message') ?>
                <div class="table-responsive">
                    <table id="tabel" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>User</th>
                                <th>Perangkat</th>
                                <th>Stok</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Keterangan Peminjaman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($peminjaman as $q) : ?>
															<tr>
																	<td><?php echo $no++; ?></td>
																	<td><?php echo $q->username; ?></td>
																	<td><?php echo $q->merk; ?></td>
																	<td><?php echo $q->stok; ?></td>
																	<td><?php $date = date_create($q->tgl);
																	echo date_format($date, 'd/m /Y'); ?>
																	</td>
																	<td><?php $date = date_create($q->tanggal);
																	echo date_format($date, 'd/m /Y'); ?>
																	</td>
																	<td><?php echo $q->keterangan; ?></td>
																	<td>
																		<?php if ($q->status_peminjaman == 0) { ?>
																			<a href="<?php echo base_url('admin/accrequest/' . $q->id_peminjaman) ?>" onclick="return confirm('Terima Request?')" class="btn btn-primary btn-sm">Terima Request</a>
																			<a href="<?php echo base_url('admin/disaccrequest/' . $q->id_peminjaman) ?>" onclick="return confirm('Tolak Request?')" class="btn btn-danger btn-sm">Tolak Request</a>
																		<?php } elseif ($q->status_peminjaman == 1) { ?>
																			<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#kembalipinjam<?= $q->id_peminjaman ?>">Kembali</button>
																			<div class="modal fade" id="kembalipinjam<?= $q->id_peminjaman ?>">
																				<div class="modal-dialog modal-md">
																						<div class="modal-content">
																								<form role="form" action="<?= base_url('admin/pengembalian') ?>" method="POST" enctype="multipart/form-data">
																										<div class="modal-header">
																												<h4 class="modal-title">Pengembalian</h4>
																												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																														<span aria-hidden="true">&times;</span>
																												</button>
																										</div>
																										<div class="modal-body">
																											<div class="card-body">
																													<input type="hidden" name="id_peminjaman" value="<?= $q->id_peminjaman ?>">
																													<div class="form-group">
																															<label>Denda (isikan 0 jika tidak denda)</label>
																															<input type="text" name="denda" value="0" class="form-control" />
																													</div>
																													<div class="form-group">
																															<label>Keterangan Admin</label>
																															<textarea name="ket_admin" class="form-control"></textarea>
																													</div>
																											</div>
																										</div>
																										<div class="modal-footer justify-content-between">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
																												<button type="submit" name="tambah" class="btn btn-primary pinjam">Kembali</button>
																										</div>
																								</form>
																						</div>
																						<!-- modal pinjam ruangan -->
																						<!-- /.modal-content -->
																				</div>
																				<!-- /.modal-dialog -->
																			</div>

																		<?php } ?>
																	</td>
															</tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
