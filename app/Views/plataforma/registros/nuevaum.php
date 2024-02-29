<script src="<?=base_url()?>/assets/js/select2.min.js"></script>
<link href="<?=base_url()?>assets/css/select2.css" rel="stylesheet" />
<section id="vw_nueva" class="pt-2 mb-5 " style="display:none;">
    <div class="row">
        <div class="col-md-6">
            <h4>Nueva Unidad de Muestreo</h4>
        </div>
    </div>
    <form id="frm_nuevaum" action="#">
        <div class="row mt-3">
            <div class="col-md-12 bg-white esquinas shadow">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información General</h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <b><i class="obli">*</i> <small class="text-secondary">Campos Obligatorios</small></b>
                    </div>
                    <hr>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for=""><i class="obli">*</i>Estado:</label>
                        <select name="entidad" required class="form-control select2"><?=$estados_opc?></select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><i class="obli">*</i>Municipio:</label>
                        <select name="municipio" required class="form-control select2"></select>
                    </div>
                    <div class="col-md-3">
                        <label for=""><i class="obli">*</i>Predio: <span class="fs-char">(Máx 100 caracteres)</span></label>
                        <input name="nombre_predio" required maxlength="100" type="text" class="form-control" onblur="convertirAMayusculas(this)">
                    </div>
                    <div class="col-md-2">
                        <label for=""><i class="obli">*</i>Tipo de tenencia:</label>
                        <select name="tenencia_id" required class="form-control select2"><?=$tenencia_opc?></select>
                    </div>
                    <div class="col-md-2">
                        <label for=""><i class="obli">*</i>Fecha de trazado:</label>
                        <input name="fecha_trazo" required type="date" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <hr>
                        <button type="button" class="btn bg-info2 shadow btx_nueva" data-tooltip="Boton para crear tu nueva clave de unidad de muestreo">Crear Clave de Unidad de Muestreo</button>
                    </div>
                </div>
                <div id="sec_edicion">
                    
                </div>
            </div>
        </div>
    </form>
</section>

</div>

<script>

    $(document).ready(function(){
        $('#vw_nueva').fadeIn(2000);
        $('.select2').select2();
    })


    $('body').on('change','select[name=entidad]',function(){
        let cve_est = $(this).val();
        if(cve_est != '')
        api.get('<?=base_url()?>Login/lista_municipios/'+cve_est,true)
        .done(function(data){
            $('select[name=municipio]').html(data);
        })
    })

    $('body').on('click','.btx_nueva',function(){
        let forms = $('#frm_nuevaum');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
            validacion_select2();
        }
        else{
            let formData = new FormData(forms[0]);
            api.post('<?=base_url()?>Registros/genera_um',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 201){
                    alertf('',res.msg,'success',function(){
                        location.href = '<?=base_url()?>Registros/edicion/'+res.id;
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
    })

</script>
