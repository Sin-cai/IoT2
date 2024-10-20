<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <!-- Include Bootstrap Icons CSS in your head -->
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
              <a class="nav-link text-white" id="pengaturanLink" data-bs-toggle="collapse" href="#pengaturanSubmenu" role="button" aria-expanded="false" aria-controls="pengaturanSubmenu">
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
                      <i class="bi bi-box-seam me-2"></i> Things
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

   

        <div class="row text-center">
          <!-- Card 1: Temperatur -->
          <div class="col-md-4">
            <div class="card p-3 border-success">
              <h5 class="card-title">Temperatur</h5>
              <h1 class="display-1">{{ optional($latestTemperature)->value1 ?? 0 }}°C</h1>
            </div>
          </div>
          
          <!-- Card 2: Temperatur Saat Ini -->
          <div class="col-md-4">
            <div class="card p-3 border-success">
              <h5 class="card-title">Pengaturan suhu Saat Ini</h5>
              <h1 id="currentTemperature" class="display-1">{{ $value1 }}°C</h1>
            </div>
          </div>
          
          <!-- Card 3: Set Thermometer -->
          <div class="col-md-4">
            <div class="card p-3 border-success">
              <h5 class="card-title">Set Suhu</h5>
              <input type="number" id="temperatureInput" class="form-control mb-2" placeholder="Enter value">
              <button class="btn btn-success w-100">Set</button>
            </div>
          </div>
        </div>

        <!-- Action -->
        <div class="row mt-4 text-center">
          <div class="col">
            <div class="card p-3">
              <h5 class="card-title">Action</h5>

              <div class="row">
                <!-- Power Section -->
                <div class="col-md-4">
                  <div class="card p-3 border-success">
                    <h6 class="fw-bold">Power</h6>
                    <div class="toggle-switch">
                      <span>OFF</span>
                      <label class="switch">
                        <input type="checkbox" id="powerSwitch">
                        <span class="slider"></span>
                      </label>
                      <span>ON</span>
                    </div>
                  </div>
                </div>

                <!-- Nama Alat 1 -->
                <div class="col-md-4">
                  <div class="card p-3 border-success">
                    <h6 class="fw-bold">Nama Alat 1</h6>
                    <div class="toggle-switch">
                      <span>OFF</span>
                      <label class="switch">
                        <input type="checkbox" class="unitSwitch" data-name="Nama Alat 1">
                        <span class="slider"></span>
                      </label>
                      <span>ON</span>
                    </div>
                  </div>
                </div>

                <!-- Nama Alat 2 -->
                <div class="col-md-4">
                  <div class="card p-3 border-success">
                    <h6 class="fw-bold">Nama Alat 2</h6>
                    <div class="toggle-switch">
                      <span>OFF</span>
                      <label class="switch">
                        <input type="checkbox" class="unitSwitch" data-name="Nama Alat 2">
                        <span class="slider"></span>
                      </label>
                      <span>ON</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Scrollable Content -->
        <div class="row mt-4">
          <div class="col">
            <div class="card p-3">
              <h5 class="card-title">Logs</h5>
              <div class="scrollable-content" id="logsContainer">
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const setButton = document.querySelector('.btn-success');
    const temperatureDisplay = document.getElementById('currentTemperature');
    const temperatureInput = document.getElementById('temperatureInput'); // Input field for the temperature
    const deviceId = 'YOUR_DEVICE_ID'; // Replace with the actual device ID

    // Event listener for Set Thermometer button
    setButton.addEventListener('click', function() {
        const newValue = temperatureInput.value;

        // Send request to backend to update value1
        fetch('/set-thermometer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value1: newValue,
                device_id: deviceId // Send devices_id with the request
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);

                // Update temperature display in Card 2 without refreshing
                temperatureDisplay.innerHTML = `${newValue}°C`;

                // Reset input field in Card 3
                temperatureInput.value = ''; // Clear input field after successful submission
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});


</script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    const powerSwitch = document.getElementById('powerSwitch');
    const logsContainer = document.getElementById('logsContainer');
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const deviceId = 'YOUR_DEVICE_ID'; // Replace with actual device ID

    // Function to update the switch based on the server status
    function updatePowerSwitch(status) {
        powerSwitch.checked = status === 1; // Set switch ON or OFF
    }

    // Polling function to check power status every 5 seconds
    function pollPowerStatus() {
        fetch(`/get-power-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                device_id: deviceId // Send the devices_id to check status
            })
        })
        .then(response => response.json())
        .then(data => {
            updatePowerSwitch(data.status); // Update switch based on status from server
            const logEntry = document.createElement('div');
            logEntry.className = 'log-entry';
            logEntry.innerHTML = `<p>Power is ${data.status === 1 ? 'ON' : 'OFF'} <span>- ${currentTime}</span></p>`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight; // Auto-scroll to bottom
        })
        .catch(error => {
            console.error('Error fetching power status:', error);
        });
    }

    // Initial check when the page loads
    pollPowerStatus();

    // Set an interval to poll power status every 5 seconds
    setInterval(pollPowerStatus, 5000); // 5000ms = 5 seconds

    // Event listener for Power Switch toggle
    powerSwitch.addEventListener('change', function() {
        const powerStatus = this.checked ? 1 : 0; // 1 if ON, 0 if OFF

        // Send a request to backend to update the power status
        fetch(`/toggle-power`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: powerStatus,
                device_id: deviceId // Send devices_id to update status
            })
        })
        .then(response => response.json())
        .then(data => {
            // Add log entry for status change
            const logEntry = document.createElement('div');
            logEntry.className = 'log-entry';
            logEntry.innerHTML = `<p>${data.status === 1 ? 'Power ON' : 'Power OFF'} <span>- ${currentTime}</span></p>`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight; // Auto-scroll to bottom
        })
        .catch(error => {
            console.error('Error updating power status:', error);
        });
    });
});

</script>



</body>
</html>