<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Cart</title>

  <link rel="stylesheet" href="<?php echo base_url('plugins/font.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('plugins/custom.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('dist/css/adminlte.min.css') ?>">

  <link rel='stylesheet' href='<?php echo base_url("dist/css/sweet-alert.css")?>' type='text/css' media='all'/>
</head>
<input type="hidden" id="base_path" name="base" value="<?php echo base_url(); ?>" >
<body class="hold-transition sidebar-mini">
  
<div class="wrapper">
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="<?= base_url() ?>" class="nav-link active">
              <i class="nav-icon far fa-plus-square"></i>
              <p>Cart Hub</p>
            </a>
          </li>

          <li class="nav-item menu-closed">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Master Directory
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('Mycart/product') ?>" class="nav-link active">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Products details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('Mycart/discount_details') ?>" class="nav-link active">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Discount details</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>