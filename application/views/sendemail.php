<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Container -->
<div class="min-h-screen p-4">

    <!-- Card -->
    <div class="bg-white/50 backdrop-blur-sm border border-black rounded-2xl 
            p-6 w-full max-w-6xl mx-auto shadow-lg
            max-h-[90vh] overflow-y-auto">

        <form action="<?= base_url('index.php/sendemail/send_email/'.$reserve->id) ?>" 
                method="POST"
                enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $reserve->id ?>">

            <div class="flex justify-center">

                <!-- Form -->
                <div class="w-full max-w-5xl flex flex-col gap-4">

                    <!-- Header + Button -->
                    <div class="flex items-center justify-between mb-4">

                        <!-- ปุ่มย้อนกลับ -->
                        <a href="<?= base_url('index.php/request') ?>"
                            class="bg-gray-400 text-white rounded-xl 
                            py-3 px-6 hover:bg-gray-500 transition">

                            ย้อนกลับ

                        </a>

                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-center flex-1">
                            ส่งอีเมล์
                        </h2>

                        <!-- ปุ่มส่ง -->
                        <button type="submit"
                            class="bg-blue-500 text-white rounded-xl 
                            py-3 px-6 hover:bg-blue-600 transition">

                            ส่งอีเมล์

                        </button>

                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label class="mb-1 font-medium text-gray-700">
                            ถึง
                        </label>

                        <input type="email"
                            name="email"
                            value="<?= $reserve->email ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 
                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Subject -->
                    <div class="flex flex-col">
                        <label class="mb-1 font-medium text-gray-700">
                            Subject
                        </label>

                        <input type="text"
                            name="subject"
                            value="Link ห้องประชุม วันที่ <?= $reserve->start_date ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 
                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Detail -->
                    <div class="flex flex-col">
                        <label class="mb-2 font-medium text-gray-700">
                            รายละเอียด
                        </label>

                        <textarea
                            name="details"
                            rows="10"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 
                            focus:outline-none focus:ring-2 focus:ring-blue-400"><?= 
"ชื่อผู้จอง : {$reserve->name} , สังกัด {$reserve->affiliation} , Tel {$reserve->phone_number} , {$reserve->email}

ลิงค์ห้องสำหรับการประชุม วันที่ {$reserve->start_date} เวลา {$reserve->start_time} - {$reserve->end_time} (เปิดห้องได้ 15 นาที  ก่อนการประชุม)
Host Key : {ใส่ Host Key} (สำหรับโฮสเท่านั้น)

{$reserve->details}"
?></textarea>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-2 font-medium text-gray-700">
                            แนบไฟล์
                        </label>

                        <input type="file"
                            name="attachments[]"
                            multiple
                            class="border border-gray-300 rounded-xl px-4 py-3 bg-white">
                    </div>

                </div>

            </div>
        </form>

    </div>

</div>
</html>

<style>
    .ck-editor__editable_inline {
        height: 45vh;
        min-height: 250px;
        max-height: 500px;
        overflow-y: auto !important;
    }

    .ck-editor {
        width: 100%;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>