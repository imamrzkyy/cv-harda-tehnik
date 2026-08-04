<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin | CV. Harda Tehnik Mandiri</title>
    <link rel="icon" href="<?= $base_url ?>assets/images/logo/logo CV HD.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#f4f6f9;
            margin:0;
            padding:0;
        }

        a{
            text-decoration:none;
        }

        img{
            max-width:100%;
        }

        .page-title{
            font-size:28px;
            font-weight:700;
            color:#0d6efd;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
        }

        .btn{
            border-radius:10px;
        }

        .badge{
            font-weight:500;
        }

        .table{
            vertical-align:middle;
            min-width:1000px;
        }

        .table-responsive{
            overflow-x:auto;
            -webkit-overflow-scrolling:touch;
        }

        .table th{
            white-space:nowrap;
        }

        .table td{
            white-space:nowrap;
        }

        .table td:nth-child(4){
            white-space:normal;
            min-width:280px;
        }

        /* ==========================
            SIDEBAR
        ========================== */

        .sidebar{

            position:fixed;

            top:0;
            left:0;

            width:260px;
            height:100vh;

            background:#0d6efd;

            color:#fff;

            z-index:1050;

            display:flex;
            flex-direction:column;

            transition:.3s;

        }

        .sidebar-brand{

            display:flex;

            align-items:center;

            gap:12px;

            padding:20px;

            border-bottom:1px solid rgba(255,255,255,.15);

        }

        .sidebar-brand img{

            width:55px;

            height:55px;

            border-radius:50%;

            background:#fff;

            padding:6px;

        }

        .sidebar-brand h5{

            margin:0;

            font-weight:700;

        }

        .sidebar-brand small{

            opacity:.8;

        }

        .sidebar-menu{

            list-style:none;

            padding:15px 0;

            margin:0;

            flex:1;

        }

        .sidebar-menu li{

            margin:6px 12px;

        }

        .sidebar-menu a{

            display:flex;

            align-items:center;

            gap:12px;

            padding:12px 15px;

            border-radius:10px;

            color:#fff;

            transition:.3s;

        }

        .sidebar-menu a:hover{

            background:rgba(255,255,255,.15);

        }

        .sidebar-menu a.active{

            background:#fff;

            color:#0d6efd;

            font-weight:600;

        }

        .sidebar-menu i{

            font-size:20px;

        }

        .sidebar-footer{

            padding:20px;

            border-top:1px solid rgba(255,255,255,.15);

        }

        .logout-btn{

            display:flex;

            justify-content:center;

            align-items:center;

            gap:10px;

            padding:12px;

            background:#dc3545;

            color:#fff;

            border-radius:10px;

            font-weight:600;

        }

        .logout-btn:hover{

            background:#bb2d3b;

            color:#fff;

        }

        /* ==========================
            CONTENT
        ========================== */

       .content{
            margin-left:260px;
            padding:30px;
            width:calc(100% - 260px);
            overflow-x:hidden;
            transition:.3s;
        }

        /* ==========================
            OVERLAY
        ========================== */

        .overlay{

            position:fixed;

            inset:0;

            background:rgba(0,0,0,.45);

            display:none;

            z-index:1040;

        }

        .overlay.show{

            display:block;

        }

        /* ==========================
            TOPBAR MOBILE
        ========================== */

        .mobile-header{

            display:none;

            position:sticky;

            top:0;

            z-index:1030;

            background:#fff;

            padding:12px 15px;

            box-shadow:0 2px 10px rgba(0,0,0,.08);

            align-items:center;

            justify-content:space-between;

        }

        .mobile-header button{

            border:none;

            background:#0d6efd;

            color:#fff;

            width:42px;

            height:42px;

            border-radius:10px;

            font-size:22px;

        }

        /* ==========================
            RESPONSIVE
        ========================== */

        @media (max-width:991px){

            .sidebar{

                left:-260px;

            }

            .sidebar.show{

                left:0;

            }

            .content{
                margin-left:0;
                width:100%;
                padding:30px;
            }

            .table-responsive{
                overflow-x:auto;
            }

            .table{
                min-width:950px;
            }

            .card-body{
                padding:15px !important;
            }

            .page-title,
            h3{
                font-size:24px;
            }

            .mobile-header{

                display:flex;

            }

        }

    </style>

</head>

<body>

<div class="overlay" id="overlay"></div>

<div class="mobile-header">

    <button id="menuButton">

        <i class="bi bi-list"></i>

    </button>

    <strong>Admin Panel</strong>

</div>