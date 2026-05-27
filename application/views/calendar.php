<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<link href="<?= base_url('assets/css/output.css') ?>" rel="stylesheet">

<body class="bg-cover bg-center min-h-screen m-4 flex flex-col">

<!-- Layout -->
<div class="flex flex-col flex-1 mt-4 gap-2">
  <div class="bg-white backdrop-blur-sm border border-black rounded-xl p-4 w-full">
    <div id="calendar"></div>
  </div>

  <!-- ปุ่มอยู่ใต้ปฏิทิน -->
  <a href="<?= base_url('index.php/') ?>" 
    class="w-24 text-center bg-gray-400 text-white rounded-md py-2 hover:bg-gray-500 self-start">
    ย้อนกลับ
  </a>
</div>

<!-- Modal -->
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
  <div class="bg-white rounded-xl p-6 w-[700px]">

    <h2 class="text-lg mb-4 font-bold">รายละเอียดการจอง</h2>

    <p id="modal_date" class="mb-4 text-blue-600"></p>

    <!-- 👉 ข้อความรวม -->
    <div id="view_all" 
      class="text-base leading-relaxed max-h-[400px] overflow-y-auto pr-2">
    </div>

    <!-- ปุ่ม -->
    <div class="mt-6">
      <button onclick="closeModal()" 
        class="w-full bg-gray-400 text-white py-2 rounded-md">
        ปิด
      </button>
    </div>

  </div>
</div>

</body>
</html>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar@6.1.8/index.global.min.js"></script>

<script>
let selectedDate = null;
let currentEvent = null;

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');

  window.calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 650,
    displayEventTime: false,
    slotMinTime: '00:00:00',
    slotMaxTime: '24:00:00',
    scrollTime: '08:00:00',
    locale: 'th',
    googleCalendarApiKey: 'AIzaSyDRlX_l8gCFIUh0WSSNLNq0baYnVNuS7Vo',

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    // 👉 คลิกวันที่
    dateClick: function(info) {
      const dateStr = info.dateStr;

      const date = new Date(dateStr);
      const day = date.getDate();
      const month = date.toLocaleString('th-TH', { month: 'long' });
      const year = date.getFullYear() + 543;

      document.getElementById('modal_date').innerText =
        'วันที่: ' + day + ' ' + month + ' ' + year;

      // 👉 ดึง event ของวันนั้น
      const events = calendar.getEvents().filter(ev => {

          const clickDate = new Date(dateStr);

          // start
          const start = new Date(ev.start);
          start.setHours(0,0,0,0);

          // end
          const end = ev.end ? new Date(ev.end) : new Date(ev.start);
          end.setHours(0,0,0,0);

          clickDate.setHours(0,0,0,0);

          // เช็คว่าวันที่กด อยู่ระหว่าง start-end
          return clickDate >= start && clickDate <= end;

      });

      renderEventsToModal(events);

      openModal();
    },

    // 👉 คลิก event
    eventClick: function(info) {

      // ป้องกัน redirect
      info.jsEvent.preventDefault();

      // วันหยุดไทย ไม่ต้องทำอะไร
      if(info.event.classNames.includes('holiday-event')){
          return;
      }
      
      const dateStr = info.event.startStr;

      const date = new Date(info.event.start);
      const day = date.getDate();
      const month = date.toLocaleString('th-TH', { month: 'long' });
      const year = date.getFullYear() + 543;

      const startDate = new Date(info.event.start);
      const endDate = info.event.end ? new Date(info.event.end) : null;

      const startDay = startDate.getDate();
      const startMonth = startDate.toLocaleString('th-TH', { month: 'long' });
      const startYear = startDate.getFullYear() + 543;

      let dateText = 'วันที่: ' + startDay + ' ' + startMonth + ' ' + startYear;

      // ถ้ามี end_date และคนละวัน
      if (
          endDate &&
          startDate.toDateString() !== endDate.toDateString()
      ) {
          const endDay = endDate.getDate();
          const endMonth = endDate.toLocaleString('th-TH', { month: 'long' });
          const endYear = endDate.getFullYear() + 543;

          dateText += ' - ' + endDay + ' ' + endMonth + ' ' + endYear;
      }

      document.getElementById('modal_date').innerText = dateText;

      // 👉 ใช้ format เดียวกัน (ส่งเป็น array)
      renderEventsToModal([info.event]);

      openModal();
    },

    eventDidMount: function(info) {
      if (info.event.extendedProps.description) {
        info.el.title = info.event.extendedProps.description;
      }
    },

    eventSources: [

      // วันหยุดไทย
      {
        googleCalendarId: 'th.th#holiday@group.v.calendar.google.com',
        className: 'holiday-event',
        color: '#FDE68A',
        textColor: '#000'
      }

    ],

    events: [

    <?php foreach($reserve as $row): ?>

    {
        title: <?= json_encode($row->start_time . ' - ' . $row->end_time . ' - ' . $row->meeting_topic) ?>,

        start: '<?= $row->start_date ?>T<?= $row->start_time ?>:00',

        end: '<?= $row->end_date ?>T<?= $row->end_time ?>:00',

        allDay: false,

        extendedProps: {
            name: <?= json_encode($row->name) ?>,
            affiliation: <?= json_encode($row->affiliation) ?>,
            phone_number: <?= json_encode($row->phone_number) ?>,
            email: <?= json_encode($row->email) ?>,
            time: <?= json_encode($row->start_time . ' - ' . $row->end_time) ?>,
            topic: <?= json_encode($row->meeting_topic) ?>,
            zoom_number: <?= json_encode($row->zoom_number) ?>,
            details: <?= json_encode($row->details) ?>
        }
    },

    <?php endforeach; ?>

    ]
  });

  calendar.render();
});

function showValue(value) {

    if (
        value === null ||
        value === undefined ||
        value === '' ||
        value === 'null'
    ) {
        return 'ไม่มีข้อมูล';
    }

    return value;
}

function renderEventsToModal(events) {

    if (events.length === 0) {

        document.getElementById('view_all').innerText = 'ไม่มีรายการจอง';
        return;
    }

    // เรียงตามเวลา
    events.sort((a, b) => a.start - b.start);

    let html = '';

    events.forEach(ev => {

        html += `
        <div class="py-4 border-b">

            <div class="mb-1">
                <strong>ชื่อผู้จอง:</strong>
                ${ev.extendedProps.name} , สังกัด: ${ev.extendedProps.affiliation} , Tel: ${ev.extendedProps.phone_number}
                <br>
                , Email: ${ev.extendedProps.email} 
            </div>

            <div class="mb-1">
                <strong>Time:</strong>
                ${ev.extendedProps.time}
            </div>

            <div class="font-semibold text-black">
                ${showValue(ev.extendedProps.zoom_number)}
            </div>

            <div class="text-sm whitespace-pre-line">
                ${showValue(ev.extendedProps.details)}
            </div>

        </div>
        `;
    });

    document.getElementById('view_all').innerHTML = html;
}

// 👉 เปิด modal
function openModal() {
  const modal = document.getElementById('eventModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

// 👉 ปิด modal
function closeModal() {
  const modal = document.getElementById('eventModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');

  document.getElementById('view_all').innerText = '';
}
</script>

<style>
    /* วันที่บนปฏิทิน */
    .fc .fc-daygrid-day-top {
        justify-content: flex-start !important;
        padding-left: 6px;
    }

    /* เลขวันที่ */
    .fc .fc-daygrid-day-number {
        width: 100%;
        text-align: left;
    }
</style>