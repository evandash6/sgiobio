<?php

namespace App\Controllers;

class Plataforma extends BaseController
{

    public function salir(){
        $session = session();
        $session->destroy();
        header('Location: '.base_url().'Login');
        exit;
    }

    private function seguridad(){      
        $session = session();
        if(!$session->email != null || !$session->email != ''){
            $this->salir();
        }
    }

    private function links($arr){
        $html = '<a href="'.base_url().'Plataforma">SGI Biodiversidad</a>';
        $end = end($arr);
        foreach ($arr as $key => $value) {
            $html .= ($value === $end)?' | <a href="'.$value.'">'.$key.'</a>':'<a href="'.$value.'">'.$key.'</a>';
        }
        return $html;
    }

    public function index(){
        $this->seguridad();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array());
        $data['icono'] = 'fa fa-home';
        $data['titulo'] = 'Inicio';
        $data['descripcion'] = 'Módulo de Inicio';
        return view('plataforma/header',$data)
        .view('plataforma/inicio')
        .view('plataforma/footer');
    }
}
