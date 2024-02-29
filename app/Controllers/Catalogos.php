<?php

namespace App\Controllers;
use App\Libraries\RestClient;

class Catalogos extends BaseController{

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
        if(!$session->email != null || !$session->email != ''){
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
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array('Catálogos'=>base_url().'Catalogos'));
        $data['color'] = 'gradiente-verde';
        $data['icono'] = 'fa fa-cogs';
        $data['titulo'] = 'Catálogos';
        $data['descripcion'] = 'Módulo de administración de usuarios';

        return view('plataforma/header',$data)
        .view('plataforma/catalogos/inicio')
        .view('plataforma/footer')
        .view('funciones');
    }

    public function ver_catalogo($tabla){
        echo json_encode(json_decode($this->api->post('query',array('query'=>'SELECT * FROM '.$tabla))->response,true)['resultado']);
    }

    public function catalogos_activo(){
        $valor = ($_POST['valor'] == '1')?'0':'1';
        if($_POST['tabla'] == 'vw_lenguas')
            $_POST['tabla'] = 'c_lenguas';
        if($_POST['tabla'] == 'vw_uso_tradicional')
            $_POST['tabla'] = 'c_uso_tradicional';
        echo $this->api->post('actualizar/'.$_POST['tabla'],array('datos[activo]'=>$valor,'condicion[id]'=>$_POST['ide']))->response;
    }

    public function elimina_catalogo($tabla,$ide){
        if($tabla == 'vw_lenguas')
            $tabla = 'c_lenguas';
        if($tabla == 'vw_uso_tradicional')
            $tabla = 'c_uso_tradicional';
        echo $this->api->post('eliminar/'.$tabla,array('condicion[id]'=>$ide))->response;
    }

    public function formato_catalogo($tabla){
        $arr = array();
        $generico = true;
        switch ($tabla) {
            case 'c_accesibilidad':
                $arr['titulo'] = 'Nueva Accesibilidad';
            break;
            case 'c_fisiografia':
                $arr['titulo'] = 'Nueva Fisiografía';
            break;
            case 'c_organizaciones':
                $arr['titulo'] = 'Nueva Organización';
            break;
            case 'c_orientacion':
                $arr['titulo'] = 'Nueva Orientación';
            break;
            case 'c_tipo_vegetacion':
                $arr['titulo'] = 'Nuevo Tipo de Vegetación';
            break;
            case 'c_uso_suelo':
                $arr['titulo'] = 'Nuevo Tipo de Uso de Suelo';
            break;
            case 'c_tipo_registro':
                $arr['titulo'] = 'Nuevo Tipo de Registro';
            break;
            case 'c_grupos':
                $arr['titulo'] = 'Nuevo Tipo de Grupo';
            break;
            case 'c_familia_linguistica':
                $arr['titulo'] = 'Nuevo Familias Lingüisticas';
            break;
            case 'c_huellas':
                $arr['titulo'] = 'Nuevo Tipo de Huellas';
            break;
            case 'c_tipo_planta':
                $arr['titulo'] = 'Nuevo Tipo de Planta';
            break;
            case 'c_vigor':
                $arr['titulo'] = 'Nuevo Tipo de Vigor';
            break;
            case 'c_forma_vida':
                $arr['titulo'] = 'Nuevo Tipo de Forma de Vida';
            break;
            case 'c_condicion':
                $arr['titulo'] = 'Nuevo Tipo de Condición';
            break;
            case 'c_tipo_impacto':
                $arr['titulo'] = 'Nuevo Tipo de Impacto';
            break;
            case 'c_grado_afectacion':
                $arr['titulo'] = 'Nuevo Grado de Afectación';
            break;
            case 'c_tipo_tenencia':
                $arr['titulo'] = 'Nuevo Tipo de Tenencia';
            break;
            case 'vw_lenguas':
                $arr['titulo'] = 'Nueva Lengua Indígena';
                $generico = false;
                $fam_lin_opc = $this->api->post('crea_select',array('tabla'=>'c_familia_linguistica','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
                $arr['formulario'] = '<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <div class="row"> <div class="col-md-6"> <label class="mr-2">Nombre: </label> <small style="font-size:12px">(Máx: 50 caracteres)</small> <input class="form-control" type="text" maxlength="50" name="nombre" required onblur="convertirAMayusculas(this)" autocomplete="off"> </div> <div class="col-md-6"> <label for="mr-2">Familia Lingüistica:</label> <select name="familia_lin_id" class="form-control select2" required>'.$fam_lin_opc.'</select> </div> </div> <div class="row mt-2"> <div class="col-md-6 offset-md-6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_save">Guardar</button> </div> </div> </form>';
            break;
            case 'vw_uso_tradicional':
                $arr['titulo'] = 'Nuevo Uso Tradicional';
                $generico = false;
                $grupo_opc = $this->api->post('crea_select',array('tabla'=>'c_grupos','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
                $arr['formulario'] = '<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <div class="row"> <div class="col-md-6"> <label class="mr-2">Nombre: </label> <small style="font-size:12px">(Máx: 100 caracteres)</small> <input class="form-control" type="text" maxlength="100" name="nombre" required onblur="convertirAMayusculas(this)" autocomplete="off"> </div> <div class="col-md-6"> <label for="mr-2">Grupo:</label> <select name="grupo_id" class="form-control select2" required>'.$grupo_opc.'</select> </div> </div> <div class="row mt-2"> <div class="col-md-6 offset-md-6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_save">Guardar</button> </div> </div> </form>';
            break;
        }
        if($generico)
            $arr['formulario'] = '<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <div class="row"> <div class="col-md-12"> <label class="mr-2">Nombre: </label> <small style="font-size:12px">(Máx: 50 caracteres)</small> <input class="form-control" type="text" maxlength="50" name="nombre" required onblur="convertirAMayusculas(this)" autocomplete="off"> </div> </div> <div class="row mt-2"> <div class="col-md-6 offset-md-6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_save">Guardar</button> </div> </div> </form>';
        echo json_encode($arr);
    }

    public function nvo_catalogo(){
        switch ($_POST['tabla']) {
            case 'c_accesibilidad':
            case 'c_fisiografia':
            case 'c_organizaciones':
            case 'c_orientacion':
            case 'c_tipo_vegetacion':
            case 'c_uso_suelo':
            case 'c_tipo_registro':
            case 'c_grupos':
            case 'c_familia_linguistica':
            case 'c_huellas':
            case 'c_tipo_planta':
            case 'c_vigor':
            case 'c_forma_vida':
            case 'c_condicion':
            case 'c_tipo_impacto':
            case 'c_grado_afectacion':
            case 'c_tipo_tenencia':
                echo $this->api->post('insertar/'.$_POST['tabla'],array('nombre'=>$_POST['nombre']))->response;
            break;
            case 'vw_lenguas':
                echo $this->api->post('insertar/c_lenguas',array('nombre'=>$_POST['nombre'],'familia_lin_id'=>$_POST['familia_lin_id']))->response;
            break;
            case 'vw_uso_tradicional':
                echo $this->api->post('insertar/c_uso_tradicional',array('nombre'=>$_POST['nombre'],'grupo_id'=>$_POST['grupo_id']))->response;
            break;
        }
    }

    public function editar_catalogo(){
        $arr = json_decode($_POST['datos'],true);
        $formato = array();
        $generico = true;
        $tabla = $_POST['tabla'];
        $titulo = '';
        unset($_POST['tabla']);
        switch ($tabla) {
            case 'c_accesibilidad':
                $formato['titulo'] = 'Actualizar Accesibilidad';
            break;
            case 'c_fisiografia':
                $formato['titulo'] = 'Atualizar Fisiografía';
            break;
            case 'c_organizaciones':
                $formato['titulo'] = 'Actualizar Organización';
            break;
            case 'c_orientacion':
                $formato['titulo'] = 'Actualizar Orientación';
            break;
            case 'c_tipo_vegetacion':
                $formato['titulo'] = 'Actualizar Tipo de Vegetación';
            break;
            case 'c_uso_suelo':
                $formato['titulo'] = 'Actualizar Tipo de Uso de Suelo';
            break;
            case 'c_tipo_registro':
                $formato['titulo'] = 'Actualizar Tipo de Registro';
            break;
            case 'c_grupos':
                $formato['titulo'] = 'Actualizar Tipo de Grupo';
            break;
            case 'c_familia_linguistica':
                $formato['titulo'] = 'Actualizar Familias Lingüisticas';
            break;
            case 'c_huellas':
                $formato['titulo'] = 'Actualizar Tipos de Huellas';
            break;
            case 'c_tipo_planta':
                $formato['titulo'] = 'Actualizar Tipos de Planta';
            break;
            case 'c_vigor':
                $formato['titulo'] = 'Actualizar Tipos de Vigor';
            break;
            case 'c_forma_vida':
                $formato['titulo'] = 'Actualizar Tipos de Forma de Vida';
            break;
            case 'c_condicion':
                $formato['titulo'] = 'Actualizar Tipos de Condición';
            break;
            case 'c_tipo_impacto':
                $formato['titulo'] = 'Actualizar Tipos de Impacto';
            break;
            case 'c_grado_afectacion':
                $formato['titulo'] = 'Actualizar Grados de Afectación';
            break;
            case 'c_tipo_tenencia':
                $formato['titulo'] = 'Actualizar Tipos de Tenencia';
            break;
            case 'vw_lenguas':
                $formato['titulo'] = 'Actualizar Lengua Indígena';
                $generico = false;
                $fam_lin_opc = $this->api->post('crea_select',array('tabla'=>'c_familia_linguistica','id'=>$arr['familia_lin_id'],'condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
                $formato['formulario'] = '<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <input type="hidden" name="id" value="'.$arr['id'].'"><div class="row"> <div class="col-md-6"> <label class="mr-2">Nombre: </label> <small style="font-size:12px">(Máx: 50 caracteres)</small> <input class="form-control" type="text" maxlength="50" name="nombre" required value="'.$arr['nombre'].'" onblur="convertirAMayusculas(this)" autocomplete="off"> </div> <div class="col-md-6"> <label for="mr-2">Familia Lingüistica:</label> <select name="familia_lin_id" class="form-control select2" required>'.$fam_lin_opc.'</select> </div> </div> <div class="row mt-2"> <div class="col-md-6 offset-md-6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_actualiza">Guardar</button> </div> </div> </form>';
            break;
            case 'vw_uso_tradicional':
                $formato['titulo'] = 'Actualizar Uso Tradicional';
                $generico = false;
                $grupo_opc = $this->api->post('crea_select',array('tabla'=>'c_grupos','id'=>$arr['grupo_id'],'condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
                $formato['formulario'] = '<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <input type="hidden" name="id" value="'.$arr['id'].'"><div class="row"> <div class="col-md-6"> <label class="mr-2">Nombre: </label> <small style="font-size:12px">(Máx: 100 caracteres)</small> <input class="form-control" type="text" maxlength="100" name="nombre" required value="'.$arr['nombre'].'" onblur="convertirAMayusculas(this)" autocomplete="off"> </div> <div class="col-md-6"> <label for="mr-2">Grupo:</label> <select name="grupo_id" class="form-control select2" required>'.$grupo_opc.'</select> </div> </div> <div class="row mt-2"> <div class="col-md-6 offset-md-6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_actualiza">Guardar</button> </div> </div> </form>';
            break;
        }

        if($generico){
            $formato['formulario'] ='<form id="frm_catalogo" class="text-left"> <input type="hidden" name="tabla" value="'.$tabla.'"> <input type="hidden" name="id" value="'.$arr['id'].'"><div class="row"> <div class="col m12"> <label class="mr-2">Nombre: </label><small style="font-size:12px">(Máx: 50 caracteres)</small> <input class="form-control" type="text" maxlength="50" name="nombre" required value="'.$arr['nombre'].'" onblur="convertirAMayusculas(this)" autocomplete="off"> </div> </div> <div class="row mt-2"> <div class="col m6 offset-m6 text-right"> <button type="button" class="btn btn-danger btx_cancelar">Cancelar</button> <button type="button" class="btn btn-success btx_actualiza">Guardar</button> </div> </div> </form>';
        }
        echo json_encode($formato);
    }

    public function actualiza_catalogo(){
        $tabla = $_POST['tabla'];
        $id = $_POST['id'];
        unset($_POST['tabla']);
        unset($_POST['id']);
        if($tabla == 'vw_lenguas')
            $tabla = 'c_lenguas';
        if($tabla == 'vw_uso_tradicional')
            $tabla = 'c_uso_tradicional';
        echo $this->api->post('actualizar/'.$tabla,array('datos'=>$_POST,'condicion[id]'=>$id))->response;
    }
}
