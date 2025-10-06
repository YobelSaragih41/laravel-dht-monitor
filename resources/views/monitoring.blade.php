<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>

    <title>Monitoring Sensor Laravel</title>

    <script type="text/javascript">
      $(document).ready(function() {

          // Update nilai suhu & kelembapan setiap 1 detik
          setInterval(function() {
              $("#suhu").load("{{ url('getSuhu') }}");
              $("#kelembapan").load("{{ url('getKelembapan') }}");
              fetchChartData();
          }, 1000);

          // Chart.js
          const ctx = document.getElementById('sensorChart').getContext('2d');
          const sensorChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: [],
                  datasets: [
                      {
                          label: 'Suhu (°C)',
                          data: [],
                          borderColor: 'red',
                          backgroundColor: 'rgba(255,0,0,0.2)',
                          tension: 0.3
                      },
                      {
                          label: 'Kelembapan (%)',
                          data: [],
                          borderColor: 'blue',
                          backgroundColor: 'rgba(0,0,255,0.2)',
                          tension: 0.3
                      }
                  ]
              },
              options: {
                  responsive: true,
                  animation: false,
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

          // Ambil data terakhir 20 record untuk chart
          function fetchChartData() {
              $.get("{{ url('getSensorData') }}", function(data) {
                  sensorChart.data.labels = data.map(item => item.created_at);
                  sensorChart.data.datasets[0].data = data.map(item => item.suhu);
                  sensorChart.data.datasets[1].data = data.map(item => item.kelembapan);
                  sensorChart.update();
              });
          }
      });
    </script>
  </head>
  <body>
    <div class="container text-center mt-5">
      <img src="{{ asset('images/TgdLogo.png') }}" class="img-fluid" style="width: 150px;">
      <h2>Monitoring Nilai Sensor Secara Real-Time<br>Menggunakan Framework Laravel</h2>
      <p></p>
    </div>

    <div class="container mt-4">
      <div class="row text-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header" style="background-color: red; color: white;"> 
              <h4>SUHU</h4>
            </div>
            <div class="card-body">
              <div style="font-size: 70px; font-weight: bold;">
                <span id="suhu">0</span> <span style="font-size: 24px; vertical-align: top;">°C</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header" style="background-color: blue; color: white;"> 
              <h4>KELEMBAPAN</h4>
            </div>
            <div class="card-body">
              <div style="font-size: 70px; font-weight: bold;">
                <span id="kelembapan">0</span> <span style="font-size: 24px; vertical-align: top;">%</span>
              </div>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <!-- Grafik -->
    <div class="container mt-5">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Grafik Suhu & Kelembapan Realtime
        </div>
        <div class="card-body">
          <canvas id="sensorChart" height="150"></canvas>
        </div>
      </div>
    </div>
  </body>
</html>
