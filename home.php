<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
      integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
      crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
      integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
      crossorigin=""></script>
    <style type="text/css">
      #map { height: 80vh; }
    </style>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Crimson+Pro:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div id="userguide" class="overlay">
      <div class="popup">
        <h3>Selamat Datang!</h3>
        <p>Silahkan pilih algoritma dan klik point untuk informasi yang lebih detail</p>
        <div class="button-close">
          <a onclick="closePopup()"><i data-feather="x-circle"></i></a>
        </div>
      </div>
    </div>
    <div class="row gx-1 navigasi-judul">
      <img
        src="assets/logoputih.png"
        alt="River"
        class="col-4 col-md-2 col-lg-1 img-fluid"
      />
      <div class="col-6 col-md-8 col-lg-9">
        Kualitas Air Sungai Citarum<br />
        Provinsi Jawa Barat
      </div>
      <div
        class="col-2 col-md-2 col-lg-2 d-flex gap-3 justify-content-end logo"
      >
        <a href="page/loginadmin.php" id="user"
          ><i data-feather="log-in"></i
        ></a>
        <div class="info-logo">Login Admin</div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 gx-0 p-0">
        <nav class="nav nav-underline nav-fill">
          <a class="nav-link" href="php/knn.php">KNN</a>
          <a class="nav-link" href="php/svm.php">SVM</a>
          <a class="nav-link" href="php/random.php">RF</a>
        </nav>
        <div id="map" class="map"></div>
      </div>
    </div>
    <div class="footer">
      <div class="footer1">
        <div class="logobawah">
          <img src="assets/logoputih.png" alt="River" width="90" height="90" />
        </div>
        <div class="kontak">
          <h6>FOLLOW US</h6>
          <div class="kontak1">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
            <a href="#"><i data-feather="linkedin"></i></a>
          </div>
        </div>
      </div>
      <p>Created by PDN |&copy;2023 All rights reserved</p>
      <br />
    </div>
    <script src="assets/js/leaflet.ajax.js"></script>
    <script src="assets/geojson/Sungai Citarum.js"></script>
    <script src="assets/geojson/Waduk.js"></script>
    <script src="assets/geojson/Batas_DAS_KLHK_2.js"></script>
    <script type="text/javascript">
      var map = L.map('map').setView([-6.708109, 107.519332], 9);
      var myStyle = {
          "color": "#4169E1",
          "weight": 5,
          "opacity": 0.65
      };
      var myStyle2 = {
          "color": "#FF0000",
          "weight": 5,
          "opacity": 0.3
      };
      var DAS = L.geoJSON(json_Batas_DAS_KLHK_2,{style : myStyle2}).addTo(map);
      var Waduk = L.geoJSON(waduk,{style : myStyle}).addTo(map);
      var Sungai = L.geoJSON(sungai,{style : myStyle}).addTo(map);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);
      var Point = L.icon({
      iconUrl: 'assets/marker/marker.png',
      iconSize:     [38,38],
      });
      <?php
      include 'php/koneksi.php';
      
      // Return name of current default database
      if ($result = mysqli_query($conn, "SELECT * FROM koordinat"))
      {
          while($row = mysqli_fetch_array($result))
          {?>
            var marker=L.marker([<?=$row[5]?>,<?=$row[6]?>], {icon:Point}).addTo(map);
            marker.bindPopup("Nama Stasiun : <?=$row[3]?> <br> Lokasi : <?=$row[4]?>");
            marker.on('mouseover', function () {
              this.openPopup();
            });
            marker.on('mouseout', function () {
              this.closePopup();
            });
          <?php
          }
      }
      ?>
    </script>

    <script>
      feather.replace();
    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
    <script>
        function openPopup() {
            document.getElementById("userguide").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("userguide").style.display = "none";
        }
    </script>
  </body>
</html>
