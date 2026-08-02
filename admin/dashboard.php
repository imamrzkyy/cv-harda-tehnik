<?php
include "../includes/auth.php";
include "../config/koneksi.php";

$nama = $_SESSION['nama_admin'];
$role = $_SESSION['role_admin'];

/* ===================================================
   CARD STATISTIK
=================================================== */

$totalProduk = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM produk")
);

$totalKategori = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM kategori_produk")
);

$totalBooking = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM booking")
);

$totalTestimoni = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM testimoni")
);

/* ===================================================
   GRAFIK BOOKING PER BULAN
=================================================== */

$namaBulan = [
    1=>"Jan",
    2=>"Feb",
    3=>"Mar",
    4=>"Apr",
    5=>"Mei",
    6=>"Jun",
    7=>"Jul",
    8=>"Agu",
    9=>"Sep",
    10=>"Okt",
    11=>"Nov",
    12=>"Des"
];

$labelChart = [];
$dataChart  = [];

$queryChart = mysqli_query($koneksi,"
    SELECT
        MONTH(tanggal) AS bulan,
        COUNT(*) AS total
    FROM booking
    GROUP BY MONTH(tanggal)
    ORDER BY MONTH(tanggal)
");

while($row = mysqli_fetch_assoc($queryChart)){

    $labelChart[] = $namaBulan[$row['bulan']];
    $dataChart[]  = (int)$row['total'];

}

/* ===================================================
   STATUS BOOKING (PIE CHART)
=================================================== */

$statusLabel = [];
$statusData  = [];

$queryStatus = mysqli_query($koneksi,"
    SELECT
        status,
        COUNT(*) AS total
    FROM booking
    GROUP BY status
");

while($row = mysqli_fetch_assoc($queryStatus)){

    $statusLabel[] = $row['status'];
    $statusData[]  = (int)$row['total'];

}

/* ===================================================
   BOOKING TERBARU
=================================================== */

$bookingTerbaru = mysqli_query($koneksi,"
SELECT
    booking.*,
    user.nama,
    layanan.nama_layanan
FROM booking
LEFT JOIN user
ON user.id_user = booking.id_user
LEFT JOIN layanan
ON layanan.id_layanan = booking.id_layanan
ORDER BY booking.id_booking DESC
LIMIT 5
");

/* ===================================================
   TESTIMONI TERBARU
=================================================== */

$testimoniTerbaru = mysqli_query($koneksi,"
SELECT
    testimoni.*,
    user.nama
FROM testimoni
LEFT JOIN user
ON user.id_user = testimoni.id_user
ORDER BY testimoni.id_testimoni DESC
LIMIT 5
");

include "header.php";
include "sidebar.php";
?>

<div class="content">

<div class="container-fluid">

    <!-- Judul Dashboard -->

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h2 class="fw-bold text-primary mb-1">

                <i class="bi bi-speedometer2"></i>

                Dashboard Admin

            </h2>

            <p class="text-muted mb-0">

                Selamat datang,

                <strong><?= htmlspecialchars($nama); ?></strong>

                <span class="badge bg-success ms-2">

                    <?= htmlspecialchars($role); ?>

                </span>

            </p>

        </div>

    </div>
    <!-- ===========================
     CARD STATISTIK
=========================== -->

<div class="row g-4 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Produk
                        </small>

                        <h2 class="fw-bold text-primary mt-2 mb-0">

                            <?= $totalProduk; ?>

                        </h2>

                    </div>

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:70px;height:70px;background:#e9f2ff;">

                        <i class="bi bi-box-seam fs-2 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Kategori
                        </small>

                        <h2 class="fw-bold text-success mt-2 mb-0">

                            <?= $totalKategori; ?>

                        </h2>

                    </div>

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:70px;height:70px;background:#e8fff0;">

                        <i class="bi bi-tags fs-2 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Booking
                        </small>

                        <h2 class="fw-bold text-warning mt-2 mb-0">

                            <?= $totalBooking; ?>

                        </h2>

                    </div>

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:70px;height:70px;background:#fff7df;">

                        <i class="bi bi-calendar-check fs-2 text-warning"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-xl-3 col-md-6">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Testimoni
                        </small>

                        <h2 class="fw-bold text-info mt-2 mb-0">

                            <?= $totalTestimoni; ?>

                        </h2>

                    </div>

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:70px;height:70px;background:#e8fbff;">

                        <i class="bi bi-chat-left-text fs-2 text-info"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ===========================
     GRAFIK
=========================== -->

<div class="row">

    <div class="col-lg-8 mb-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-bar-chart-line text-primary"></i>

                    Grafik Booking Bulanan

                </h5>

            </div>

            <div class="card-body">

                <div class="chart-container">

                    <canvas id="bookingChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-pie-chart text-success"></i>

                    Status Booking

                </h5>

            </div>

            <div class="card-body">

                <div class="chart-container">

                    <canvas id="statusChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ===========================
     BOOKING TERBARU
=========================== -->

<div class="row">

    <div class="col-lg-8 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-clock-history text-primary"></i>

                    Booking Terbaru

                </h5>

            </div>

            <div class="card-body table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>

                            <th>Pelanggan</th>

                            <th>Layanan</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    if(mysqli_num_rows($bookingTerbaru)>0){

                        while($row = mysqli_fetch_assoc($bookingTerbaru)){

                    ?>

                        <tr>

                            <td><?= $no++; ?></td>

                            <td>

                                <?= htmlspecialchars($row['nama']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($row['nama_layanan']); ?>

                            </td>

                            <td>

                                <?= date('d M Y', strtotime($row['tanggal'])); ?>

                            </td>

                            <td>

                                <?php

                                if($row['status']=="Menunggu"){

                                    echo '<span class="badge bg-warning text-dark">Menunggu</span>';

                                }elseif($row['status']=="Diproses"){

                                    echo '<span class="badge bg-primary">Diproses</span>';

                                }elseif($row['status']=="Selesai"){

                                    echo '<span class="badge bg-success">Selesai</span>';

                                }else{

                                    echo '<span class="badge bg-danger">Dibatalkan</span>';

                                }

                                ?>

                            </td>

                        </tr>

                    <?php

                        }

                    }else{

                    ?>

                    <tr>

                        <td colspan="5" class="text-center text-muted">

                            Belum ada data booking.

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- TESTIMONI -->

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-chat-left-quote text-success"></i>

                    Testimoni Terbaru

                </h5>

            </div>

            <div class="card-body">

                <?php

                if(mysqli_num_rows($testimoniTerbaru)>0){

                    while($t = mysqli_fetch_assoc($testimoniTerbaru)){

                ?>

                <div class="border rounded p-3 mb-3">

                    <h6 class="fw-bold mb-1">

                        <?= htmlspecialchars($t['nama']); ?>

                    </h6>

                    <small class="text-warning">

                        <?php

                        for($i=1;$i<=5;$i++){

                            if($i<=$t['rating']){

                                echo '<i class="bi bi-star-fill"></i>';

                            }else{

                                echo '<i class="bi bi-star"></i>';

                            }

                        }

                        ?>

                    </small>

                    <p class="text-muted mt-2 mb-0">

                        <?= nl2br(htmlspecialchars($t['isi_testimoni'])); ?>

                    </p>

                </div>

                <?php

                    }

                }else{

                    echo '<div class="text-center text-muted py-4">Belum ada testimoni.</div>';

                }

                ?>

            </div>

        </div>

    </div>

</div>
</div> <!-- End Row -->

</div> <!-- End Container -->
</div> <!-- End Content -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const bookingCtx = document.getElementById('bookingChart').getContext('2d');

new Chart(bookingCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelChart); ?>,
        datasets: [{
            label: 'Jumlah Booking',
            data: <?= json_encode($dataChart); ?>,
            backgroundColor: 'rgba(13,110,253,0.7)',
            borderColor: '#0d6efd',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: '#0b5ed7'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins:{
            legend:{
                display:true,
                position:'top'
            }
        },
        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    precision:0
                }
            }
        }
    }
});


const statusCtx = document.getElementById('statusChart').getContext('2d');

new Chart(statusCtx,{
    type:'pie',
    data:{
        labels: <?= json_encode($statusLabel); ?>,
        datasets:[{
            data: <?= json_encode($statusData); ?>,
            backgroundColor:[
                '#ffc107',
                '#0d6efd',
                '#198754',
                '#dc3545',
                '#6f42c1',
                '#20c997'
            ],
            borderWidth:2,
            borderColor:'#fff'
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                position:'bottom'
            }
        }
    }
});
</script>

<style>

.chart-container{
    position:relative;
    width:100%;
    height:340px;
}

.card{
    border-radius:16px;
}

.table td,
.table th{
    vertical-align:middle;
}

@media(max-width:992px){

    .chart-container{
        height:300px;
    }

}

@media(max-width:768px){

    .chart-container{
        height:260px;
    }

    .card-body{
        padding:15px;
    }

    .table{
        font-size:14px;
    }

}

@media(max-width:576px){

    .chart-container{
        height:220px;
    }

    h2{
        font-size:22px;
    }

    h5{
        font-size:16px;
    }

}

</style>

<?php include "footer.php"; ?>