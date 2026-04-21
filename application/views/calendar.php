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
    <div id="view_all" class="text-base leading-relaxed"></div>

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

<script>
let selectedDate = null;
let currentEvent = null;

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
        return ev.startStr === dateStr;
      });

      renderEventsToModal(events);

      openModal();
    },

    // 👉 คลิก event
    eventClick: function(info) {
      const dateStr = info.event.startStr;

      const date = new Date(info.event.start);
      const day = date.getDate();
      const month = date.toLocaleString('th-TH', { month: 'long' });
      const year = date.getFullYear() + 543;

      document.getElementById('modal_date').innerText =
        'วันที่: ' + day + ' ' + month + ' ' + year;

      // 👉 ใช้ format เดียวกัน (ส่งเป็น array)
      renderEventsToModal([info.event]);

      openModal();
    },

    eventDidMount: function(info) {
      if (info.event.extendedProps.description) {
        info.el.title = info.event.extendedProps.description;
      }
    },

    events: [
      {
        title: '09:00 - 10:30 ประชุมวางแผนโครงการ',
        start: '2026-04-21',
        allDay: true,
        extendedProps: {
          time: '09:00 - 10:30',
          name: 'สมชาย ใจดี',
          phone: '081-234-5678',
          description: 'ประชุมวางแผนโครงการ'
        }
      },
      {
        title: '13:00 - 14:00 ประชุมทีม',
        start: '2026-04-21',
        allDay: true,
        extendedProps: {
          time: '13:00 - 14:00',
          name: 'สมหญิง ใจงาม',
          phone: '089-111-2222',
          description: 'ประชุมทีมงาน'
        }
      }
    ]
  });

  calendar.render();
});

function renderEventsToModal(events) {
  if (events.length === 0) {
    document.getElementById('view_all').innerText = 'ไม่มีรายการจอง';
    return;
  }

  let text = '';

  events.forEach(ev => {
    text += 
      (ev.extendedProps.time || '-') + ' ' +
      (ev.extendedProps.description || '-') + ' | ' +
      (ev.extendedProps.name || '-') + ' | ' +
      (ev.extendedProps.phone || '-') + '\n';
  });

  document.getElementById('view_all').innerText = text;
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

// 👉 บันทึก / แก้ไข
function saveEvent() {
  const title = document.getElementById('modal_title').value;
  const desc = document.getElementById('modal_desc').value;
  const time = document.getElementById('modal_time').value;
  const name = document.getElementById('modal_name').value;
  const email = document.getElementById('modal_email').value;
  const phone = document.getElementById('modal_phone').value;

  if (!title || !selectedDate) {
    alert('กรุณากรอกข้อมูล');
    return;
  }

  if (currentEvent) {
    // แก้ไข
    currentEvent.setProp('title', title);
    currentEvent.setExtendedProp('description', desc);
    currentEvent.setExtendedProp('time', time);
    currentEvent.setExtendedProp('name', name);
    currentEvent.setExtendedProp('email', email);
    currentEvent.setExtendedProp('phone', phone);
  } else {
    // เพิ่มใหม่
    calendar.addEvent({
      title: title + (time ? ' (' + time + ')' : ''),
      start: selectedDate,
      allDay: true,
      extendedProps: {
        description: desc,
        time: time,
        name: name,
        email: email,
        phone: phone
      }
    });
  }

  closeModal();
}
</script>