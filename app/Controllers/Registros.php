<?php

namespace App\Controllers;
use App\Libraries\RestClient;
use Lablnet\Encryption;
use Verot\Upload\Upload;

class Registros extends BaseController{

    private $api;
    private $upf;

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

    private function encriptar($data) {
        $x = new Encryption('e63fd453f656bf9218a7d55b86c2d51b7a');
        return $x->encrypt($data);
    }
    
    private function desencriptar($data) {
        $x = new Encryption('e63fd453f656bf9218a7d55b86c2d51b7a');
        return $x->decrypt($data);
    }

    private function complementa_ceros($numero,$cantidad){
        return str_pad($numero, $cantidad, "0", STR_PAD_LEFT);
    }

    private function valida_componentes($valor,$arr){
        $ax = explode(',',$arr);
        return(in_array($valor,$ax) !== false)?'btn-success active':'btn-outline-secondary disabled';
    }

    public function unidades_muestreo_html(){
        $session = session();
        $arr = array();

        $ccc = 0;
        $res = ($session->perfil_id == 1)?json_decode($this->api->post('consulta_tabla',array('tabla'=>'vw_unidades_muestreo'))->response,true):json_decode($this->api->post('consulta_tabla',array('tabla'=>'vw_unidades_muestreo','condicion[brigadista_id]'=>$session->usuario_id))->response,true);
    
        if($res['totalregistros']>0)
        foreach ($res['resultado'] as $key => $value) {


            $arr[$ccc]['botones'] = '
            <button um="'.$value['clave_um'].'" ide="'.$this->encriptar($value['id']).'" class="btn btn-danger btx_eliminar_um mr-2" data-tooltip="Eliminar registro"><i class="fa fa-trash"></i></button> 
            <button onclick="location.href=\''.base_url().'Registros/edicion/'.$this->encriptar($value['id']).'\'" class="btn bg-orange" data-tooltip="Editar registro"><i class="fa fa-edit"></i></button>';
            $arr[$ccc]['id'] = $value['id'];
            $arr[$ccc]['enc_id'] = $this->encriptar($value['id']);
            $arr[$ccc]['consecutivo'] = $value['consecutivo'];
            $arr[$ccc]['clave_um'] = $value['clave_um'];
            $arr[$ccc]['html_um'] = '

            
            <div style="font-size:14px;" class="pt-2">
            <table>
                <tr>
                    <td class="pl-2"><b>Clave UM</b></td>
                    <td class="text-right pl-5"><b>Estado:</b></td>
                    <td class="pl-2 text-left">'.$value['entidad'].'</td>
                    <td class="pl-5 text-right"><b>Nombre Predio:</b></td>
                    <td class="pl-2 text-left">'.$value['nombre_predio'].'</td>
                </tr>
                <tr>
                    <td class="pr-4 pl-3"><h5>'.$value['clave_um'].'</h5></td>
                    <td class="text-right"><b>Municipio:</b></td>
                    <td class="pl-2 text-left">'.$value['municipio'].'</td>
                    <td class="pl-5 text-right"><b>Fecha de Trazo:</b></td>
                    <td class="pl-2 text-left">'.$value['fecha_trazo'].'</td>
                </tr>
            </table>
            <div class="row mt-2 mb-2"> <div class="col-md-10 offset-md-1"><hr></div></div>
            <div class="row mt-2 mb-2 text-center"> <div class="col-md-8 offset-md-2"><b>Componentes de monitoreo de la unidad</b></div></div>
            <div class="row mt-2">
                <div class="col-md-12 text-center componentes">
                    <button type="button" ide="CA"  class="cnte btn '.$this->valida_componentes('CA',$value['componentes']).' btn-lg" data-tooltip="Conteo de aves"><i class="fa fa-dove"></i></button>
                    <button type="button" ide="CHE" class="cnte btn '.$this->valida_componentes('CHE',$value['componentes']).' btn-lg" data-tooltip="Conteo de huellas y excretas"><i class="fa fa-paw"></i></button>
                    <button type="button" ide="FT"  class="cnte btn '.$this->valida_componentes('FT',$value['componentes']).' btn-lg" data-tooltip="Fototrampeo de núcleo"><i class="fa fa-camera"></i></button>
                    <button type="button" ide="VM"  class="cnte btn '.$this->valida_componentes('VM',$value['componentes']).' btn-lg" data-tooltip="Vegetación menor"><i class="fa fa-seedling"></i></button>
                    <button type="button" ide="AR"  class="cnte btn '.$this->valida_componentes('AR',$value['componentes']).' btn-lg" data-tooltip="Arbustos y repoblado"><i class="fab fa-pagelines"></i></button>
                    <button type="button" ide="AVM" class="cnte btn '.$this->valida_componentes('AVM',$value['componentes']).' btn-lg" data-tooltip="Arbolado o vegetación mayor"><i class="fa fa-tree"></i></button>
                    <button type="button" ide="IA"  class="cnte btn '.$this->valida_componentes('IA',$value['componentes']).' btn-lg" data-tooltip="Impactos ambientales"><i class="fa fa-fire"></i></button>
                </div>
            </div></div>';
            $arr[$ccc]['avance'] = '<h4>'.$value['avance'].' %</h4>'; 
            $ccc++;
        }
        
        return json_encode($arr);
    }

    public function index(){
        $this->seguridad();
        $session = session();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array('Unidades de Muestreo'=>base_url().'Registros'));
        $data['icono'] = 'fa fa-route';
        $data['color'] = 'gradiente-purple';
        $data['titulo'] = 'Unidades de Muestreo';
        $data['descripcion'] = 'Módulo de administración de unidades de muestreo y sus registros de monitoreo';

        return view('plataforma/header',$data)
        .view('plataforma/registros/inicio')
        .view('plataforma/footer')
        .view('funciones');
    }

    public function unidad(){
        $this->seguridad();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array('Unidades de Muestreo'=>base_url().'Registros','Nueva UM'=>''));
        $data['icono'] = 'fa fa-route';
        $data['color'] = 'gradiente-purple';
        $data['titulo'] = 'Unidades de Muestreo - <span class="text-dark">Nueva UM</span>';
        $data['descripcion'] = 'Módulo de administración de unidades de muestreo y sus registros de monitoreo';
        $data['estados_opc'] = $this->api->post('crea_select',array('tabla'=>'c_estados','campos'=>'cve_ent as id, nombre as nombre','condicion'=>'1=1 ORDER BY nombre'))['opciones'];
        $data['tenencia_opc'] = $this->api->post('crea_select',array('tabla'=>'c_tipo_tenencia','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];

        return view('plataforma/header',$data)
        .view('plataforma/registros/nuevaum')
        .view('plataforma/footer')
        .view('funciones');
    }

    public function genera_um(){
        $session = session();
        $salida = array();

        $rules = [
            'entidad'=> 'required',
            'municipio'=> 'required',
            'nombre_predio'=> 'required|max_length[100]',
            'tenencia_id' => 'required',
            'fecha_trazo' => 'required'
        ];

        if (! $this->validateData($_POST, $rules)) {
            $salida = array('status'=>400,'msg'=>'Hay campos pendientes de información, revisa que todos los campos estan correctos..!','error'=>$this->validator->getErrors());
        }
        else{
            //Contador de unidades de muestreo pertenecientes al usuario
            $contador = json_decode($this->api->post('query',array('query'=>'SELECT MAX(consecutivo) as cantidad FROM unidades_muestreo WHERE brigadista_id = "'.$session->usuario_id.'" '))->response,true)['resultado'][0]['cantidad'] + 1;

            //Generamos clave de unidad de muestreo
            $clave = 'UM'.$_POST['entidad'].$_POST['municipio'].$session->letra_um.$this->complementa_ceros($contador,3);

            $_POST['consecutivo'] = $contador;
            $_POST['clave'] = $clave;
            $_POST['tipo_brigadista'] = $session->letra_um;
            $_POST['usuario_id'] = $_POST['brigadista_id'] = $session->usuario_id;
            $_POST['fecha_act'] = date('Y-m-d H:i:s');
            
            //insertamos los registros
            $res = json_decode($this->api->post('insertar/unidades_muestreo',$_POST)->response,true);
            if($res['status'] == 201){
                $salida = array('status'=>201,'msg'=>'Unidad de Muestreo Creada<br><h2>'.$clave.'</h2>','id'=>$this->encriptar($res['lastid']));
            }
            else{
                $salida = array('status'=>400,'msg'=>'Error al crear al unidad de muestreo','error'=>$res);
            }            
        }
        echo json_encode($salida);
    }

    public function edicion($id){
        $this->seguridad();
        $data['session'] = session();
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['links'] = $this->links(array('Unidades de Muestreo'=>base_url().'Registros','Edicion UM'=>''));
        $data['icono'] = 'fa fa-route';
        $data['color'] = 'gradiente-purple';
        $data['titulo'] = 'Unidades de Muestreo - <span class="text-dark">Edición UM</span>';
        $data['descripcion'] = 'Módulo de administración de unidades de muestreo y sus registros de monitoreo';
        $data['tenencia_opc'] = $this->api->post('crea_select',array('tabla'=>'c_tipo_tenencia','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['acc_opc'] = $this->api->post('crea_select',array('tabla'=>'c_accesibilidad','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['basicas_opc'] = $this->api->post('crea_select',array('tabla'=>'c_basicas','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['suelo_opc'] = $this->api->post('crea_select',array('tabla'=>'c_uso_suelo','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['vegetacion_opc'] = $this->api->post('crea_select',array('tabla'=>'c_tipo_vegetacion','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['orientacion_opc'] = $this->api->post('crea_select',array('tabla'=>'c_orientacion','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['fisiografia_opc'] = $this->api->post('crea_select',array('tabla'=>'c_fisiografia','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['datos']= json_encode(json_decode($this->api->post('consulta_tabla',array('tabla'=>'vw_unidades_muestreo','condicion[id]'=>$this->desencriptar($id)))->response,true)['resultado'][0]);
        $data['guid'] = $id;

        return view('plataforma/header',$data)
        .view('plataforma/registros/edicion')
        .view('plataforma/footer')
        .view('funciones');

    }
    
    public function save_edicion(){
        $session = session();
        $salida = array();

        $rules = [
            'nombre_predio'=> 'required|max_length[100]',
            'tenencia_id'=> 'required|numeric',
            'fecha_trazo'=> 'required',
            'latitud_centro' => 'required|greater_than_equal_to[14]|less_than_equal_to[33]',
            'longitud_centro' => 'required|greater_than_equal_to[-119]|less_than_equal_to[-86]',
            'error_precision'=>'required|numeric',
            'altitud'=>'required|numeric',
            'accesibilidad'=>'required|numeric',
            'suelo'=>'required|numeric',
            'tipo_vegetacion'=>'required|numeric',
            'exposicion'=>'required|numeric',
            'fisiografia'=>'required|numeric',
            'latitud_1' => 'required|greater_than_equal_to[14]|less_than_equal_to[33]',
            'longitud_1' => 'required|greater_than_equal_to[-119]|less_than_equal_to[-86]',
            'error_precision_1'=>'required|numeric',
            'altitud_1'=>'required|numeric',
            'latitud_2' => 'required|greater_than_equal_to[14]|less_than_equal_to[33]',
            'longitud_2' => 'required|greater_than_equal_to[-119]|less_than_equal_to[-86]',
            'error_precision_2'=>'required|numeric',
            'altitud_2'=>'required|numeric',
            'latitud_3' => 'required|greater_than_equal_to[14]|less_than_equal_to[33]',
            'longitud_3' => 'required|greater_than_equal_to[-119]|less_than_equal_to[-86]',
            'error_precision_3'=>'required|numeric',
            'altitud_3'=>'required|numeric',
            'latitud_4' => 'required|greater_than_equal_to[14]|less_than_equal_to[33]',
            'longitud_4' => 'required|greater_than_equal_to[-119]|less_than_equal_to[-86]',
            'error_precision_4'=>'required|numeric',
            'altitud_4'=>'required|numeric',
            'componentes'=>'required'
        ];

        if (!$this->validateData($_POST, $rules)) {
            $salida = array('status'=>400,'msg'=>'Hay campos pendientes de información, revisa que todos los campos estan correctos o cumplan con el formato solicitado!','error'=>$this->validator->getErrors());
        }
        else{
            if(!isset($_POST['brigadista_id'])){
                $_POST['brigadista_id'] = $session->usuario_id;
            }
            $_POST['usuario_id'] = $session->usuario_id;
            $_POST['fecha_act'] = date('Y-m-d');

            $id = $_POST['guid'];
            unset($_POST['guid']);
            $res2 = json_decode($this->api->post('actualizar/unidades_muestreo',array('datos'=>$_POST,'condicion[id]'=>$this->desencriptar($id)))->response,true);

            if($res2['status'] = 200){
                $f_centro = (isset($_FILES['foto_centro']))?$this->save_image($_FILES['foto_centro'],'foto_centro',$this->desencriptar($id)):array('status'=>true,'msg'=>'');
                $f_sum1 = (isset($_FILES['foto_sum1']))?$this->save_image($_FILES['foto_sum1'],'foto_sum1',$this->desencriptar($id)):array('status'=>true,'msg'=>'');
                $f_sum2 = (isset($_FILES['foto_sum2']))?$this->save_image($_FILES['foto_sum2'],'foto_sum2',$this->desencriptar($id)):array('status'=>true,'msg'=>'');
                $f_sum3 = (isset($_FILES['foto_sum3']))?$this->save_image($_FILES['foto_sum3'],'foto_sum3',$this->desencriptar($id)):array('status'=>true,'msg'=>'');
                $f_sum4 = (isset($_FILES['foto_sum4']))?$this->save_image($_FILES['foto_sum4'],'foto_sum4',$this->desencriptar($id)):array('status'=>true,'msg'=>'');

                if($f_centro && $f_sum1 && $f_sum2 && $f_sum3 && $f_sum4){
                    $salida = array('status'=>200,'msg'=>'Cambio Guardados');
                }
                else{
                    $salida = array('status'=>400,'msg'=>$f_centro['msg'].','.$f_sum1['msg'].','.$f_sum2['msg'].','.$f_sum3['msg'].','.$f_sum4['msg']);
                }
            }
            else{
                $salida = array('status'=>400,'msg'=>'Error al guardar los datos','error'=>$res2);
            }
        }
        echo json_encode($salida);
    }

    public function elimina_um($id){
        $ide = $this->desencriptar($id);
            echo $this->api->post('eliminar/unidades_muestreo',array('condicion[id]'=>$ide))->response;
    }

    public function save_image($file_img,$campo,$id){
        $handle = new Upload($file_img,'Es_es');   
        $handle->file_max_size = '6291456'; // 6Mb
        $name = uniqid();
        $handle->file_new_name_body = $name;
        $handle->allowed   = array('jpg','png','jpeg');
        $handle->process('galeria/');
        if ($handle->processed) {
            $this->api->post('actualizar/unidades_muestreo',array('datos['.$campo.']'=>$name.'.'.$handle->file_src_name_ext,'condicion[id]'=>$id))->response;
            $handle->clean();
            return array('status'=>true);
          } 
        else {
            return array('status'=>false,'msg'=>explode('.',$handle->error)[0]);
        }
    }

}
