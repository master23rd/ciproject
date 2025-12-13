<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($page_title) ? $page_title . ' | ' : '' ?>ShopHub Admin</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.4.5/styles/overlayscrollbars.min.css">
    
    <!-- AdminLTE CSS - Using CDN for reliability -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --lte-primary: #ff6b35;
            --lte-sidebar-bg: #343a40;
        }
        
        .small-box {
            border-radius: .5rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            position: relative;
            display: block;
            margin-bottom: 1rem;
        }
        
        .small-box > .inner {
            padding: 1rem;
        }
        
        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            white-space: nowrap;
        }
        
        .small-box p {
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        .small-box .small-box-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 4rem;
            opacity: .15;
        }
        
        .small-box .small-box-icon svg {
            width: 70px;
            height: 70px;
        }
        
        .small-box > .small-box-footer {
            background-color: rgba(0,0,0,.1);
            color: rgba(255,255,255,.8);
            display: block;
            padding: .5rem;
            text-align: center;
            text-decoration: none;
        }
        
        .small-box > .small-box-footer:hover {
            background-color: rgba(0,0,0,.15);
            color: #fff;
        }
        
        .small-box.text-bg-primary {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8b35 100%) !important;
            color: #fff;
        }
        
        .small-box.text-bg-success {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
            color: #fff;
        }
        
        .small-box.text-bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%) !important;
            color: #000;
        }
        
        .small-box.text-bg-info {
            background: linear-gradient(135deg, #0dcaf0 0%, #31d2f2 100%) !important;
            color: #000;
        }
        
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: .5rem;
            background-color: #fff;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
        }
        
        .info-box .info-box-icon {
            border-radius: .5rem;
            align-items: center;
            display: flex;
            font-size: 1.875rem;
            justify-content: center;
            text-align: center;
            width: 70px;
        }
        
        .info-box .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.8;
            flex: 1;
            padding: 0 10px;
        }
        
        .sidebar-brand {
            background: linear-gradient(135deg, #ff6b35 0%, #e55a2b 100%);
        }
        
        .nav-sidebar .nav-link.active {
            background-color: #ff6b35 !important;
            color: #fff !important;
        }
        
        .btn-primary {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }
        
        .btn-primary:hover {
            background-color: #e55a2b;
            border-color: #e55a2b;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
