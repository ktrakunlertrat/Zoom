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
<div class="flex flex-1 mt-4">
  <div class="bg-white backdrop-blur-sm border border-black rounded-xl p-4 w-full h-1/5">
    <div id="calendar"></div>
  </div>
</div>

<!-- Modal -->
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
  <div class="bg-white rounded-xl p-6 w-96">

    <h2 class="text-lg mb-2">จัดการการจอง</h2>

    <p id="modal_date" class="mb-2 text-blue-600"></p>

    <input type="text" id="modal_title" placeholder="หัวข้อ"
      class="border w-full mb-2 px-2 py-1 rounded-md">

    <input type="text" id="modal_name" placeholder="ชื่อ - นามสกุล"
      class="border w-full mb-2 px-2 py-1 rounded-md">

    <input type="text" id="modal_email" placeholder="Email"
      class="border w-full mb-2 px-2 py-1 rounded-md">

    <input type="text" id="modal_phone" placeholder="เบอร์โทร"
      class="border w-full mb-2 px-2 py-1 rounded-md">

    <textarea id="modal_desc" placeholder="รายละเอียด"
      class="border w-full mb-2 px-2 py-1 rounded-md"></textarea>

    <input type="time" id="modal_time"
      class="border w-full mb-4 px-2 py-1 rounded-md">

    <div class="flex gap-2">
      <button onclick="closeModal()" 
        class="w-1/2 bg-gray-400 text-white py-2 rounded-md">ปิด</button>

      <button onclick="saveEvent()" 
        class="w-1/2 bg-blue-500 text-white py-2 rounded-md">บันทึก</button>
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
      selectedDate = info.dateStr;
      currentEvent = null;

      const date = new Date(info.dateStr);
      const day = date.getDate();
      const month = date.toLocaleString('th-TH', { month: 'long' });
      const year = date.getFullYear() + 543;

      document.getElementById('modal_date').innerText =
        'วันที่: ' + day + ' ' + month + ' ' + year;

      openModal();
    },

    // 👉 คลิก event
    eventClick: function(info) {
      currentEvent = info.event;
      selectedDate = info.event.startStr;

      const date = new Date(info.event.start);
      const day = date.getDate();
      const month = date.toLocaleString('th-TH', { month: 'long' });
      const year = date.getFullYear() + 543;

      document.getElementById('modal_date').innerText =
        'วันที่: ' + day + ' ' + month + ' ' + year;

      document.getElementById('modal_title').value = info.event.title;
      document.getElementById('modal_desc').value = info.event.extendedProps.description || '';
      document.getElementById('modal_time').value = info.event.extendedProps.time || '';
      document.getElementById('modal_name').value = info.event.extendedProps.name || '';
      document.getElementById('modal_email').value = info.event.extendedProps.email || '';
      document.getElementById('modal_phone').value = info.event.extendedProps.phone || '';

      openModal();
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

  document.getElementById('modal_title').value = '';
  document.getElementById('modal_desc').value = '';
  document.getElementById('modal_time').value = '';
  document.getElementById('modal_name').value = '';
  document.getElementById('modal_email').value = '';
  document.getElementById('modal_phone').value = '';
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