<script src="<?=base_url()?>assets/js/mask.min.js"></script>
<script src="<?=base_url()?>/assets/js/select2.min.js"></script>
<link href="<?=base_url()?>assets/css/select2.css" rel="stylesheet" />
<section>

<div id="vw_recupera" class="row align-items-center" style="display:none">
    <form id="frm_nuevo" action="">
        <div class="row">
            <div class="col-md-10 offset-md-1 bg-white shadow esquinas pt-3 pb-5 pl-4 pr-4">
                <div class="row"><div class="col-md-12 text-center"><h3>Registrar Nueva Cuenta</h3></div></div>
                <div class="row mt-4"> 
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Nombre: <span class="fs-char">(Máx 100 caracteres)</span></label>
                        <input type="text" name="nombre" maxlength="100" required class="form-control" onblur="convertirAMayusculas(this)">
                    </div>
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Primer Apellido: <span class="fs-char">(Máx 100 caracteres)</span></label>
                        <input type="text" name="ap1" maxlength="100" required class="form-control" onblur="convertirAMayusculas(this)">
                    </div>
                    <div class="col-3">
                        <label for="">Segundo Apellido: <span class="fs-char">(Máx 100 caracteres)</span></label>
                        <input type="text" name="ap2" maxlength="100" class="form-control" onblur="convertirAMayusculas(this)">
                    </div>
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Telefono: <span class="fs-char">(Máx 10 digitos)</span></label>
                        <div class="input-group">  
                            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" name="tel" maxlength="10" minlength="10" required class="form-control tel">
                        </div>
                    </div> 
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <Label><i class="obli">*</i>Correo: <span class="fs-char">(Máx 100 caracteres)</span></Label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required maxlength="100" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                    <div class="col-3">
                        <Label class="wrapper">Contraseña: <span data-tooltip="La contraseña debe de tener al menos ocho caracteres con al menos una letra mayúscula, una letra minúscula y un número."><i class="fa-solid fa-circle-info"></i></span></Label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" minlength="8" required class="form-control" placeholder="Ingresa tu contraseña" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$">
                            <button type="button" ide="password" class="input-group-text btn btn-outline-primary btx_view"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-3">
                        <Label class="wrapper">Repetir Contraseña: <span data-tooltip="La contraseña debe de tener al menos ocho caracteres con al menos una letra mayúscula, una letra minúscula y un número."><i class="fa-solid fa-circle-info"></i></span></Label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" minlength="8" required class="form-control" placeholder="Ingresa tu contraseña" name="password2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$">
                            <button type="button" ide="password2" class="input-group-text btn btn-outline-primary btx_view"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Tipo Institución/Organización:</label>
                        <select name="tipo_ins" required class="form-select"><?=$org_opc?></select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <Label><i class="obli">*</i>Nombre de la Institución/Organización: <span class="fs-char">(Máx 100 caracteres)</span></Label>
                        <input type="text" name="nombre_ins" class="form-control" required maxlength="100" onblur="convertirAMayusculas(this)">
                    </div>
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Estado:</label>
                        <select name="entidad" required class="form-select select2"><?=$estados_opc?></select>
                    </div>
                    <div class="col-3">
                        <label for=""><i class="obli">*</i>Municipio:</label>
                        <select name="municipio" required class="form-select select2"><option value="">Seleciona</option></select>
                    </div>
                </div>
                <div class="row mt-3 align-items-end">
                    <div class="col-5">
                        <label>¿Es Beneficiario del Programa de Servicios Ambientales?</label>
                        <select name="benef" class="form-control select2" required><option value="">Selecciona</option><option value="1">SI</option><option value="0">NO</option></select>
                    </div>
                    <div class="col-3">
                        <label for="">Folio de Apoyo:</label>
                        <input name="folio_apoyo" readonly onclick="buscar_modal()" class="form-control btx_modal" placeholder="Busca tu Folio de Apoyo">
                    </div>
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-success btx-send">Registrar Cuenta</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
<script>

    $('.tel').mask('0000000000');

    $('body').on('click', '.btx_view', function() {
        let ide = $(this).attr('ide');
        $(this).toggleClass('btn-outline-primary btn-primary');
        $('input[name='+ide+']').prop('type', function(index, value) {
            return value === 'password' ? 'text' : 'password';
        });
    });

    $('body').on('change','select[name=entidad]',function(){
        let cve_est = $(this).val();
        if(cve_est != '')
        api.get('<?=base_url()?>Login/lista_municipios/'+cve_est,true)
        .done(function(data){
            $('select[name=municipio]').html(data);
        })
    })

    $('body').on('change','select[name=benef]',function(){
        if($(this).val() == 1){
            buscar_modal();
        }
        else{
            $('input[name=folio_apoyo]').val('');
        }
    })

    $('body').on('click','.btx-send',function(){
        let forms = $('#frm_nuevo');
        let email = $('input[name=email]').val();
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            confirm('','¿El correo electrónico <b>'+email+'</b> es correcto?<br>','info',function(){
                let formData = new FormData(forms[0]);
                api.post('<?=base_url()?>login/save_nueva',formData,true)
                .done(function(data){
                    let res = JSON.parse(data);
                    if(res.status == 201){
                        alertf('Cuenta SGI-Biodiversidad creada!!',res.msg,'success',function(){
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
            },
            function(){
                return false;
            })
        }
    })

    function buscar_modal(){
        modal('','<div class="row"> <div class="col-md-12"><h3>Buscar</h3></div> </div> <div class="row mt-2 text-left"> <div class="col-md-12"> <label for="">Folio de Apoyo:</label> <div class="input-group"> <input name="buscar_folio" class="form-control" onblur="convertirAMayusculas(this)" placeholder="Busca tu Folio de Apoyo"> <button type="button" class="input-group-text btn btn-primary btx_buscar"><i class="fa-solid fa-search mr-2"></i>Buscar Folio</button> </div> </div> </div>');
    }

    $('body').on('click','.btx_buscar',function(){
        let folio = $('input[name=buscar_folio]').val();
        api.get('<?=base_url()?>Login/busca_folio/'+folio,false)
        .done(function(data){
            let res = JSON.parse(data);
            if(res.status == 200){
                alert('',res.html,'success');
                $('input[name=folio_apoyo]').val(res.folio);
            }
            else{
                alert('','Folio No Encontrado, revisa que el folio sea correcto e intenta nuevamente','info');
                $('input[name=folio_apoyo]').val('');
            }    

        })
    })

    $(document).ready(function(){
        $('#vw_recupera').fadeIn(1000);
        $('.select2').select2();
    })

</script>
