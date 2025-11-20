<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?> - Dosen</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <h2>Dosen</h2>
        <p style="text-align: center; font-size: 12px; color: #ccc; margin-bottom: 30px;">
            Selamat datang, <?php echo session()->get('nama_user'); ?>
        </p>
        
        <a href="<?php echo base_url('dosen'); ?>">Jadwal Mengajar</a>
        <a href="<?php echo base_url('auth/logout'); ?>" class="logout">Logout</a>

        <div class="sidebar-footer">
            <p>&copy; 2025 MySIPA</p>
        </div>
    </nav>

    <div class="main-content">
        <h1><?php echo $title; ?></h1>
        <hr><br>