<section>
<div id="vw_recupera" class="row align-items-center" style="display:none">
    <form id="frm_recupera" action="">
        <input type="hidden" name="token" value="<?=$token?>">
        <br><br>
        <div class="row">
            <div class="col-4 offset-4 bg-white esquinas shadow pb-5 pt-3">
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h3 class="text">Nueva Contraseña</h3>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-10 offset-1">
                        <label for="">Correo:</label>
                        <h6 class="text-center text-secondary"><?=$email?></h6>
                        <hr>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-10 offset-md-1">
                        <Label class="wrapper">Contraseña: <span data-tooltip="La contraseña debe de tener al menos ocho caracteres con al menos una letra mayúscula, una letra minúscula y un número."><i class="fa-solid fa-circle-info"></i></span></Label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" minlength="8" required class="form-control" placeholder="Ingresa tu contraseña" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$">
                            <button type="button" ide="password" class="input-group-text btn btn-outline-primary btx_view"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-10 offset-md-1">
                        <Label class="wrapper">Repetir Contraseña: <span data-tooltip="La contraseña debe de tener al menos ocho caracteres con al menos una letra mayúscula, una letra minúscula y un número."><i class="fa-solid fa-circle-info"></i></span></Label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" minlength="8" required class="form-control" placeholder="Ingresa tu contraseña" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$">
                            <button type="button" ide="password2" class="input-group-text btn btn-outline-primary btx_view"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-10 offset-1 d-grid gap-2">
                        <button type="button" class="btn btn-success shadow btx-send"><i class="fa-solid fa-sync mr-2"></i> Cambiar Contraseña</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
<script>

    $(document).ready(function(){
        $('#vw_recupera').fadeIn(1000);
    })

    $('body').on('click', '.btx_view', function() {
        let ide = $(this).attr('ide');
        $(this).toggleClass('btn-outline-primary btn-primary');
        $('input[name='+ide+']').prop('type', function(index, value) {
            return value === 'password' ? 'text' : 'password';
        });
    });

    $('body').on('click','.btx-send',function(){
        let forms = $('#frm_recupera');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{                
            let formData = new FormData(forms[0]);
            let pass1 = $('input[name=password]').val();
            let pass2 = $('input[name=password2]').val();
            if(pass1 == pass2){
                api.post('<?=base_url()?>login/aplica_token',formData,true)
                .done(function(data){
                    // console.log(data)
                    let res = JSON.parse(data);
                    if(res.status == 200){
                        alertf('Cambio Realizado.!!','Ahora puedes utilizar tu nueva contraseña para acceder a SGI-Biodiversidad','info',function(){
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
            else{
                alertf('Las contraseñas no coinciden','','info',function(){
                    $('input[name=password2]').val('');
                });
            }
            
        }
    })

</script>
