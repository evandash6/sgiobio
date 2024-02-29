<?php

namespace App\Controllers;
use App\Libraries\RestClient;

class Usuarios extends BaseController{

    private $api;

    function __construct() {
        $this->api = new RestClient(['base_url' => 'http://10.254.250.24/public/api/','headers' => ['Ephylone'=>'sgibio'],'format' => ""]);
    }

    public function salir(){
        $session = session();
        $session->destroy();
        header('Location: '.base_url().'Login');
        exit;
    }

    private function seguridad(){      
        $session = session();
        if(!$session->email != null || !$session->email != '' || $session->perfil_id == '2'){
            $this->salir();
        }
    }

    private function links($arr){
        $html = '<a href="'.base_url().'Plataforma">SGI Biodiversidad</a>';
        $end = end($arr);
        foreach ($arr as $key => $value) {
            $html .= ($value === $end)?' / <a class="text-secondary" href="#">'.$key.'</a>':' / <a href="'.$value.'">'.$key.'</a>';
        }
        return $html;
    }

    public function index(){
        $this->seguridad();
        $session = session();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array('Usuarios'=>base_url().'Usuarios'));
        $data['color'] = 'gradiente-verde';
        $data['icono'] = 'fa fa-users';
        $data['titulo'] = 'Usuarios';
        $data['descripcion'] = 'Módulo de administración de usuarios';

        return view('plataforma/header',$data)
        .view('plataforma/usuarios/inicio')
        .view('plataforma/footer')
        .view('funciones');
    }

    public function muestra_usuarios(){
        echo $this->api->post('consulta_tabla',array('tabla'=>'vw_usuarios'))->response;
    }

    public function activar($id,$val){
        $activo = ($val==1)?0:1;
        echo $this->api->post('actualizar/usuarios',array('datos[activo]'=>$activo,'condicion[id]'=>$id))->response;

    }

    public function nuevo($id=null){
        $this->seguridad();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = ($id != null)?$this->links(array('Usuarios'=>base_url().'Usuarios','Edición'=>'#')):$this->links(array('Usuarios'=>base_url().'Usuarios','Nuevo'=>'#'));
        $data['icono'] = 'fa fa-users';
        $data['titulo'] = ($id != null)?'Usuarios - Edición':'Usuarios - Nuevo';
        $data['descripcion'] = 'Módulo de administración de usuarios';
        $data['org_opc'] = $this->api->post('crea_select',array('tabla'=>'c_organizaciones','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['estados_opc'] = $this->api->post('crea_select',array('tabla'=>'c_estados','campos'=>'cve_ent as id, nombre as nombre','condicion'=>'1=1 ORDER BY nombre'))['opciones'];
        $data['perfil_opc'] = $this->api->post('crea_select',array('tabla'=>'c_perfiles','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['datos'] = json_encode(($id != null)?json_decode($this->api->post('consulta_tabla',array('tabla'=>'vw_usuarios','condicion[id]'=>$id))->response,true)['resultado'][0]:array());

        return view('plataforma/header',$data)
        .view('plataforma/usuarios/nuevo')
        .view('plataforma/footer')
        .view('funciones');
    }

    public function save_usuario(){
        $session = session();
        $salida = array();

        //reglas basicas de validacion para formulario
        $rules = [
            'nombre'=> 'required|min_length[1]',
            'ap1' => 'required|min_length[1]',
            'tel' => 'required|numeric|max_length[10]',
            'email' => 'required|valid_email',
            'tipo_ins' => 'required|numeric',
            'nombre_ins' => 'required|min_length[1]',
            'entidad' => 'required',
            'municipio' => 'required',
            'benef'=>'required'
        ];

        //Aplica nueva regla si es beneficiario
        if($_POST['benef'] == 1){
            $rules = [
                'nombre'=> 'required|min_length[1]',
                'ap1' => 'required|min_length[1]',
                'tel' => 'required|numeric|max_length[10]',
                'email' => 'required|valid_email',
                'tipo_ins' => 'required|numeric',
                'nombre_ins' => 'required|min_length[1]',
                'entidad' => 'required',
                'municipio' => 'required',
                'benef'=>'required',
                'folio_apoyo'=>'required'
            ];
        }

        //Validacion de todas las reglas del formulario
        if (! $this->validateData($_POST, $rules)) {
            $salida = array('status'=>400,'msg'=>'Hay campos pendientes de información, revisa que todos los campos estan correctos..!','error'=>$this->validator->getErrors());
        }
        else{
            //Valida que ambas claves sea iguales
            if($_POST['password'] == $_POST['password2']){
                //Valida que sea un nuevo registro o que ya sea una actualizacion
                if($_POST['id'] != ''){
                    $arr = ($_POST['password'] != '')?array('email'=>$_POST['email'],'password'=>password_hash($_POST['password'],PASSWORD_DEFAULT),'perfil_id'=>$_POST['perfil_id']):array('email'=>$_POST['email'],'perfil_id'=>$_POST['perfil_id']);
                    $this->api->post('actualizar/usuarios',array('datos'=>$arr,'condicion[id]'=>$_POST['id']))->response;
                    $arr2 = array(
                        'nombre'=>$_POST['nombre'],
                        'ap1'=>$_POST['ap1'],
                        'ap2'=>$_POST['ap2'],
                        'telefono'=>$_POST['tel'],
                        'email'=>$_POST['email'],
                        'cve_est'=>$_POST['entidad'],
                        'cve_mun'=>$_POST['municipio'],
                        'tipo_org_id'=>$_POST['tipo_ins'],
                        'nombre_org'=>$_POST['nombre_ins'],
                        'benef_psa'=>$_POST['benef'],
                        'folio'=>$_POST['folio_apoyo'],
                        'usuario_id'=>$session->usuraio_id,
                        'fecha_registro'=>date('Y-m-d H:i:s')
                    );
                    $salida = json_decode($this->api->post('actualizar/generales_usuarios',array('datos'=>$arr2,'condicion[email]'=>$arr['email']))->response,true);
                }
                else{
                    $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'usuarios','condicion[email]'=>$_POST['email']))->response,true);
                    if($res['totalregistros']>0){
                        $salida = array('status'=>404,'msg'=>'El correo electrónico proporcionado <b>ya se encuentra registrado</b>..!');
                    }
                    else{
                        $arr = array('email'=>$_POST['email'],'password'=>password_hash($_POST['password'],PASSWORD_DEFAULT),'activo'=>1,'perfil_id'=>$_POST['perfil_id']);
                        $us = json_decode($this->api->post('insertar/usuarios',$arr)->response,true);
                        if($us['status'] == 201){
                            $arr2 = array(
                                'nombre'=>$_POST['nombre'],
                                'ap1'=>$_POST['ap1'],
                                'ap2'=>$_POST['ap2'],
                                'telefono'=>$_POST['tel'],
                                'email'=>$_POST['email'],
                                'cve_est'=>$_POST['entidad'],
                                'cve_mun'=>$_POST['municipio'],
                                'tipo_org_id'=>$_POST['tipo_ins'],
                                'nombre_org'=>$_POST['nombre_ins'],
                                'benef_psa'=>$_POST['benef'],
                                'folio'=>$_POST['folio_apoyo'],
                                'usuario_id'=>$session->usuraio_id,
                                'fecha_registro'=>date('Y-m-d H:i:s')
                            );
                            $salida = json_decode($this->api->post('insertar/generales_usuarios',$arr2)->response,true);
                        }
                        else{
                            $salida = array('status'=>500,'msg'=>'Error al registrar el nuevo usuario','error'=>$us['error']);
                        }
                    }
                }
            }
            else{
                $salida = array('status'=>401,'msg'=>'Valida que tus contraseñas sean iguales.');
            }
        }
        echo json_encode($salida);
    }

}
