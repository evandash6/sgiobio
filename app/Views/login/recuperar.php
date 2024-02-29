<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<section>
<div id="vw_recupera" class="row align-items-center" style="display:none">
    <form id="frm_recupera" action="">
        <br><br>
        <div class="row">
            <div class="col-4 offset-4 bg-white esquinas shadow pb-5 pt-3">
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h3>Recuperar Contraseña</h3>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-10 offset-1">
                        <Label>Correo: <span class="fs-char mr-2">(Máx 100 caracteres)</span><span data-tooltip="El correo electrónico debe ser el mismo con el que inicias sesión en tu cuenta"><i class="fa-solid fa-circle-info"></i></span></Label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" required name="email" class="form-control" maxlength="100" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-10 offset-1">
                        <div class="g-recaptcha pl-5" data-sitekey="6LfjEmopAAAAAK9ekfhQxz2IFQNr6DHSPGv4Crjq"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-10 offset-1 d-grid gap-2">
                        <button type="button" class="btn btn-success shadow btx-send"><i class="fa-solid fa-clock-rotate-left mr-2"></i> Recuperar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
<script>

    var onloadCallback = function() {};

    $('body').on('click','.btx-send',function(){
        let response = grecaptcha.getResponse();
        let forms = $('#frm_recupera');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            if(response){
                if(response.length > 50){
                    let formData = new FormData(forms[0]);
                    api.post('<?=base_url()?>login/cambio_pwd',formData,true)
                    .done(function(data){
                        let res = JSON.parse(data);
                        console.log(res)
                        if(res.status == 201){
                            alertf('Solicitud Correcta.!!','Tienes hasta 24 hrs para actualizar tu clave, revisa tu correo electrónico y sigue las instrucciones.','info',function(){
                                location.href = '<?=base_url()?>Login';
                            });
                        }
                        else{
                            console.log(res.msg);
                            alert('Error',res.msg,'error');
                        }
                    })
                    .fail(function(res){
                        console.log(res)
                    })
                }
            }
            else{
                alert('Marca la casilla<br> "No soy un robot"..!!','','info')
            }
        }
    })

    $(document).ready(function(){
        $('#vw_recupera').fadeIn(1000);
    })

</script>
