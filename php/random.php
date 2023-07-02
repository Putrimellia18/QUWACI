<!DOCTYPE html>
<html>
    <head>
        <title>Random Forest</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
        crossorigin=""/>
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
        crossorigin=""></script>
        <style type="text/css">
            #map { height: 80vh; }
        </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Crimson+Text:ital@0;1&display=swap" rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="../css/style.css" />
    </head>
    <body>
        <?php include '../page/header.html'?>
        <div class="row">
            <div class="col-md-8 col-lg-9 gx-0 p-0">
                <nav class="nav nav-underline nav-fill">
                    <a class="nav-link" href="knn.php">KNN</a>
                    <a class="nav-link" href="svm.php">SVM</a>
                    <a class="nav-link active" href="random.php">RF</a>
                </nav>
                <div id="map"></div>
            </div>
            <div class="row-sm col-md-4 col-lg-3 legenda">
                <?php include "../page/sidemenu.html";?>
            </div>
        </div>
        <?php include "../page/footer.html";?>
        <script src="../assets/js/leaflet.ajax.js"></script>
        <script src="../assets/geojson/Sungai Citarum.js"></script>
        <script src="../assets/geojson/Waduk.js"></script>
        <script src="../assets/geojson/Batas_DAS_KLHK_2.js"></script>
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
            }).addTo(map);
            var greenIcon = L.icon({
            iconUrl: '../assets/marker/greenpoint.png',
            iconSize:     [38,38],
            });
            var yellowIcon = L.icon({
            iconUrl: '../assets/marker/yellowpoint.png',
            iconSize:     [38,38],
            });
            var redIcon = L.icon({
            iconUrl: '../assets/marker/redpoint.png',
            iconSize:     [38,38],
            });
            var blackIcon = L.icon({
            iconUrl: '../assets/marker/blackpoint.png',
            iconSize:     [38,38],
            });
            <?php
            include 'koneksi.php';
            // Return name of current default database
            if ($result = mysqli_query($conn, "SELECT * FROM random LEFT JOIN kualitas ON kualitas.id_kualitas=random.id_kualitas"))
            {
                while($row = mysqli_fetch_array($result))
                {?>
                    <?php
                    if ($row[1]==1)
                    {?>
                        var marker=L.marker([<?=$row[5]?>,<?=$row[6]?>], {icon: greenIcon}).addTo(map)
                        .bindPopup("Stasiun : <?=$row[0]?><br> Status Kualitas Air : <?=$row[1]?> <br> Keterangan : <?=$row[8]?>
                        <br> Nama Sungai : <?=$row[2]?><br> Nama Stasiun : <?=$row[3]?> <br> Lokasi : <?=$row[4]?>");
                    <?php
                    }?>
                    <?php
                    if ($row[1]==2)
                    {?>
                        var marker=L.marker([<?=$row[5]?>,<?=$row[6]?>], {icon: yellowIcon}).addTo(map)
                        .bindPopup("Stasiun : <?=$row[0]?><br> Status Kualitas Air : <?=$row[1]?>
                        <br> Keterangan : <?=$row[8]?><br>Nama Sungai : <?=$row[2]?><br> Nama Stasiun : <?=$row[3]?> <br> Lokasi : <?=$row[4]?>");
                    <?php
                    }?>
                    <?php
                    if ($row[1]==3)
                    {?>
                        var marker=L.marker([<?=$row[5]?>,<?=$row[6]?>], {icon: redIcon}).addTo(map)
                        .bindPopup("Stasiun : <?=$row[0]?><br> Status Kualitas Air : <?=$row[1]?>
                        <br> Keterangan : <?=$row[8]?><br>Nama Sungai : <?=$row[2]?><br> Nama Stasiun : <?=$row[3]?> <br> Lokasi : <?=$row[4]?>");
                    <?php
                    }?>
                    <?php
                    if ($row[1]==4)
                    {?>
                        var marker=L.marker([<?=$row[5]?>,<?=$row[6]?>], {icon: blackIcon}).addTo(map)
                        .bindPopup("Stasiun : <?=$row[0]?><br> Status Kualitas Air : <?=$row[1]?>
                        <br> Keterangan : <?=$row[8]?><br>Nama Sungai : <?=$row[2]?><br> Nama Stasiun : <?=$row[3]?> <br> Lokasi : <?=$row[4]?>");
                    <?php
                    }?>
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
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
            crossorigin="anonymous"
        />
    </body>
</html>