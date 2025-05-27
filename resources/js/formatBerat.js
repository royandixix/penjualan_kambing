export function formatBeratInput() {
    const beratInput = document.getElementById('berat');

    if (beratInput) {
        beratInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^\d.]/g, '');
            if (value) {
                e.target.value = parseFloat(value) + ' kg';
            } else {
                e.target.value = '';
            }
        });

        document.querySelector('form').addEventListener('submit', function () {
            if (beratInput.value.includes('kg')) {
                beratInput.value = beratInput.value.replace(/[^\d.]/g, '');
            }
        });
    }
}




