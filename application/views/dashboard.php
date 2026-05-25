<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="flex min-h-screen">

    <div class="flex flex-col flex-1 p-6">

        <div class="bg-white/50 backdrop-blur-sm border border-black rounded-xl p-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">

                <h1 class="text-2xl font-bold">
                    Dashboard
                </h1>

                <a href="<?= base_url('index.php/') ?>" 
                    class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">

                    หน้าแรก

                </a>

            </div>

            <!-- Filter -->
            <form method="GET" class="flex gap-4 items-end mb-6">

                <div class="flex flex-col">
                    <label class="font-medium mb-1">
                        วันที่เริ่ม
                    </label>

                    <input type="date"
                        name="start_date"
                        value="<?= $this->input->get('start_date') ?>"
                        class="border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div class="flex flex-col">
                    <label class="font-medium mb-1">
                        วันที่สิ้นสุด
                    </label>

                    <input type="date"
                        name="end_date"
                        value="<?= $this->input->get('end_date') ?>"
                        class="border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600">

                    ค้นหา

                </button>

                <a href="<?= base_url('index.php/dashboard') ?>"
                    class="bg-gray-400 text-white px-5 py-2 rounded-lg hover:bg-gray-500">

                    รีเซ็ต

                </a>

            </form>

            <!-- Charts Wrapper -->
            <div class="flex gap-6 items-start mt-6">

                <!-- Bar Chart -->
                <div class="bg-white rounded-xl p-4 shadow flex-1 h-[400px]">

                    <h2 class="text-xl font-bold mb-4 text-left">
                        จำนวนการจองห้อง Zoom
                    </h2>

                    <canvas id="zoomChart"></canvas>

                </div>

                <!-- Pie Chart -->
                <div class="bg-white rounded-xl p-4 shadow w-[350px] h-[400px]">

                    <h2 class="text-xl font-bold mb-4 text-left">
                        จำนวนการจองแยกตามสังกัด
                    </h2>

                    <canvas id="affChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('zoomChart');

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: <?= $labels ?>,

        datasets: [{
            label: 'จำนวนการจอง',

            data: <?= $totals ?>,

            borderWidth: 1
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: true
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

const affCtx = document.getElementById('affChart');

new Chart(affCtx, {
    type: 'pie',

    data: {
        labels: <?= $affLabels ?>,

        datasets: [{
            data: <?= $affTotals ?>,
            borderWidth: 1
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>