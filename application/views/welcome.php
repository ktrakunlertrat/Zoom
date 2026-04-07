<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<link href="<?= base_url('assets/css/output.css') ?>" rel="stylesheet">

<body class="bg-cover bg-center min-h-screen m-4 flex flex-col" 
      style="background-image: url('<?= base_url('assets/images/bg.jpg') ?>')">

      <!-- Header -->
      <div class="flex items-center gap-4">
            <img src="<?= base_url('assets/images/dcce.png') ?>" width="100">
            <p class="text-5xl">ระบบจองห้องประชุม Zoom</p>
      </div>

      <!-- ปุ่มกลางจอ -->
      <div class="flex flex-col items-center justify-center flex-1 gap-4">

            <a href="<?= base_url('index.php/reserve') ?>" class="w-64 text-center border-2 border-black bg-green-600 
                        rounded-md text-white text-2xl p-3
                        hover:bg-green-700 hover:scale-105 
                        transition duration-200">
                  จองห้องประชุม Zoom
            </a>

            <a href="<?= base_url('index.php/calendar') ?>" class="w-64 text-center border-2 border-black bg-green-600 
                        rounded-md text-white text-2xl p-3
                        hover:bg-green-700 hover:scale-105 
                        transition duration-200">
                  ปฏิทิน
            </a>

            <a href="<?= base_url('index.php/login') ?>" class="w-64 text-center border-2 border-black bg-green-600 
                        rounded-md text-white text-2xl p-3
                        hover:bg-green-700 hover:scale-105 
                        transition duration-200">
                  เข้าสู่ระบบ
            </a>

      </div>

</body>
</html>