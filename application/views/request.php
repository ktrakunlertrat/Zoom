<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="flex min-h-screen">

    <div class="flex flex-col flex-1 p-6">

        <div class="bg-white/50 backdrop-blur-sm border border-black rounded-xl p-6">

            <!-- หัวข้อ + ค้นหา -->
            <div class="flex flex-col gap-3 mb-4">

                <div class="flex justify-between items-center">

                    <h1 class="text-2xl font-bold">
                        รายการจองห้องประชุม
                    </h1>

                    <a href="<?= base_url('index.php/') ?>" 
                        class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">
                        หน้าแรก
                    </a>

                </div>

                <!-- ค้นหา -->
                <form method="GET" 
                    action="<?= base_url('index.php/request') ?>"
                    class="flex gap-2">

                    <input 
                        type="text"
                        name="keyword"
                        value="<?= $this->input->get('keyword') ?>"
                        placeholder="ค้นหาชื่อ..."
                        class="border border-black rounded-md px-3 py-2 w-72"
                    >

                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                        ค้นหา
                    </button>

                    <a href="<?= base_url('index.php/request') ?>"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        ล้าง
                    </a>

                </form>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border border-black text-sm">

                    <thead class="bg-gray-200">

                        <tr>
                            <th class="border border-black px-3 py-2">ลำดับ</th>
                            <th class="border border-black px-3 py-2">ชื่อ</th>
                            <th class="border border-black px-3 py-2">หัวข้อประชุม</th>
                            <th class="border border-black px-3 py-2">สังกัด</th>
                            <th class="border border-black px-3 py-2">ขนาดห้อง</th>
                            <th class="border border-black px-3 py-2">วันเริ่ม</th>
                            <th class="border border-black px-3 py-2">เวลาเริ่ม</th>
                            <th class="border border-black px-3 py-2">วันสิ้นสุด</th>
                            <th class="border border-black px-3 py-2">เวลาสิ้นสุด</th>
                            <th class="border border-black px-3 py-2">สถานะ</th>
                            <th class="border border-black px-3 py-2">เพิ่มห้องประชุม</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php if(!empty($reserve)): ?>

                        <?php $i = 1; ?>
                        <?php foreach($reserve as $row): ?>

                        <tr class="hover:bg-gray-100">

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $i++ ?>
                            </td>

                            <td class="border border-black px-3 py-2">
                                <?= $row->name ?>
                            </td>

                            <td class="border border-black px-3 py-2">
                                <?= $row->meeting_topic ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->affiliation ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->room_size ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->start_date ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->start_time ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->end_date ?>
                            </td>

                            <td class="border border-black px-3 py-2 text-center">
                                <?= $row->end_time ?>
                            </td>
                            <td class="border border-black px-3 py-2 text-center">

                                <?php if(empty($row->zoom_number)): ?>

                                    <span class="bg-red-500 text-white px-2 py-1 rounded-md text-xs">
                                        ยังไม่ได้เพิ่ม
                                    </span>

                                <?php else: ?>

                                    <span class="bg-green-500 text-white px-2 py-1 rounded-md text-xs">
                                        เพิ่มแล้ว
                                    </span>

                                <?php endif; ?>

                            </td>
                            <td class="border border-black px-3 py-2 text-center">

                                <a href="<?= base_url('index.php/request/add_zoom/'.$row->id) ?>"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">

                                    เพิ่ม

                                </a>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="9" class="border border-black px-3 py-4 text-center">
                                ไม่มีข้อมูล
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

                <div class="flex justify-center items-center gap-4 mt-4">

                    <!-- ปุ่มย้อนกลับ -->
                    <?php if($current_page > 1): ?>

                        <a href="<?= base_url('index.php/request?page='.($current_page - 1).'&keyword='.$keyword) ?>"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">

                            ย้อนกลับ

                        </a>

                    <?php endif; ?>

                    <!-- เลขหน้า -->
                    <span class="font-bold">
                        หน้า <?= $current_page ?> / <?= $total_pages ?>
                    </span>

                    <!-- ปุ่มถัดไป -->
                    <?php if($current_page < $total_pages): ?>

                        <a href="<?= base_url('index.php/request?page='.($current_page + 1).'&keyword='.$keyword) ?>"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">

                            ถัดไป

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>