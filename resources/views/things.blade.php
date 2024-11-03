<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Things</title>
  <!-- Include Bootstrap Icons and Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-2 bg-success text-white min-vh-100">
        <div class="p-3">
          <img src="css/logo_unu_putih.png" alt="Logo" class="img-fluid mb-4">
          <ul class="nav flex-column">
            <li class="nav-item mb-2">
              <a class="nav-link text-white active" href="/suhu">
                <i class="bi bi-house me-2"></i> Dashboard
              </a>
            </li>
            <li class="nav-item mb-2">
              <a class="nav-link text-white" id="pengaturanLink" data-bs-toggle="collapse" href="#pengaturanSubmenu"
                role="button" aria-expanded="false" aria-controls="pengaturanSubmenu">
                <i class="bi bi-gear me-2"></i> Pengaturan
              </a>
              <div class="collapse" id="pengaturanSubmenu">
                <ul class="nav flex-column ps-3">
                  <li class="nav-item">
                    <a class="nav-link text-white" href="/devices">
                      <i class="bi bi-pc-display-horizontal"></i> Device
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="/things">
                      <i class="bi bi-box-seam me-2"></i>  Things
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-10">
        <!-- Header (Navbar) -->
        <div class="navbar navbar-light bg-light shadow-sm">
          <div class="container-fluid justify-content-end">
            <button class="btn btn-light">User</button>
          </div>
        </div>

        <!-- Page Heading -->
        <div class="container-fluid mt-3">
          <h5 class="m-0">Pengaturan → Things</h5>
        </div>

        <!-- Things Content -->
        <div class="container-fluid mt-4">
          <div class="d-flex justify-content-between">
            <button class="btn btn-success mb-3">Tambah Device</button>
            <button id="laporanBtn" class="btn btn-outline-success mb-3">Laporan</button>
            <canvas id="suhuChart" width="400" height="200" style="display: none;"></canvas>
          </div>
        
          <!-- Dropdown for Device -->
          <div class="dropdown mb-3">
            <button class="btn btn-outline-success dropdown-toggle" type="button" id="deviceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Device
            </button>
            <ul class="dropdown-menu" aria-labelledby="deviceDropdown">
                @foreach($devices as $device)
                    <li><a class="dropdown-item select-device" data-device-id="{{ $device->id }}">{{ $device->name }}</a></li>
                @endforeach
            </ul>
          </div>
        </div>
        
        <!-- Things Data Display -->
        <div class="card border-success p-4">
          <h5 id="deviceName" class="card-title text-center fw-bold">List Of Things</h5>
          <div id="things-list" class="row text-center">
            <!-- Things data will be loaded here via AJAX -->
          </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script type="text/javascript">
          $(document).ready(function() {
            let selectedDeviceId = null;
            var suhuChart = null; // Global variable for the chart
        
            // Event listener for device selection
            $('.select-device').click(function(e) {
              e.preventDefault();
        
              // Get the device_id from data-device-id attribute
              selectedDeviceId = $(this).data('device-id');
        
              // Make an AJAX request to get the things related to the selected device
              $.ajax({
                url: '/get-things/' + selectedDeviceId, // URL to your route
                type: 'GET',
                success: function(response) {
                  $('#things-list').empty();
        
                  response.things.forEach(function(thing) {
                    let thingsDataHtml = '';
        
                    thing.things_data.forEach(function(data) {
                      thingsDataHtml += `<p>${data.value}°C (Recorded at: ${data.created_at})</p>`;
                    });
        
                    $('#things-list').append(`
                      <div class="col-md-4">
                        <div class="card p-3 border-success option">
                          <h5 class="fw-bold">` + thing.things_type + `</h5>
                          <div>` + thingsDataHtml + `</div>
                        </div>
                      </div>
                    `);
                  });
        
                  $('#deviceName').text('List Of Things for Device: ' + response.deviceName);
                }
              });
            });
        
            // Event listener for the "Laporan" button
            $('#laporanBtn').click(function() {
              if (!selectedDeviceId) {
                alert('Please select a device first.');
                return;
              }
        
              // Make an AJAX request to get chart data based on the selected device
              $.ajax({
                url: '/get-chart-data/' + selectedDeviceId, // URL to your route
                type: 'GET',
                success: function(response) {
                  // Prepare datasets for each thing
                  const datasets = response.map(item => {
                    return {
                      label: item.label, // Thing type (name)
                      data: item.data.map(d => d.value), // Temperature values
                      borderColor: randomColor(), // Line color
                      fill: false
                    };
                  });
        
                  // Get the labels (timestamps)
                  const labels = response[0]?.data.map(d => d.timestamp) || [];
        
                  // Display the chart canvas
                  $('#suhuChart').show();
        
                  // Destroy the old chart if it exists
                  if (suhuChart) {
                    suhuChart.destroy();
                  }
        
                  // Create a new chart with multiple datasets
                  const ctx = document.getElementById('suhuChart').getContext('2d');
                  suhuChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                      labels: labels, // Timestamp
                      datasets: datasets
                    },
                    options: {
                      responsive: true,
                      scales: {
                        x: {
                          display: true,
                          title: {
                            display: true,
                            text: 'Timestamp'
                          }
                        },
                        y: {
                          display: true,
                          title: {
                            display: true,
                            text: 'Temperature (°C)'
                          }
                        }
                      }
                    }
                  });
                }
              });
            });
        
            // Function to generate random colors for each line
            function randomColor() {
              const r = Math.floor(Math.random() * 255);
              const g = Math.floor(Math.random() * 255);
              const b = Math.floor(Math.random() * 255);
              return `rgba(${r}, ${g}, ${b}, 1)`;
            }
          });
        </script>
        

</body>
</html>
