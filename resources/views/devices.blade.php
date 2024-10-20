<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Device</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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

        <!-- Page Heading -->
        <div class="container-fluid mt-3">
          <h5 class="m-0">Pengaturan → Device</h5>
        </div>

        <!-- Device Content -->
        <div class="container-fluid mt-4">
          <div class="d-flex justify-content-between">
            <button class="btn btn-success mb-3">Tambah Device</button>
            <button class="btn btn-outline-success mb-3">Laporan</button>
          </div>

          <!-- Box for List of Device -->
          <div class="card border-success p-4">
            <h5 class="card-title text-center fw-bold">List of Device</h5>

            <div class="row text-center">
              @foreach ($devices as $device)
              <div class="col-md-4 jenis">
                <div class="card p-3 border-success">
                  <h5 class="fw-bold">{{ $device->name }}</h5>

                  @php
                      // Menghitung rata-rata suhu
                      $totalValue1 = $device->things->sum(function ($thing) {
                          return $thing->value1 ?? 0;  // Jika null, maka nilai jadi 0
                      });
                      $totalValue2 = $device->things->sum(function ($thing) {
                          return $thing->value2 ?? 0;  // Jika null, maka nilai jadi 0
                      });
                      $jumlahThings = $device->things->count() * 2; // Karena kita menghitung dua value (value1 + value2)

                      // Hindari pembagian dengan nol
                      $rataRataSuhu = $jumlahThings > 0 ? ($totalValue1 + $totalValue2) / $jumlahThings : 0;
                  @endphp

                  <p>Rata-rata Suhu: {{ number_format($rataRataSuhu, 2) }} °C</p>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
