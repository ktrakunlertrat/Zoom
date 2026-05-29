<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Container -->
<div class="flex min-h-screen">

    <!-- ฝั่งซ้าย -->
    <div class="w-full md:w-1/2 flex flex-col justify-start items-center px-10 gap-5 pt-24">

        <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">
            ระบบจองห้องประชุม Zoom
        </h1>

        <a href="<?= base_url('index.php/reserve') ?>" 
           class="w-72 text-center border-2 border-black bg-gray-300 
                  rounded-md text-black text-lg p-3
                  hover:bg-gray-700 hover:text-white hover:scale-105 
                  transition duration-200">
            แบบฟอร์มจองห้องประชุมออนไลน์
        </a>

        <p class="text-red-600 text-sm md:text-base font-semibold text-center -mt-2">
            *กรุณาตรวจสอบตารางจองก่อนและหลังทำการจองทุกครั้ง
        </p>

        <?php if($this->session->userdata('logged_in')): ?>

            <div class="relative inline-block">

                <a href="<?= base_url('index.php/request') ?>" 
                    class="w-72 block text-center border-2 border-black bg-gray-300 
                            rounded-md text-black text-lg p-3
                            hover:bg-gray-700 hover:text-white hover:scale-105 
                            transition duration-200">

                        คำขอจองห้องประชุมออนไลน์
                </a>

                <?php if($unread_count > 0): ?>

                    <span class="absolute -top-2 -right-2 
                        bg-red-500 text-white text-sm font-bold
                        rounded-full min-w-[32px] h-8 px-2
                        flex items-center justify-center shadow-lg">

                        <?= $unread_count ?>

                    </span>

                <?php endif; ?>

            </div>

            <a href="<?= base_url('index.php/dashboard') ?>" 
            class="w-72 text-center border-2 border-black bg-gray-300 
                    rounded-md text-black text-lg p-3
                    hover:bg-gray-700 hover:text-white hover:scale-105 
                    transition duration-200">
                Dashboard
            </a>

        <?php endif; ?>

        <a href="<?= base_url('index.php/calendar') ?>" 
           class="w-72 text-center border-2 border-black bg-gray-300 
                  rounded-md text-black text-lg p-3
                  hover:bg-gray-700 hover:text-white hover:scale-105 
                  transition duration-200">
            ตารางจองห้องประชุมออนไลน์
        </a>

    </div>

    <!-- ฝั่งขวา -->
    <div class="hidden md:flex w-1/2 items-start justify-center pt-16">
        <img src="<?= base_url('assets/images/video_conference.png') ?>" 
             alt="Video Conference"
             class="w-full">
    </div>

</div>