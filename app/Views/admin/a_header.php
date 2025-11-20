<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - Admin SIPA</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <h2>Admin Panel</h2>
        
        <a href="<?php echo base_url('admin'); ?>">Dashboard</a>
        <a href="<?php echo base_url('admin/mahasiswa'); ?>">Data Mahasiswa</a>
        <a href="<?php echo base_url('admin/dosen'); ?>">Data Dosen</a>
        <a href="<?php echo base_url('admin/mata_kuliah'); ?>">Mata Kuliah</a>
        <a href="<?php echo base_url('admin/ruangan'); ?>">Ruangan</a>
        <a href="<?php echo base_url('admin/jadwal'); ?>">Jadwal Kuliah</a>
        
        <a href="<?php echo base_url('auth/logout'); ?>" class="logout">Logout</a>

        <div class="sidebar-footer">
            <p>&copy; 2025 MySIPA</p>
            <p style="font-size: 10px;">Sistem Informasi Akademik</p>
        </div>
        
    </nav> <div class="main-content">
        <h1><?php echo $title; ?></h1>
        <hr><br>