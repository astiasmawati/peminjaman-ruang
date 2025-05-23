<?php
function base_url($path = '')
{
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
  $domain = $_SERVER['HTTP_HOST'];
  $basePath = '/peminjaman-ruang/';

  return $protocol . $domain . $basePath . ltrim($path, '/');
}

function isActive($pages)
{
  $current = basename($_SERVER['PHP_SELF']);
  return in_array($current, (array) $pages) ? 'active' : '';
}

function checkRole($allowedRoles = [])
{
  if (!isset($_SESSION['user']['role'])) {
    return false;
  }

  if (!is_array($allowedRoles)) {
    $allowedRoles = [$allowedRoles];
  }

  return in_array($_SESSION['user']['role'], $allowedRoles);
}
