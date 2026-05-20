<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Container -->
<div class="flex min-h-screen">

    <!-- ปุ่มกลางจอ -->
    <div class="flex flex-col items-center justify-center flex-1">
        <!-- Login Card -->
        <div class="relative w-full max-w-md bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <img src="<?= base_url('assets/images/dcce.png') ?>" 
                    alt="DCCE Logo" 
                    class="w-24 h-24 object-contain">
            </div>

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-bold text-center text-[#3a4b5c] mb-6">
                เข้าสู่ระบบ
            </h1>

            <!-- Form -->
            <form action="<?= base_url('index.php/login/check_login') ?>" method="POST" class="flex flex-col gap-4">

                <!-- Username -->
                <div class="flex flex-col">
                    <label class="font-semibold text-gray-700 mb-1">
                        Username
                    </label>

                        <input type="text" name="username"
                    placeholder="Username"
                        class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#3a4b5c]">
                </div>

                <!-- Password -->
                <div class="flex flex-col">
                    <label class="font-semibold text-gray-700 mb-1">
                        Password
                    </label>

                    <input type="password" name="password"
                        placeholder="Password"
                        class="border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#3a4b5c]">
                </div>

                <!-- Button -->
                <button type="submit"
                        class="bg-gray-500 hover:bg-[#3a4b5c] text-white font-bold py-3 rounded-lg transition duration-300 mt-2">
                    เข้าสู่ระบบ
                </button>

                <a href="<?= base_url('index.php/welcome') ?>"
                    class="border-2 border-[#3a4b5c] text-[#3a4b5c] hover:bg-[#3a4b5c] hover:text-white font-bold py-3 rounded-lg transition duration-300 mt-2 text-center">
                    ย้อนกลับ
                </a>

            </form>

        </div>
    </div>
</div>