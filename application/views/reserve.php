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
                    <label>ชื่อ - นามสกุล</label>
                    <input type="text" class="border border-black rounded-md px-2 py-1">
                </div>

                <div class="flex flex-col">
                    <label>Email</label>
                    <input type="email" class="border border-black rounded-md px-2 py-1">
                </div>

                <div class="flex flex-col">
                    <label>เบอร์โทร</label>
                    <input type="text" class="border border-black rounded-md px-2 py-1">
                </div>

                <div class="flex flex-col">
                    <label>สังกัด</label>
                    <select name="" id="" class="border border-black rounded-md px-2 py-1">
                        <option value="" disabled selected>เลือก</option>
                        <option value="สลก.">สลก.</option>
                        <option value="กปอ.">กปอ.</option>
                        <option value="กลก.">กลก.</option>
                        <option value="กยป.">กยป.</option>
                        <option value="กสร.">กสร.</option>
                        <option value="ศปส.">ศปส.</option>
                        <option value="กจธ.">กจธ.</option>
                        <option value="กพร.">กพร.</option>
                        <option value="ตส.">ตส.</option>
                        <option value="กกม.">กกม.</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label>หัวข้อประชุม</label>
                    <input type="text" class="border border-black rounded-md px-2 py-1">
                </div>

                <div class="flex flex-col">
                    <label class="mb-2">ขนาดห้องประชุม Zoom</label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="room_size" value="100">
                        <span>100 คน</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="room_size" value="500">
                        <span>500 คน</span>
                    </label>
                </div>

                <div class="flex flex-col">
                    <label class="mb-2">วัน เริ่มประชุม - เลิกประชุม</label>
                    
                    <div class="flex items-center gap-2">
                        <input type="text" id="start_date" placeholder="เลือกวันเริ่ม" 
                            class="border border-black rounded-md px-2 py-1 w-full">

                        <span>ถึง</span>

                        <input type="text" id="end_date" placeholder="เลือกวันสิ้นสุด" 
                            class="border border-black rounded-md px-2 py-1 w-full">
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="mb-2">เวลา เริ่มประชุม - เลิกประชุม</label>

                    <div class="flex items-center gap-2">
                        <input type="time" id="start_time"
                            class="border border-black rounded-md px-2 py-1 w-full">

                        <span>ถึง</span>

                        <input type="time" id="end_time"
                            class="border border-black rounded-md px-2 py-1 w-full">
                    </div>
                </div>

                <!-- ปุ่ม -->
                <div class="flex gap-2">
                    <a href="<?= base_url('index.php/') ?>" 
                    class="w-1/2 text-center bg-gray-400 text-white rounded-md py-2 hover:bg-gray-500">
                    ย้อนกลับ
                    </a>

                    <button type="submit" 
                            class="w-1/2 bg-blue-500 text-white rounded-md py-2 hover:bg-blue-600">
                    ส่ง
                    </button>
                </div>

                </form>

            </div>
        </div>

</body>
</html>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
function toThaiYear(date) {
  const year = date.getFullYear() + 543;
  const month = ("0" + (date.getMonth() + 1)).slice(-2);
  const day = ("0" + date.getDate()).slice(-2);
  return `${day}/${month}/${year}`;
}

flatpickr("#start_date", {
  dateFormat: "Y-m-d",
  onChange: function(selectedDates, dateStr, instance) {
    instance.input.value = toThaiYear(selectedDates[0]);
  }
});

flatpickr("#end_date", {
  dateFormat: "Y-m-d",
  onChange: function(selectedDates, dateStr, instance) {
    instance.input.value = toThaiYear(selectedDates[0]);
  }
});
</script>