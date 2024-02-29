<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="Sistema SGI-Biodiversidad a traves de USFS" />
	<meta content="" name="Jose Manuel Peralta" />
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/tooltip.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/js/jquery.js"></script>
    <script src="<?=base_url()?>assets/js/popper.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- <script src="<?=base_url()?>assets/js/bootstrap.bundle.js"></script> -->
    <script src="<?=base_url()?>assets/js/swal.js"></script>
    <script src="<?=base_url()?>assets/js/lottie.js"></script>
    <script src="<?=base_url()?>assets/fonts/fontawesome/js/all.js"></script>
    <link href="<?=base_url()?>assets/fonts/fontawesome/css/all.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/vendor/css/wow.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/custom.css" rel="stylesheet" />    
    <title>Inicio | SGI Biodiversidad</title>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="90" class="fondo-gris">
    <!-- Start Preloader -->
<!-- <div class="loader">
    <div class="loader-inner">
        <div class="loader-blocks">
            <span class="block-1"></span>
            <span class="block-2"></span>
            <span class="block-3"></span>
            <span class="block-4"></span>
            <span class="block-5"></span>
            <span class="block-6"></span>
            <span class="block-7"></span>
            <span class="block-8"></span>
            <span class="block-9"></span>
            <span class="block-10"></span>
            <span class="block-11"></span>
            <span class="block-12"></span>
            <span class="block-13"></span>
            <span class="block-14"></span>
            <span class="block-15"></span>
            <span class="block-16"></span>
        </div>
    </div>
</div> -->
<!-- End Preloader -->
<!-- Header Start -->
<header id="home" class="cursor-light bg-white shadow">
    <div class="inner-header nav-icon">
        <div class="main-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-7"><img src="<?=$logo?>" class="img-fluid" alt="logo"></div>
                                </div>    
                           </div>
                            <div class="col-md-4 pl-5 pr-5"><img src="<?=$logos?>" class="img-fluid"></div>
                            <?Php if(isset($session)){ ?>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                    <button  id="sidemenu_toggle" class="btn btn-sm btn-dark">MENU <i class="fa fa-bars"></i></button>
                                    </div>
                                    <div class="col-md-9 text-left">
                                        <div class="dropdown">
                                            <ul class="dropdown-menu" style="width:13em">
                                                <li><a class="dropdown-item" href="<?=base_url()?>Perfiles/"><i class="fa fa-user mr-2"></i> Editar Perfil</a></li>
                                                <li><a class="dropdown-item" href="<?=base_url()?>Plataforma/salir"><i class="fa fa-power-off mr-2"></i> Salir</a></li>
                                            </ul>
                                            <span class="ml-2" data-bs-toggle="dropdown" style="cursor:pointer"><?=$session->email?><i class="fa fa-chevron-down ml-2"></i></span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <?Php } ?>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Side Nav-->
    <div class="side-menu hidden side-menu-opacity" style="background-color:#374154">
        <div class="inner-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="text-white btn" id="btn_sideNavClose"><i class="fa fa-times fs-40"></i></button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 d-none d-md-block"><img class="logo-oculto" src="<?=$logo?>" alt="logo"></div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1 d-none d-md-block"><img class="logos-oculto" src="<?=$logos?>" alt="logo"></div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12">
                        <nav class="side-nav w-100">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="<?=base_url()?>Plataforma">Inicio</a>
                                </li>
                                <?Php if($session->perfil_id == 1){ ?>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="<?=base_url()?>Usuarios">Usuarios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="<?=base_url()?>Catalogos">Catálogos</a>
                                </li>
                                <?Php } ?>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="<?=base_url()?>Registros">Unidades de Muestreo</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link scroll" href="#contact-sec">Registros de Monitoreo</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="#contact-sec">Reportes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link scroll" href="#contact-sec">Mapa</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <svg class="separator__svg" id="side-menu-svg" width="100%"  viewBox="0 0 100 100" preserveAspectRatio="none" fill="#fff" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <path d="M 100 100 V 10 L 0 100"/>
            <path d="M 30 73 L 100 18 V 10 Z" fill="#fff" stroke-width="0"/>
        </svg>
    </div>
</header>
<div class="container">
    <div class="row mt-4 align-items-center pt-2 pl-2 pb-2 <?=(isset($color))?$color:''?>">
        <div class="col-md-6">
            <h4><i class="<?=$icono?> mr-2"></i><?=$titulo?></h4>
            <small><?=$descripcion?></small>
        </div>
        <div class="col-md-6 text-right crums text-dark"><?=$links?></div>
    </div>
    <div class="row"><div class="col-md-12"><hr></div></div>