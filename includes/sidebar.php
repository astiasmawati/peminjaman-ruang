<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.php">Peminjaman Ruang</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.php">PR</a>
    </div>
    <ul class="sidebar-menu">
      <li class="<?= isActive('dashboard.php') ?>"><a class="nav-link" href="<?= base_url('dashboard.php') ?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

      <?php if (checkRole('Admin')):?>
      <li class="dropdown <?= isActive(['dosen.php', 'ruang.php', 'mahasiswa.php', 'tu.php']) ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Data Master</span></a>
        <ul class="dropdown-menu">
          <li class="<?= isActive('ruang.php') ?>"><a class="nav-link" href="<?= base_url('admin/ruang.php') ?>">Data Ruang</a></li>
          <li class="<?= isActive('dosen.php') ?>"><a class="nav-link" href="<?= base_url('admin/dosen.php') ?>">Data Dosen</a></li>
          <li class="<?= isActive('mahasiswa.php') ?>"><a class="nav-link" href="<?= base_url('admin/mahasiswa.php') ?>">Data Mahasiswa</a></li>
          <li class="<?= isActive('tu.php') ?>"><a class="nav-link" href="<?= base_url('admin/tu.php') ?>">Data Tata Usaha</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <li class="<?= isActive('peminjaman.php') ?>"><a class="nav-link" href="<?= base_url('peminjaman.php') ?>"><i class="far fa-file-alt"></i> <span>Daftar Peminjaman</span></a></li>
    </ul>
  </aside>
</div>