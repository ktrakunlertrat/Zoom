<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Header -->
 <div class="flex items-center justify-between bg-gray-300 backdrop-blur-md shadow-lg rounded-2xl p-6">

    <!-- ซ้าย -->
    <div class="flex items-center gap-5">

        <!-- Logo -->
        <a href="<?= base_url('index.php/') ?>" 
            class="shrink-0 hover:scale-105 transition duration-200">

            <img 
                src="<?= base_url('assets/images/dcce.png') ?>" 
                alt="DCCE Logo"
                class="w-24 h-24 object-contain drop-shadow-md cursor-pointer"
            >

        </a>

        <!-- Text -->
        <div>
            <h1 class="text-3xl md:text-4xl text-black leading-tight">
                    กรมการเปลี่ยนแปลงสภาพภูมิอากาศและสิ่งแวดล้อม
            </h1>

            <p class="text-black text-sm md:text-xl tracking-wide">
                Department of Climate Change and Environment
            </p>
        </div>

    </div>

    <!-- ขวา -->
    <div>

        <?php if($this->session->userdata('logged_in')): ?>

            <a href="<?= base_url('index.php/login/logout') ?>" 
                class="border border-black rounded-lg px-6 py-3 text-lg text-black
                    hover:bg-red-600 hover:text-white transition duration-200">
                ออกจากระบบ
            </a>

        <?php else: ?>

            <a href="<?= base_url('index.php/login') ?>" 
                class="border border-black rounded-lg px-6 py-3 text-lg text-black
                    hover:bg-gray-700 hover:text-white transition duration-200">
                สำหรับผู้ดูแล
            </a>

        <?php endif; ?>

    </div>

</div>