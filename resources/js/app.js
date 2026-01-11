// resources/js/app.js

// 1. Import Bootstrap (Biasanya berisi Axios untuk request API)
import './bootstrap';

// 2. Import jQuery & Daftarkan Global
// Penting: Lakukan ini sebelum library lain yang butuh jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// 3. Import ApexCharts & Daftarkan Global
import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

// 4. Import Alpine.js & Inisialisasi
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

console.log('🚀 LogScreen Riska: All systems active!');
