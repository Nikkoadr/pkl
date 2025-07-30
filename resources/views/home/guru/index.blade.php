@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Welcome Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Selamat Datang, {{ Auth::user()->nama }}</h3>
                </div>
                <div class="card-body">
                    <p>Semoga Hari Anda Menyenangkan!</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
