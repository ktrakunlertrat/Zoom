<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Container -->
<div class="min-h-screen p-4">

    <!-- Card -->
    <div class="bg-white/50 backdrop-blur-sm border border-black rounded-2xl 
            p-5 w-full max-w-6xl mx-auto shadow-lg 
            max-h-[80vh] mb-6">

        <form id="reserveForm" 
            action="<?= base_url('index.php/addzoom/update/'.$reserve->id) ?>"
            method="POST">

            <input type="hidden" name="id" value="<?= $reserve->id ?>">

            <!-- แบ่งซ้ายขวา -->
            <div class="flex gap-5 mb-5 items-start">

                <!-- ฝั่งซ้าย -->
                <div class="w-1/2 p-4 flex flex-col gap-3">

                    <h2 class="text-lg font-bold pb-2">
                        ข้อมูลผู้จอง
                    </h2>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">ชื่อ - นามสกุล</label>

                        <input type="text"
                            name="name"
                            value="<?= $reserve->name ?>"
                            class="border border-black rounded-lg px-2 py-1"
                            placeholder="ชื่อ - นามสกุล"
                            required>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">Email</label>

                        <input type="email"
                            name="email"
                            value="<?= $reserve->email ?>"
                            class="border border-black rounded-lg px-2 py-1"
                            placeholder="Email"
                            required>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">เบอร์โทร</label>

                        <input type="text"
                            name="phone_number"
                            value="<?= $reserve->phone_number ?>"
                            class="border border-black rounded-lg px-2 py-1"
                            placeholder="เบอร์โทร"
                            required>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">สังกัด</label>

                        <select name="affiliation"
                            class="border border-black rounded-lg px-2 py-1"
                            required>

                            <option value="" disabled selected>เลือก</option>

                            <option value="สลก." <?= $reserve->affiliation == 'สลก.' ? 'selected' : '' ?>>สลก.</option>
                            <option value="กปอ." <?= $reserve->affiliation == 'กปอ.' ? 'selected' : '' ?>>กปอ.</option>
                            <option value="กลก." <?= $reserve->affiliation == 'กลก.' ? 'selected' : '' ?>>กลก.</option>
                            <option value="กยป." <?= $reserve->affiliation == 'กยป.' ? 'selected' : '' ?>>กยป.</option>
                            <option value="กสร." <?= $reserve->affiliation == 'กสร.' ? 'selected' : '' ?>>กสร.</option>
                            <option value="ศปส." <?= $reserve->affiliation == 'ศปส.' ? 'selected' : '' ?>>ศปส.</option>
                            <option value="กจธ." <?= $reserve->affiliation == 'กจธ.' ? 'selected' : '' ?>>กจธ.</option>
                            <option value="กพร." <?= $reserve->affiliation == 'กพร.' ? 'selected' : '' ?>>กพร.</option>
                            <option value="ตส." <?= $reserve->affiliation == 'ตส.' ? 'selected' : '' ?>>ตส.</option>
                            <option value="กกม." <?= $reserve->affiliation == 'กกม.' ? 'selected' : '' ?>>กกม.</option>

                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">หัวข้อประชุม</label>

                        <input type="text"
                            name="meeting_topic"
                            value="<?= $reserve->meeting_topic ?>"
                            class="border border-black rounded-lg px-2 py-1"
                            placeholder="หัวข้อประชุม"
                            required>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-medium">ขนาดห้องประชุม Zoom</label>

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="room_size"
                                value="100"
                                <?= $reserve->room_size == '100' ? 'checked' : '' ?>>

                            <span>100 คน</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="room_size"
                                value="500"
                                <?= $reserve->room_size == '500' ? 'checked' : '' ?>>

                            <span>500 คน</span>
                        </label>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-medium">วัน เวลา เริ่มประชุม</label>

                        <div class="flex gap-3">
                            <input type="text"
                                id="start_date"
                                name="start_date"
                                value="<?= $reserve->start_date ?>"
                                placeholder="เลือกวัน"
                                class="border border-black rounded-lg px-2 py-1 w-full">

                            <input type="text"
                                id="start_time"
                                name="start_time"
                                value="<?= $reserve->start_time ?>"
                                placeholder="เลือกเวลา"
                                class="border border-black rounded-lg px-2 py-1 w-full">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-medium">วัน เวลา เลิกประชุม</label>

                        <div class="flex gap-3">
                            <input type="text"
                                id="end_date"
                                name="end_date"
                                value="<?= $reserve->end_date ?>"
                                placeholder="เลือกวัน"
                                class="border border-black rounded-lg px-2 py-1 w-full">

                            <input type="text"
                                id="end_time"
                                name="end_time"
                                value="<?= $reserve->end_time ?>"
                                placeholder="เลือกเวลา"
                                class="border border-black rounded-lg px-2 py-1 w-full">
                        </div>
                    </div>

                </div>

                <!-- ฝั่งขวา -->
                <div class="w-1/2 p-6 flex flex-col gap-5 h-full">

                    <h2 class="text-lg font-bold pb-2">
                        ข้อมูลห้อง Zoom
                    </h2>

                    <div class="flex flex-col">
                        <label class="mb-1 font-medium">
                            ห้อง Zoom
                        </label>

                        <input type="text"
                            value="<?= $reserve->zoom_number ?>"
                            class="border border-black rounded-lg px-2 py-1 bg-gray-100"
                            readonly>
                    </div>

                    <div class="flex flex-col flex-1">
                        <label class="mb-1 font-medium">รายละเอียด</label>

                        <textarea
                            name="details"
                            rows="12"
                            required
                            class="border border-black rounded-lg px-3 py-3 resize-none flex-1"><?= $reserve->details ?></textarea>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="flex justify-center gap-4 pt-4 mt-auto">

                        <a href="<?= base_url('index.php/request') ?>"
                            class="w-40 text-center bg-gray-400 text-white rounded-lg py-2 px-4 hover:bg-gray-500 transition">

                            ย้อนกลับ

                        </a>

                        <button type="submit"
                            class="w-40 bg-blue-500 text-white rounded-lg py-2 px-4 hover:bg-blue-600 transition">

                            บันทึก

                        </button>

                    </div>

                </div>

            </div>
        </form>

    </div>

</div>
</html>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr("#start_date", {
  dateFormat: "d/m/Y",
  defaultDate: document.getElementById("start_date").value
});

flatpickr("#end_date", {
  dateFormat: "d/m/Y",
  defaultDate: document.getElementById("end_date").value
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

function convertThaiDateToISO(thaiDate) {

    // รูปแบบ dd/mm/yyyy
    const parts = thaiDate.split('/');

    if(parts.length !== 3) return null;

    const day = parts[0];
    const month = parts[1];
    const year = parseInt(parts[2]) - 543;

    return `${year}-${month}-${day}`;
}

document.getElementById('reserveForm').addEventListener('submit', function(e){

    const startDateThai = document.getElementById('start_date').value;
    const endDateThai = document.getElementById('end_date').value;

    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;

    // เช็คค่าว่าง
    if(!startDateThai || !endDateThai || !startTime || !endTime){

        alert('กรุณาเลือกวันและเวลาให้ครบ');
        e.preventDefault();
        return;
    }

    // แปลง พ.ศ. -> ค.ศ.
    const startDate = convertThaiDateToISO(startDateThai);
    const endDate = convertThaiDateToISO(endDateThai);

    // รวมวัน + เวลา
    const startDateTime = new Date(startDate + 'T' + startTime);
    const endDateTime = new Date(endDate + 'T' + endTime);

    // เช็ควันเวลา
    if(startDateTime >= endDateTime){

        alert('วันเวลาเริ่มประชุม ต้องน้อยกว่าวันเวลาเลิกประชุม');
        e.preventDefault();
        return;
    }

});
</script>