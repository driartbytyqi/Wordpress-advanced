<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>
<body>

    <header>
        <div class="navbar">
            <div class="site-title">
                <h1 style="margin:0; font-size:2rem; font-weight:700; letter-spacing:1px; color:#fff;"><?php bloginfo('name'); ?></h1>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                    <li><a href="<?php echo home_url('/aboutus'); ?>">About Us</a></li>
                    <li><a href="<?php echo home_url('/rateus'); ?>">Rate Us</a></li>
                    <li><a href="<?php echo home_url('/profile'); ?>">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
