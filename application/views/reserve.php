<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Container -->
<div class="flex min-h-screen">

    <!-- ปุ่มกลางจอ -->
    <div class="flex flex-col items-center justify-start flex-1 pt-6">
        <div class="bg-white/50 backdrop-blur-sm border border-black rounded-xl p-6 w-96">
            
            <form action="<?= base_url('index.php/reserve/save') ?>" 
                method="POST"
                class="flex flex-col gap-4">
                
                <div class="flex flex-col">
                    <label>ชื่อ - นามสกุล</label>
                    <input type="text" name="name" class="border border-black rounded-md px-2 py-1" placeholder="ชื่อ - นามสกุล" required>
                </div>

                <div class="flex flex-col">
                    <label>Email</label>
                    <input type="email" name="email" class="border border-black rounded-md px-2 py-1" placeholder="Email" required> 
                </div>

                <div class="flex flex-col">
                    <label>เบอร์โทร</label>
                    <input type="text" name="phone_number" class="border border-black rounded-md px-2 py-1" placeholder="เบอร์โทร" required>
                </div>

                <div class="flex flex-col">
                    <label>สังกัด</label>
                    <select name="affiliation" id="" class="border border-black rounded-md px-2 py-1" required>
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
                    <input type="text" name="meeting_topic" class="border border-black rounded-md px-2 py-1" placeholder="หัวข้อประชุม" required>
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

                <!-- วันเวลาเริ่มประชุม -->
                <div class="flex flex-col gap-2">
                    <label>วัน เวลา เริ่มประชุม</label>

                    <div class="flex items-center gap-2">
                        <input type="text" id="start_date" name="start_date"
                            placeholder="เลือกวัน"
                            class="border border-black rounded-md px-2 py-1 w-full">

                        <input type="text" id="start_time" name="start_time"
                            placeholder="เลือกเวลา"
                            class="border border-black rounded-md px-2 py-1 w-full">
                    </div>
                </div>

                <!-- วันเวลาเลิกประชุม -->
                <div class="flex flex-col gap-2">
                    <label>วัน เวลา เลิกประชุม</label>

                    <div class="flex items-center gap-2">
                        <input type="text" id="end_date" name="end_date"
                            placeholder="เลือกวัน"
                            class="border border-black rounded-md px-2 py-1 w-full">

                        <input type="text" id="end_time" name="end_time"
                            placeholder="เลือกเวลา"
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

</div>
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

flatpickr("#start_time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

flatpickr("#end_time", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
</script>