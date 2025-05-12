export function formatRupiahInput() {
    const hargaInput = document.getElementById('harga');

    if (hargaInput) {
        hargaInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                e.target.value = 'Rp ' + Number(value).toLocaleString('id-ID');
            } else {
                e.target.value = '';
            }
        });

        document.querySelector('form').addEventListener('submit', function () {
            const raw = hargaInput.value.replace(/[^\d]/g, '');
            hargaInput.value = raw;
        });
    }
}
