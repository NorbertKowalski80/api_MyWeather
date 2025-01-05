<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prognoza Pogody</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-yellow-400 mb-6">PROGNOZA POGODY DLA WROCŁAWIA NA 9 DNI</h1>

        <!-- Przełącznik jednostek -->
        <div class="flex justify-center mb-4">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-black py-2 px-4 rounded mx-2" onclick="changeUnits('metric')">°C</button>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-black py-2 px-4 rounded mx-2" onclick="changeUnits('imperial')">°F</button>
        </div>

        <!-- Siatka prognozy -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="forecast-container">
            <!-- Prognozy będą renderowane tutaj za pomocą JavaScript -->
        </div>

        <!-- Wykres -->
        <div class="mt-10">
            <canvas id="temperatureChart"></canvas>
        </div>
    </div>

    <script>
        let forecastData = @json($data['list']);
        let unit = 'metric';

        // Renderowanie prognoz
        function renderForecast() {
            const container = document.getElementById('forecast-container');
            container.innerHTML = '';

            forecastData.forEach(day => {
                const date = new Date(day.dt * 1000);
                const dayCard = `
                    <div class="bg-gray-800 border border-yellow-500 rounded-lg shadow-lg p-4">
                        <h2 class="text-xl font-semibold text-yellow-400">${date.toLocaleDateString('pl-PL', { weekday: 'long', day: 'numeric', month: 'long' })}</h2>
                        <p>🌞 Dzień: <span class="text-yellow-300">${day.temp.day}°${unit === 'metric' ? 'C' : 'F'}</span></p>
                        <p>🌙 Noc: <span class="text-yellow-300">${day.temp.night}°${unit === 'metric' ? 'C' : 'F'}</span></p>
                        <p>📖 Opis: <span class="text-yellow-300">${day.weather[0].description}</span></p>
                        <img src="http://openweathermap.org/img/wn/${day.weather[0].icon}@2x.png" alt="Ikona pogody" class="mx-auto mt-2">
                    </div>
                `;
                container.innerHTML += dayCard;
            });
        }

        // Wykres temperatury
        function renderChart() {
            const ctx = document.getElementById('temperatureChart').getContext('2d');
            const labels = forecastData.map(day => new Date(day.dt * 1000).toLocaleDateString('pl-PL', { weekday: 'short' }));
            const data = forecastData.map(day => day.temp.day);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `Temperatura (${unit === 'metric' ? '°C' : '°F'})`,
                        data: data,
                        borderColor: 'yellow',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Zmiana jednostek
        function changeUnits(newUnit) {
            unit = newUnit;
            renderForecast();
            renderChart();
        }

        // Inicjalizacja
        renderForecast();
        renderChart();
    </script>
</body>
</html>
