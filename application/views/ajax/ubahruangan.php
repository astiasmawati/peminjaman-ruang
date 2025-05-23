    <?php foreach($ruangan as $r): ?>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><?php echo $r->merk; ?></h3>
            </div>
            <div class="card-body">
                <div class="image text-center">
                    <img src="<?= base_url('files/site/'.$r->image) ?>" width="120">
                </div>
                <form enctype="multipart/form-data" action="<?php echo base_url('admin/ubahruangan') ?>" method="POST">
                    <input type="hidden" id="id_perangkat" name="id_perangkat" value="<?php echo $r->id_perangkat ?>">
                    
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" id="perangkat" data-id_perangkat="<?php echo $r->id_perangkat ?>" onkeyup="return cekkoderuangan(event)" name="perangkat" class="form-control" value="<?php echo $r->perangkat ?>">
                        <span id="alertkoderuangan" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="merk" value="<?php echo $r->merk ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" value="<?php echo $r->stok ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <?php echo $r->image ?>
                        <label for="ubahgambaruangan" class="badge badge-primary">Ubah</label>
                        <input type="file" id="ubahgambaruangan" name="gambar" onchange="return getnamaruangan(event)" class="d-none">
                        <span id="gambarruanganbaru" class="text-danger"></span>
                    </div>
                    <div class="text-center">                        
                        <button type="submit" id="btnubahruangan" class="btn btn-primary ubahruangan">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>