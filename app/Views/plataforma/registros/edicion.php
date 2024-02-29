<script src="<?=base_url()?>/assets/js/fancybox.umd.js"></script>
<link href="<?=base_url()?>assets/css/fancybox.css" rel="stylesheet" />
<script src="<?=base_url()?>/assets/js/select2.min.js"></script>
<link href="<?=base_url()?>assets/css/select2.css" rel="stylesheet" />
<section id="vw_nueva" class="pt-2 mb-5 " style="display:none;">
    <form id="frm_nuevaum" action="#" enctype="multipart/form-data">
        <input type="hidden" name="guid" value="<?=$guid?>">
        <div class="row mt-2">
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
                <div class="row">
                    <div class="col-md-2 offset-md-10">
                        <label for="">Clave UM:</label>
                        <input type="text" class="form-control text-center" disabled name="clave_um">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="">Estado:</label>
                        <input type="text" class="form-control" disabled name="entidad">
                    </div>
                    <div class="col-md-3">
                        <label for="">Municipio:</label>
                        <input type="text" class="form-control" disabled name="municipio">
                    </div>
                    <div class="col-md-3">
                        <label for=""><i class="obli">*</i>Predio: <span class="fs-char">(Máx 100 caracteres)</span></label>
                        <input name="nombre_predio" required maxlength="100" type="text" class="form-control" onblur="convertirAMayusculas(this)" title="">
                    </div>
                    <div class="col-md-2">
                        <label for=""><i class="obli">*</i>Tipo de tenencia:</label>
                        <select name="tenencia_id" required class="form-control select2" required><?=$tenencia_opc?></select>
                    </div>
                    <div class="col-md-2">
                        <label for=""><i class="obli">*</i>Fecha de trazado:</label>
                        <input name="fecha_trazo" required type="date" class="form-control">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12"><h6>Centro de la Unidad</h6><hr></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Latitud (N): <span data-tooltip="El valor permitido es de 14.0000 a 32.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                <input type="number" class="form-control cna" name="latitud_centro" min="14.0000" max="32.9999" step="0.0001"  placeholder="Ejemplo: 14.0001" required>
                            </div>
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Longitud (W): <span data-tooltip="El valor permitido es de -86.0000 a -118.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                <input type="text" class="form-control cna" name="longitud_centro" min="-118.9999" max="-86.0000" pattern="^(-8[6-9]|-9[0-9]|-10[0-9]|-11[0-8])\.\d{4}$" step="0.0001"  placeholder="Ejemplo: -101.1000" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Error de precisión (m):</label>
                                <input type="number" class="form-control" name="error_precision"  required>
                            </div>
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Altitud (msnm):</label>
                                <input type="number" class="form-control" name="altitud"  required>
                            </div>
                        </div>
                        <div class="row mt-2 align-items-end">
                            <div class="col-md-10">
                                <label for="">Fotografía del centro de la U.M.: <span class="fs-char">(Tamaño máximo 5 Mb) (Formatos jpg, png, jpeg)</span></label>
                                <input type="file" required class="form-control" name="foto_centro" accept="image/jpeg,image/png, image/png">
                            </div>
                            <div class="col-md-2">
                                <a ft="foto_centro" data-fancybox="" class="hide"><button type="button" data-tooltip="Ver fotografía del centro de la UM" class="btn bg-activo"><i class="fa fa-camera"></i></button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12"><h6>Características Físicas</h6><hr></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Accesibilidad:</label>
                                <select class="form-select select2" name="accesibilidad" required><?=$acc_opc?></select>
                            </div>
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Uso de suelo:</label>
                                <select class="form-select select2" name="suelo" required><?=$suelo_opc?></select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for=""><span class="text-danger">*</span> Tipo de vegetación:</label>
                                <select class="form-select select2" name="tipo_vegetacion" required><?=$vegetacion_opc?></select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Exposición (Orientación de ladera):</label>
                                <select class="form-select select2" name="exposicion" required><?=$orientacion_opc?></select>
                            </div>
                            <div class="col-md-6">
                                <label for=""><span class="text-danger">*</span> Fisiografía:</label>
                                <select class="form-select select2" name="fisiografia" required><?=$fisiografia_opc?></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-3 text-center"><h6>Subunidades de Muestreo</h6><hr></div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-10 text-center"><h6>Subunidad de Muestreo 1 (SUM1)</h6></div>
                            <div class="col-md-2 btn btx_sum" rel="sum1"><i class="fa fa-sort-down"></i></div>
                        </div>
                        <hr>
                        <div id="sum1" style="display:none">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Latitud (N): <span data-tooltip="El valor permitido es de 14.0000 a 32.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="number" class="form-control cna" name="latitud_1" min="14.0000" max="32.9999" step="0.0001"  placeholder="Ejemplo: 14.0001" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Longitud (W): <span data-tooltip="El valor permitido es de -86.0000 a -118.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="text" class="form-control cna" name="longitud_1" min="-118.9999" max="-86.0000" pattern="^(-8[6-9]|-9[0-9]|-10[0-9]|-11[0-8])\.\d{4}$" step="0.0001"  placeholder="Ejemplo: -101.1000" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Error de precisión (m):</label>
                                    <input type="number" class="form-control" name="error_precision_1"  required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Altitud (msnm):</label>
                                    <input type="number" class="form-control" name="altitud_1"  required>
                                </div>
                            </div>
                            <div class="row mt-2 align-items-end">
                                <div class="col-md-10">
                                    <label for="">Fotografía del centro de la SUM 1:</label>
                                    <input type="file" class="form-control" name="foto_sum1" required aria-label="Upload" accept="image/jpeg,image/png, image/png">
                                </div>
                                <div class="col-md-2">
                                    <a ft="foto_sum1" data-fancybox="" class="hide"><button type="button" data-tooltip="Ver fotografía del centro de la SUM 1" class="btn bg-activo"><i class="fa fa-camera"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-10 text-center"><h6>Subunidad de Muestreo 2 (SUM2)</h6></div>
                            <div class="col-md-2 btn btx_sum" rel="sum2"><i class="fa fa-sort-down"></i></div>
                        </div>
                        <hr>
                        <div id="sum2" style="display:none">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Latitud (N): <span data-tooltip="El valor permitido es de 14.0000 a 32.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="number" class="form-control cna" name="latitud_2" min="14.0000" max="32.9999" step="0.0001"  placeholder="Ejemplo: 14.0001" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Longitud (W): <span data-tooltip="El valor permitido es de -86.0000 a -118.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="text" class="form-control cna" name="longitud_2" min="-118.9999" max="-86.0000" pattern="^(-8[6-9]|-9[0-9]|-10[0-9]|-11[0-8])\.\d{4}$" step="0.0001"  placeholder="Ejemplo: -101.1000" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Error de precisión (m):</label>
                                    <input type="number" class="form-control" name="error_precision_2"  required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Altitud (msnm):</label>
                                    <input type="number" class="form-control" name="altitud_2"  required>
                                </div>
                            </div>
                            <div class="row mt-2 align-items-end">
                                <div class="col-md-10">
                                    <label for="">Fotografía del centro de la SUM 2:</label>
                                    <input type="file" class="form-control" required name="foto_sum2" aria-label="Upload" accept="image/jpeg,image/png, image/png">
                                </div>
                                <div class="col-md-2">
                                    <a ft="foto_sum2" data-fancybox="" class="hide"><button type="button" data-tooltip="Ver fotografía del centro de la SUM 2" class="btn bg-activo"><i class="fa fa-camera"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-10 text-center"><h6>Subunidad de Muestreo 3 (SUM3)</h6></div>
                            <div class="col-md-2 btn btx_sum" rel="sum3"><i class="fa fa-sort-down"></i></div>
                        </div>
                        <hr>
                        <div id="sum3" style="display:none">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Latitud (N): <span data-tooltip="El valor permitido es de 14.0000 a 32.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="number" class="form-control cna" name="latitud_3" min="14.0000" max="32.9999" step="0.0001"  placeholder="Ejemplo: 14.0001" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Longitud (W): <span data-tooltip="El valor permitido es de -86.0000 a -118.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="text" class="form-control cna" name="longitud_3" min="-118.9999" max="-86.0000" pattern="^(-8[6-9]|-9[0-9]|-10[0-9]|-11[0-8])\.\d{4}$" step="0.0001"  placeholder="Ejemplo: -101.1000" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Error de precisión (m):</label>
                                    <input type="number" class="form-control" name="error_precision_3"  required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Altitud (msnm):</label>
                                    <input type="number" class="form-control" name="altitud_3"  required>
                                </div>
                            </div>
                            <div class="row mt-2 align-items-end">
                                <div class="col-md-10">
                                    <label for="">Fotografía del centro de la SUM 3:</label>
                                    <input type="file" class="form-control" required name="foto_sum3" aria-label="Upload" accept="image/jpeg,image/png, image/png">
                                </div>
                                <div class="col-md-2">
                                    <a ft="foto_sum3" data-fancybox="" class="hide"><button type="button" data-tooltip="Ver fotografía del centro de la SUM 3" class="btn bg-activo"><i class="fa fa-camera"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-10 text-center"><h6>Subunidad de Muestreo 4 (SUM4)</h6></div>
                            <div class="col-md-2 btn btx_sum" rel="sum4"><i class="fa fa-sort-down"></i></div>
                        </div>
                        <hr>
                        <div id="sum4" style="display:none">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Latitud (N): <span data-tooltip="El valor permitido es de 14.0000 a 32.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="number" class="form-control cna" name="latitud_4" min="14.0000" max="32.9999" step="0.0001"  placeholder="Ejemplo: 14.0001" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Longitud (W): <span data-tooltip="El valor permitido es de -86.0000 a -118.9999"><i class="fa-solid fa-circle-info"></i></span></label>
                                    <input type="text" class="form-control cna" name="longitud_4" min="-118.9999" max="-86.0000" pattern="^(-8[6-9]|-9[0-9]|-10[0-9]|-11[0-8])\.\d{4}$" step="0.0001"  placeholder="Ejemplo: -101.1000" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Error de precisión (m):</label>
                                    <input type="number" class="form-control" name="error_precision_4"  required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><span class="text-danger">*</span> Altitud (msnm):</label>
                                    <input type="number" class="form-control" name="altitud_4"  required>
                                </div>
                            </div>
                            <div class="row mt-2 align-items-end">
                                <div class="col-md-10">
                                    <label for="">Fotografía del centro de la SUM 4:</label>
                                    <input type="file" class="form-control" required name="foto_sum4" aria-label="Upload" accept="image/jpeg,image/png, image/png">
                                </div>
                                <div class="col-md-2">
                                    <a ft="foto_sum4" data-fancybox="" class="hide"><button type="button" data-tooltip="Ver fotografía del centro de la SUM 4" class="btn bg-activo"><i class="fa fa-camera"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 text-center">
                    <div class="col-md-6">
                        <h6>Reubicaciones <span data-tooltip="Esta información se captura solo cuando la unidad de muestreo ha sido reubicada en otro sitio"><i class="fa fa-circle-info"></i></span></h6>
                    </div>
                    <div class="col-md-6">
                        <h6>Componentes a Realizar</h6>
                        <input type="text" name="componentes" style="opacity:0;width:1px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="">¿El sitio ha sido reubicado?:</label>
                                <select name="reubicacion" class="form-control select2"><?=$basicas_opc?></select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Motivo de reubicación:</label>
                                <textarea name="motivo_reubicacion" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center componentes">
                        <button type="button" ide="CA"  class="cnte btn btn-outline-success btn-lg" data-tooltip="Conteo de aves"><i class="fa fa-dove"></i></button>
                        <button type="button" ide="CHE" class="cnte btn btn-outline-success btn-lg" data-tooltip="Conteo de huellas y excretas"><i class="fa fa-paw"></i></button>
                        <button type="button" ide="FT"  class="cnte btn btn-outline-success btn-lg" data-tooltip="Fototrampeo de núcleo"><i class="fa fa-camera"></i></button>
                        <button type="button" ide="VM"  class="cnte btn btn-outline-success btn-lg" data-tooltip="Vegetación menor"><i class="fa fa-seedling"></i></button>
                        <button type="button" ide="AR"  class="cnte btn btn-outline-success btn-lg" data-tooltip="Arbustos y repoblado"><i class="fab fa-pagelines"></i></button>
                        <button type="button" ide="AVM" class="cnte btn btn-outline-success btn-lg" data-tooltip="Arbolado o vegetación mayor"><i class="fa fa-tree"></i></button>
                        <button type="button" ide="IA"  class="cnte btn btn-outline-success btn-lg" data-tooltip="Impactos ambientales"><i class="fa fa-fire"></i></button>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-md-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-md-9 text-right">
                        <button type="button" class="btn btn-save btn-primary btx_actualizar"><i class="fa fa-save mr-2"></i>Actualizar UM</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<script>

    var obj = <?=$datos?>;
    var cnte = [];

    function valida_componentes(){
        if(!$('input[name=componentes]').val()){
            alert('','¡Falta elegir al menos un componente de monitoreo a realizarse!','info')
            return false;
        }
        else{
            return true;
        }
    }

    function valida_dato(a){
        return (a !== undefined && a !== null)?true:false;
    }


    $(document).ready(function(){
        $('#vw_nueva').fadeIn(2000);

        if(Object.keys(obj).length > 10){
            $('input').each(function(index, element) {
                let nombre = $(this).attr('name');
                if($(this).attr('type') != 'file' && valida_dato(obj[nombre]))
                $(this).val(obj[nombre]);
            });

            $('select').each(function(index, element) {
                let nombre = $(this).attr('name');
                if(valida_dato(obj[nombre]))
                    $(this).val(obj[nombre])
            });

            let cve_est = $('select[name=entidad]').val();
            if(cve_est != '')
            api.get('<?=base_url()?>Login/lista_municipios/'+cve_est,true)
            .done(function(data){
                $('select[name=municipio]').html(data);
                $('select[name=municipio]').val(obj.municipio)
            })

            if(valida_dato(obj.componentes)){
                let compo = obj.componentes.split(',')
                compo.forEach(element => {
                    $('button[ide='+element+']').click();
                });
            }

            if(valida_dato(obj.foto_centro)){
                $('input[name=foto_centro]').removeAttr('required')
                $('a[ft=foto_centro]').removeClass('hide').addClass('fancy').attr('data-src','<?=base_url()?>galeria/'+obj.foto_centro).attr('data-caption','Foto Centro UM');
            }
            if(valida_dato(obj.foto_sum1)){
                $('input[name=foto_sum1]').removeAttr('required')
                $('a[ft=foto_sum1]').removeClass('hide').addClass('fancy').attr('data-src','<?=base_url()?>galeria/'+obj.foto_sum1).attr('data-caption','Foto SUM 1');
            }
            if(valida_dato(obj.foto_sum2)){
                $('input[name=foto_sum2]').removeAttr('required')
                $('a[ft=foto_sum2]').removeClass('hide').addClass('fancy').attr('data-src','<?=base_url()?>galeria/'+obj.foto_sum2).attr('data-caption','Foto SUM 2');
            }
            if(valida_dato(obj.foto_sum3)){
                $('input[name=foto_sum3]').removeAttr('required')
                $('a[ft=foto_sum3]').removeClass('hide').addClass('fancy').attr('data-src','<?=base_url()?>galeria/'+obj.foto_sum3).attr('data-caption','Foto SUM 3');
            }
            if(valida_dato(obj.foto_sum4)){
                $('input[name=foto_sum4]').removeAttr('required')
                $('a[ft=foto_sum4]').removeClass('hide').addClass('fancy').attr('data-src','<?=base_url()?>galeria/'+obj.foto_sum4).attr('data-caption','Foto SUM 4');
            }

            Fancybox.bind('.fancy', {});
            
        }
        $('.select2').select2();
    })


    $('body').on('change','input[name=foto_centro]',function(e){
        valida_carga($(this),e,5.5)
    })

    $('body').on('change','input[name^="foto_sum"]',function(e){
        valida_carga($(this),e,5.5)
    })

    $('body').on('click','.btx_sum',function(){
        let rel = $(this).attr('rel');
        $('#'+rel).slideToggle();
        if($(this).children().hasClass('fa-sort-up')){
            $(this).children().remove('fa-sort-up').addClass('fa-sort-down');
        }
        else{
            $(this).children().remove('fa-sort-down').addClass('fa-sort-up');
        }
    })
    
    $('body').on('blur','.cna',function(){
        let n = $(this).val();
        $(this).val(parseFloat(n).toFixed(4))
    })

    $('body').on('click','.cnte',function(){
        let ide = $(this).attr('ide');
        if($(this).hasClass('btn-outline-success')){
            cnte.push(ide);
            $(this).removeClass('btn-outline-success').addClass('btn-success');
        }
        else{
            $(this).removeClass('btn-success').addClass('btn-outline-success');
            cnte.splice(cnte.indexOf(ide),1);
        }
        $('input[name=componentes]').val(cnte)
    })

    $('body').on('click','.btx_actualizar',function(){
        let forms = $('#frm_nuevaum');
        $('#sum1').show();
        $('#sum2').show();
        $('#sum3').show();
        $('#sum4').show();

        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
            validacion_select2();
        }
        else{
            if(valida_componentes()){
            let formData = new FormData(forms[0]);
            api.post('<?=base_url()?>Registros/save_edicion',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                if(res.status == 200){
                    alertf(res.msg,'','success',function(){
                        location.reload();
                    });
                }
                else{
                    console.log(res);
                    alert('Error',res.msg,'error');
                }
            })
            .fail(function(res){
                console.log(res)
            })
            }
        }
    })

</script>