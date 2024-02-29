<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<section>
<div id="vw_login" class="row align-items-center mt-5" style="display:none;">
    <form id="frm_login" action="#" method="post">
        <div class="col-md-4 col-12 offset-md-4 shadow pt-2 bg-white esquinas pl-3">  
            <div class="row mt-2">
                <div class="col-12 text-center">
                    <h3>Inicio de Sesión</h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-10 offset-1">
                    <Label>Correo: <span class="fs-char">(Máx 100 caracteres)</span></Label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" required name="email" class="form-control" maxlength="100" placeholder="ejemplo@correo.com">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-10 offset-1">
                    <Label class="wrapper">Contraseña: <span data-tooltip="La contraseña debe de tener al menos ocho caracteres con al menos una letra mayúscula, una letra minúscula y un número."><i class="fa-solid fa-circle-info"></i></span></Label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" required minlength="8" class="form-control" placeholder="Ingresa tu contraseña" name="password">
                        <button type="button" class="input-group-text btn btn-outline-success btx_view"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-8 offset-md-2 col-10 offset-1">
                <div class="g-recaptcha pl-2" data-sitekey="6LfjEmopAAAAAK9ekfhQxz2IFQNr6DHSPGv4Crjq"></div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1 col-10 offset-1 d-grid gap-2">
                    <button type="button" class="btn btn-success shadow btx-send"><i class="fa-solid fa-right-to-bracket mr-3"></i> Ingresar</button>
                </div>
            </div>
            <div class="row mt-5 pb-4">
                <div class="col-10 offset-1">
                    <div class="row text-center">
                    <div class="col-6">
                        <a href="<?=base_url()?>Login/recuperar">Recuperar contraseña</a>
                    </div>
                    <div class="col-6 border-left">
                        <a href="<?=base_url()?>Login/nueva">Crear nueva cuenta</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
<script>

    $('body').on('click', '.btx_view', function() {
        $(this).toggleClass('btn-outline-success btn-success');
        $('input[name=password]').prop('type', function(index, value) {
            return value === 'password' ? 'text' : 'password';
        });
    });

    var onloadCallback = function() {};

    $('body').on('click','.btx-send',function(){
        let response = grecaptcha.getResponse();
        let forms = $('#frm_login');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            if(response){
                if(response.length > 50){
                    let formData = new FormData(forms[0]);
                    api.post('<?=base_url()?>login/validar',formData,true)
                    .done(function(data){
                        let res = JSON.parse(data);
                        if(res.status == 200){
                            location.href = '<?=base_url()?>Plataforma'
                        }
                        else{
                            // console.log(res.msg);
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
        $('#vw_login').fadeIn(2000);
    })

</script>
