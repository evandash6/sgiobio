<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index2()
    {
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        return view('landing/header',$data)
        .view('landing/inicio')
        .view('landing/footer');
    }

    public function index(){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        return view('header',$data)
        .view('home')
        .view('footer');
    }
}
