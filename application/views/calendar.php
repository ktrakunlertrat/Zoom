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

        <div class="flex flex-1 gap-4 mt-4">

            <!-- 📅 ปฏิทิน -->
            <div class="bg-white backdrop-blur-sm border border-black rounded-xl p-4 w-2/3 h-1/5">
                <div id="calendar"></div>
            </div>

            <!-- 📝 ฟอร์ม -->
            <div class="bg-white/80 backdrop-blur-sm border border-black rounded-xl p-4 w-1/3 h-1/5">
                <h2 class="text-lg mb-2">เพิ่มการจอง</h2>

                <p id="selected_date" class="mb-2 text-blue-600"></p>

                <input type="text" id="event_title" placeholder="หัวข้อ"
                class="border w-full mb-2 px-2 py-1 rounded-md">

                <input type="text" id="event_title" placeholder="ชื่อ - นามสกุล"
                class="border w-full mb-2 px-2 py-1 rounded-md">

                <input type="text" id="event_title" placeholder="Email"
                class="border w-full mb-2 px-2 py-1 rounded-md">

                <input type="text" id="event_title" placeholder="เบอร์โทร"
                class="border w-full mb-2 px-2 py-1 rounded-md">

                <textarea id="event_desc" placeholder="รายละเอียด"
                class="border w-full mb-2 px-2 py-1 rounded-md"></textarea>

                <input type="time" id="event_time"
                class="border w-full mb-4 px-2 py-1 rounded-md">

                <button onclick="saveEvent()"
                class="bg-blue-500 text-white w-full py-2 rounded-md">
                บันทึก
                </button>
            </div>

        </div>

</body>
</html>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
let selectedDate = null;

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');

  window.calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 'auto',
    locale: 'th',

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    // 👉 คลิกวันที่ → แสดงวันที่ในฟอร์ม
    dateClick: function(info) {
    selectedDate = info.dateStr;

    const date = new Date(info.dateStr);

    const day = date.getDate();
    const month = date.toLocaleString('th-TH', { month: 'long' });
    const year = date.getFullYear() + 543;

    document.getElementById('selected_date').innerText =
        'วันที่: ' + day + ' ' + month + ' ' + year;
    },

    // 👉 คลิก event → แสดงรายละเอียด
    eventClick: function(info) {
      document.getElementById('event_title').value = info.event.title;
      document.getElementById('event_desc').value = info.event.extendedProps.description || '';
      document.getElementById('event_time').value = info.event.extendedProps.time || '';
      selectedDate = info.event.startStr;
    },

    eventDidMount: function(info) {
      if (info.event.extendedProps.description) {
        info.el.title = info.event.extendedProps.description;
      }
    },

    events: []
  });

  calendar.render();
});

// 👉 บันทึก
function saveEvent() {
  const title = document.getElementById('event_title').value;
  const desc = document.getElementById('event_desc').value;
  const time = document.getElementById('event_time').value;

  if (!title || !selectedDate) {
    alert('กรุณาเลือกวันที่และกรอกหัวข้อ');
    return;
  }

  calendar.addEvent({
    title: title + (time ? ' (' + time + ')' : ''),
    start: selectedDate,
    allDay: true,
    extendedProps: {
      description: desc,
      time: time
    }
  });

  // reset
  document.getElementById('event_title').value = '';
  document.getElementById('event_desc').value = '';
  document.getElementById('event_time').value = '';
}
</script>