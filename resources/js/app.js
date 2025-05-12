// Import Bootstrap dan helper
import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min';

// Import fungsi format
import { formatRupiahInput } from './formatHarga';
import { formatBeratInput } from './formatBerat';

// Jalankan setelah DOM siap
document.addEventListener('DOMContentLoaded', function () {
    formatRupiahInput();
    formatBeratInput();
});
