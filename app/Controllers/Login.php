<?php

namespace App\Controllers;
use App\Libraries\RestClient;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';

class Login extends BaseController{

    private $api;
    private $email;

    function __construct() {
        $this->api = new RestClient(['base_url' => 'http://10.254.250.24/public/api/','headers' => ['Ephylone'=>'sgibio'],'format' => ""]);
        // $this->email = \Config\Services::email();
        $this->email = new PHPMailer(true);
    }

    private function encriptar($texto) {
        $method = 'AES-256-CBC';
        $key = hash('sha256','sgibiodiversidad_2024', true);
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($texto, $method, $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    private function desencriptar($texto_encriptado) {
        $method = 'AES-256-CBC';
        list($encrypted_data, $iv) = explode('::', base64_decode($texto_encriptado), 2);
        $key = hash('sha256', 'sgibiodiversidad_2024', true);
        return openssl_decrypt($encrypted_data, $method, $key, 0, $iv);
    }

    private function generarToken($correo) {
        // Obtener la fecha y hora actual
        $fechaHoraActual = date("Y-m-d H:i:s");
        // Concatenar la fecha, la hora, el correo y la palabra secreta
        $token = $fechaHoraActual . "|" . $correo . "|BRUNO";
        // Generar un hash único para el token
        $tokenHash = hash('sha256', $token);
        return $tokenHash;
    }

    public function enviarCorreo($asunto,$mensaje,$email) {
        try {
            //Server settings
            // $this->email->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->email->isSMTP();                                            //Send using SMTP
            $this->email->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->email->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->email->Username   = 'sgi.biodiversidad@gmail.com';                     //SMTP username
            $this->email->Password   = 'dhmk iwvb jojz kvlk';                               //SMTP password
            $this->email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->email->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure =
        
            //Recipients
            $this->email->setFrom('sgi.biodiversidad@gmail.com', 'SGI Biodiversidad');
            $this->email->addAddress($email, '');     //Add a recipient
        
            //Content
            $this->email->CharSet = 'UTF-8';
            $this->email->isHTML(true);                                  //Set email format to HTML
            $this->email->Subject = $asunto;
            $this->email->Body    = $mensaje;
            $this->email->send();
            return true;
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$this->email->ErrorInfo}";
            return false;
        }
    }

    public function index(){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        return view('header',$data).view('login/login').view('footer').view('funciones');
    }
    public function recuperar(){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        return view('header',$data).view('login/recuperar').view('footer').view('funciones');
    }

    private function validar_fecha($fecha){
        $fec_act = new Time();
        // Fecha y hora proporcionada (ejemplo)
        $fec_final = new Time($fecha);
        $diferencia = $fec_act->diff($fec_final);

        if ($diferencia->days == 0 && $diferencia->h < 24) {
            return true;
        } else {
            return false;
        }
    }

    public function aplica_token(){
        $salida = array();
        if($_POST['password'] == $_POST['password2']){
            $email = json_decode($this->api->post('consulta_tabla',array('tabla'=>'cambio_pwd','condicion[token]'=>$_POST['token']))->response,true)['resultado'][0]['email'];
            $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $salida = json_decode($this->api->post('actualizar/usuarios',array('datos[password]'=>$pass,'condicion[email]'=>$email))->response,true);
            $this->api->post('actualizar/cambio_pwd',array('datos[activo]'=>0,'condicion[token]'=>$_POST['token']))->response;
        }
        else{
            $salida = array('status'=>400,'msg'=>'Contraseñas no coinciden..!');
        }
        echo json_encode($salida);
        exit;
    }

    public function nueva(){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['org_opc'] = $this->api->post('crea_select',array('tabla'=>'c_organizaciones','condicion'=>'activo=1 ORDER BY nombre'))['opciones'];
        $data['estados_opc'] = $this->api->post('crea_select',array('tabla'=>'c_estados','campos'=>'cve_ent as id, nombre as nombre','condicion'=>'1=1 ORDER BY nombre'))['opciones'];
        return view('header',$data).view('login/nueva').view('footer').view('funciones');
    }

    public function lista_municipios($cve_est){
        echo $this->api->post('crea_select',array('tabla'=>'c_municipios','campos'=>'cve_mun as id, nombre as nombre','condicion'=>'cve_ent="'.$cve_est.'" ORDER BY nombre'))['opciones'];
    }

    public function activacion($token){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $data['titulo'] = 'Activación de Cuenta';
        if(json_decode($this->api->post('actualizar/usuarios',array('datos[activo]'=>1,'condicion[email]'=>$this->desencriptar($token)))->response,true)['status'] == 200){
            $data['mensaje'] = 'La cuenta <b>'.$this->desencriptar($token).'</b> ha sido activada y podrás utilizarla a partir de ahora en el portal web SGI Biodiversidad.';
        }
        else{
            $data['mensaje'] = 'Token Invalido, revisa que tu cuenta ya este activa.';
        }
        return view('header',$data).view('login/activacion').view('footer').view('funciones');
    }

    public function save_nueva(){
        $salida = array();

        $rules = [
            'nombre'=> 'required|min_length[1]',
            'ap1' => 'required|min_length[1]',
            'tel' => 'required|numeric|max_length[10]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'password2' => 'required|min_length[8]',
            'tipo_ins' => 'required|numeric',
            'nombre_ins' => 'required|min_length[1]',
            'entidad' => 'required',
            'municipio' => 'required',
            'benef'=>'required'
        ];

        if($_POST['benef'] == 1){
            $rules = [
                'nombre'=> 'required|min_length[1]',
                'ap1' => 'required|min_length[1]',
                'tel' => 'required|numeric|max_length[10]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]',
                'password2' => 'required|min_length[8]',
                'tipo_ins' => 'required|numeric',
                'nombre_ins' => 'required|min_length[1]',
                'entidad' => 'required',
                'municipio' => 'required',
                'benef'=>'required',
                'folio_apoyo'=>'required'
            ];
        }

        if (! $this->validateData($_POST, $rules)) {
            $salida = array('status'=>400,'msg'=>'Error al guardar tu información, revisa que todos los campos estan correctos..!','error'=>$this->validator->getErrors());
        }
        else{
            if($_POST['password'] == $_POST['password2']){
                $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'usuarios','condicion[email]'=>$_POST['email']))->response,true);
                if($res['totalregistros']>0){
                    $salida = array('status'=>404,'msg'=>'El correo electrónico proporcionado <b>ya se encuentra registrado</b>..!');
                }
                else{
                    $arr = array('email'=>$_POST['email'],'password'=>password_hash($_POST['password'],PASSWORD_DEFAULT),'activo'=>0);
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
                            'fecha_registro'=>date('Y-m-d H:i:s')
                        );
                        $salida = json_decode($this->api->post('insertar/generales_usuarios',$arr2)->response,true);
                        $token = $this->encriptar($_POST['email']);
                        $mensaje = '<!DOCTYPE html> <html lang="es"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta name="viewport" content="width=device-width, initial-scale=1.0" /> </head> <body style="background-color: #c4c4ca;"> <table style="margin-top: 20px; background-color: white; width: 80%; margin-left: 10%; border-radius: 10px;"> <tr> <td style="text-align: center; color: #464646; padding-top: 20px;"><h2>Correo de activacion de cuenta</h2></td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td style="text-align: center;"><img style="width: 300px;" src="'.base_url().'assets/img/logo.png" /></td> </tr> <tr> <td style="text-align: center;"><img src="'.base_url().'assets/img/logos.png" style="width: 250px;" /></td> </tr> <tr> <td style="text-align: justify; padding-left: 30px; padding-right: 30px; font-weight: 400;"> <br /> Se ha creado un nueva cuenta utilizando este correo electrónico para el portal web de SGI Biodiversidad, este mensaje tiene la finalidad de activar tu cuenta presionando el siguiente botón, de no haber solicitado la cuenta, haz caso omiso a este correo electrónico. </td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td style="padding-left:40%"> <div style="background-color: #3f5d81; width: 200px; text-align: center; border-radius: 5px; height: 40px; padding-top: 20px;"> <a target="_blank" href="'.base_url().'Login/activacion/'.$token.'" style="text-decoration: none; color: white;">Activa cuenta</a> </div> </td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td><p style="text-align: center; font-size: 14px; color: #909192; padding-bottom: 10px;">Copyright © | 2024 | CONAFOR | SGI-Biodiversidad | Todos los derechos son reservados.</p></td> </tr> </table> </body> </html>';
                        if($this->enviarCorreo('Activación de cuenta SGI-Biodiversidad',$mensaje,$_POST['email'])){
                            $salida['msg'] = '<div class="text-justify opacity-2">Se te ha enviado un correo para la activación de tu cuenta SGI-Biodiversidad, revisalo y sigue las instrucciones. <br><br>Es posible que la información se encuentre en la bandeja de <b>Correo no deseado</b>. Para evitar este inconveniente agrega el correo electrónico <a href="#">sgi.biodiversidad@conafor.gob.mx</a> a tu lista de contactos.</div>';
                        }
                        else{
                            $salida = array('status'=>'400','msg'=>'Hubo un error al enviar la activación de cuenta, avisa al correo <a href="#">sgi.biodiversidad@conafor.gob.mx</a> del problema.');    
                        }
                    }
                    else{
                        $salida = array('status'=>500,'msg'=>'Error al registrar el nuevo usuario, avisa al administrador <a>sgi.biodiversidad@conafor.gob.mx</a>');
                    }
                }
            }
            else{
                $salida = array('status'=>401,'msg'=>'Valida que tus contraseñas sean iguales.');
            }
        }
        echo json_encode($salida);
    }

    public function nuevo_pass($token){
        $data['logo'] = base_url().'/assets/img/logo.png';
        $data['logos'] = base_url().'assets/img/logos.png';
        $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'cambio_pwd','condicion[token]'=>$token,'condicion[activo]'=>1))->response,true);
        if($res['totalregistros']>0){
            $vista = 'login/token_valido';
            $data['token'] = $token;
            $data['email'] = $res['resultado'][0]['email'];
        }
        else{
            $vista = 'login/token_novalido';
        }
        return view('header',$data).view($vista).view('footer').view('funciones');
    }
    
    public function validar(){
        $usuario = $_POST['email'];
        $password = $_POST['password'];
        $salida = array();
        if(strlen($_POST['g-recaptcha-response']) > 0){
            $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'vw_usu','condicion[email]'=>$usuario,'condicion[activo]'=>1))->response,true);
            if($res['totalregistros']>0){
                if(password_verify($password,$res['resultado'][0]['password'])){
                    $this->api->post('insertar/log_accesos',array('email'=>$usuario,'fecha_ingreso'=>date('Y-m-d H:i:s'),'ip'=>$_SERVER['REMOTE_ADDR']))->response;
                    $session = session();
                    $session->set('usuario_id',$res['resultado'][0]['id']);
                    $session->set('email',$res['resultado'][0]['email']);
                    $session->set('perfil_id',$res['resultado'][0]['perfil_id']);
                    $session->set('letra_um',$res['resultado'][0]['letra_um']);
                    $salida = array('status'=>200,'msg'=>'');
                }
                else{
                    $salida = array('status'=>400,'msg'=>'Usuario o Contraseña incorrectos..!');
                }
            }
            else{
                $salida = array('status'=>400,'msg'=>'Usuario o Contraseña incorrectos..!');
            }    
        }
        else{
            $salida = array('status'=>'400','msg'=>'Captcha No válido..!');
        }
        echo json_encode($salida);
        exit;
    }

    public function busca_folio($folio){
        $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'beneficiarios_apoyados','condicion[folio_apoyo]'=>$folio))->response,true);
        if($res['totalregistros']>0){
            echo json_encode(array('status'=>200,'folio'=>$res['resultado'][0]['folio_apoyo'],'html'=>'Folio Encontrado: <br><br> <b>Folio de Apoyo: </b>'.$res['resultado'][0]['folio_apoyo'].'<br><b>Nombre Predio: </b>'.$res['resultado'][0]['nombre_predio']));
        }
        else{
            echo json_encode(array('status'=>400));
        }
    }

    public function cambio_pwd(){
        $salida = array();
        if(isset($_POST['email']) && strlen($_POST['email']) > 0 ){
            if(strlen($_POST['g-recaptcha-response']) > 0){
                unset($_POST['g-recaptcha-response']);
                $res = json_decode($this->api->post('consulta_tabla',array('tabla'=>'usuarios','condicion[email]'=>$_POST['email']))->response,true);
                if($res['totalregistros']>0){
                    $_POST['fecha_registro'] = date('Y-m-d H:i:s');
                    $_POST['token'] = $this->generarToken($_POST['email']);
                    $mensaje = '<!DOCTYPE html> <html lang="es"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta name="viewport" content="width=device-width, initial-scale=1.0" /> </head> <body style="background-color: #c4c4ca;padding-top:30px"> <table style="margin-top: 20px; background-color: white; width: 80%; margin-left: 10%; border-radius: 10px;"> <tr> <td style="text-align: center; color: #464646; padding-top: 20px;"><h2>Correo de recuperación de contraseña</h2></td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td style="text-align: center;"> <img style="width: 300px;" src="'.base_url().'assets/img/logo.png"/> </td> </tr> <tr> <td style="text-align: center;"> <img src="'.base_url().'assets/img/logos.png" style="width: 250px;" /> </td> </tr> <tr> <td style="text-align: justify; padding-left: 30px; padding-right: 30px; font-weight: 400;"> <br /> Se ha solicitado desde el portal web de SGI Biodiversidad la recuperación de tu contraseña, la cual podrás cambiar presionando el siguiente botón, de no haber solicitado el cambio, haz caso omiso a este correo electrónico. </td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td style="padding-left:40%"> <div style="background-color: #3f815a; width: 200px; text-align: center; border-radius: 5px; height: 40px; padding-top: 20px;"> <a target="_blank" href="'.base_url().'Login/nuevo_pass/'.$_POST['token'].'" style="text-decoration: none; color: white;">Cambiar Contraseña</a> </div> </td> </tr> <tr> <td style="padding-left: 50px; padding-right: 50px;"><hr /></td> </tr> <tr> <td><p style="text-align: center; font-size: 14px; color: #909192; padding-bottom: 10px;">Copyright © | 2024 | CONAFOR | SGI-Biodiversidad | Todos los derechos son reservados.</p></td> </tr> </table> </body> </html>';
                    if($this->enviarCorreo('Recuperación de Contraseña SGI-Biodiversidad',$mensaje,$_POST['email'])){
                        $salida = json_decode($this->api->post('insertar/cambio_pwd',$_POST)->response,true);
                        $salida['msg'] = '<div class="text-justify opacity-2">Tienes 24hrs para actualizar tu contraseña, revisa tu correo electrónico y sigue las instrucciones. <br><br> Puede que el correo de recuperación se encuentre en tu bandeja de <b>Correo no deseado</b>, por lo cual es necesario agregar el correo electrónico <a href="#">sgi.biodiversidad@conafor.gob.mx</a> a tu lista de contactos para evitar este tipo de inconveniente.</div>';
                    }
                    else{
                        $salida = array('status'=>'400','msg'=>'Hubo un error al enviar el correo de recuperación de contraseña, intenta mas tarde o avisa al correo <a href="#">sgi.biodiversidad@conafor.gob.mx</a> del problema.');    
                    }
                }
                else{
                    $salida = array('status'=>'400','msg'=>'Email No válido..!!');    
                }
            }
            else{
                $salida = array('status'=>'400','msg'=>'Captcha No válido..!');
            }
        }
        else{
            $salida = array('status'=>'400','msg'=>'Falta el correo electronico..!');
        }
        echo json_encode($salida);
        exit;
    }
}