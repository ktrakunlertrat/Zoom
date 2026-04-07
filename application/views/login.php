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
        <div class="flex flex-col items-center justify-center flex-1">
            <div class="bg-white/50 backdrop-blur-sm border border-black rounded-xl p-6 w-96">
            
                <form class="flex flex-col gap-4">
                
                <div class="flex flex-col">
                    <label>Username</label>
                    <input type="text" class="border border-black rounded-md px-2 py-1">
                </div>

                <div class="flex flex-col">
                    <label>Password</label>
                    <input type="password" class="border border-black rounded-md px-2 py-1">
                </div>

                <!-- ปุ่ม -->
                <div class="flex gap-2">
                    <a href="<?= base_url('index.php/') ?>" 
                    class="w-1/2 text-center bg-gray-400 text-white rounded-md py-2 hover:bg-gray-500">
                    ย้อนกลับ
                    </a>

                    <button type="submit" 
                            class="w-1/2 bg-blue-500 text-white rounded-md py-2 hover:bg-blue-600">
                    เข้าสู่ระบบ
                    </button>
                </div>

                </form>

            </div>
        </div>

</body>
</html>