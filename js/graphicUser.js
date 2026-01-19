function disegnaGraficoTorta(etichette, datiNumerici) {
    const ctx = document.getElementById('graficoCategorie').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: etichette,
            datasets: [{
                label: 'Numero di Post',
                data: datiNumerici,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}