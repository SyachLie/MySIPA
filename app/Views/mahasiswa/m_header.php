<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - Mahasiswa</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <h2>Mahasiswa</h2>
        <p style="text-align: center; font-size: 12px; color: #ccc; margin-bottom: 30px;">
            Selamat datang, <?php echo session()->get('nama_user'); ?>
        </p>
        
        <a href="<?php echo base_url('mahasiswa'); ?>">Dashboard</a>
        <a href="<?php echo base_url('mahasiswa/krs'); ?>">KRS (Rencana Studi)</a>
        <a href="<?php echo base_url('mahasiswa/khs'); ?>">KHS (Hasil Studi)</a>
        
        <a href="<?php echo base_url('auth/logout'); ?>" class="logout">Logout</a>

        <div class="sidebar-footer">
            <p>&copy; 2025 MySIPA</p>
        </div>
    </nav>

    <div class="main-content">
        <h1><?php echo $title; ?></h1>
        <hr><br>