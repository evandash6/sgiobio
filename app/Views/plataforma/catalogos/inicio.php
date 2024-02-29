<script src="<?=base_url()?>/assets/js/select2.min.js"></script>
<link href="<?=base_url()?>assets/css/select2.css" rel="stylesheet"/>
<link rel="stylesheet" media="screen, print" href="<?=base_url()?>assets/css/tabulator.css">
<link href="<?=base_url()?>assets/css/tabulator.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/tabulator.min.js"></script>

<section  class="pt-2 mb-5">
    <div class="row">
        <div class="col-md-6">
            <h4>Catálogos Actuales</h4>
        </div>
    </div>
    <div class="row bg-white esquinas shadow mt-4">
        <div class="row mb-2">
            <div class="col-md-3 offset-md-9">
                <label for="">Catálogo:</label>
                <select name="catalogo" class="form-control select2">
                    <option value="">Selecciona</option>
                    <option value="c_accesibilidad">Tipos de accesibilidad</option>
                    <option value="c_fisiografia">Tipos de fisiografía</option>
                    <option value="c_organizaciones">Tipos de organizaciones</option>
                    <option value="c_orientacion">Tipos de orientación</option>
                    <option value="c_tipo_vegetacion">Tipos de vegetación</option>
                    <option value="c_uso_suelo">Tipos de uso de suelo</option>
                    <option value="c_tipo_registro">Forma de observación de las aves</option>
                    <option value="c_grupos">Tipos de grupos taxonómicos</option>
                    <option value="c_familia_linguistica">Tipos de familias lingüisticas</option>
                    <option value="c_huellas">Tipos de huellas</option>
                    <option value="c_tipo_planta">Tipos de plantas</option>
                    <option value="c_vigor">Tipos de vigor</option>
                    <option value="c_forma_vida">Tipos de forma de vida</option>
                    <option value="c_condición">Tipos de condición</option>
                    <option value="c_tipo_impacto">Tipos de impacto</option>
                    <option value="c_grado_afectacion">Tipos de grados de afectación</option>
                    <option value="vw_lenguas">Tipos de lenguas indígenas</option>
                    <option value="vw_uso_tradicional">Tipos de usos tradicionales</option>
                    <option value="c_tipo_tenencia">Tipos de tenencia de la tierra</option>
                </select>
            </div>
        </div>
        <hr>
        <div id="sec_nvo" class="row hide">
            <div class="col m2 offset-m8 text-right">
                <button title="" class="btn bg-info2 btx_nvo_registro">Nuevo Registro</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col m12">
                <div id="tabla_principal"></div>
            </div>
        </div>
    </div>
</section>
<script>
    var table;
    var tabla;
    var obj;

    function actualiza_tabla(){
        let cols  = [];
        let icons;

        switch (tabla) {
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
                icons = function(cell, formatterParams){
                    let color = (cell.getRow().getData().activo == 1)?'bg-activo':'bg-gray';
                    return '' +
                    '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().activo+'" tbl="'+tabla+'" class="btx_activar btn btn-sm '+color+' mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Activar/Desactivar Registros "><i class="fa fa-power-off"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_editar btn btn-sm bg-orange mr-1" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_eliminar btn btn-sm btn-danger mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Eliminar Registros "><i class="fa fa-trash"></i></button>';
                };
                cols = [
                    {title:'Acciones',hozAlign:'center',headerHozAlign:'center',width:150,formatter:icons},
                    {title:"Nombre", field:"nombre", sorter:"string",headerHozAlign:'center',hozAlign:'center',headerFilter:"input"},
                ]
            break;
            case 'vw_lenguas':
                icons = function(cell, formatterParams){
                    let color = (cell.getRow().getData().activo == 1)?'bg-activo':'bg-gray';
                    return '' +
                    '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().activo+'" tbl="'+tabla+'" class="btx_activar btn btn-sm '+color+' mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Activar/Desactivar Registros "><i class="fa fa-power-off"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_editar btn btn-sm bg-orange mr-1" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_eliminar btn btn-sm btn-danger mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Eliminar Registros "><i class="fa fa-trash"></i></button>';
                };
                cols = [
                    {title:'Acciones',hozAlign:'center',headerHozAlign:'center',width:150,formatter:icons},
                    {title:"Nombre", field:"nombre", sorter:"string",headerHozAlign:'center',hozAlign:'center',headerFilter:"input"},
                    {title:"Familia Lingüistica", field:"familia", sorter:"string",headerHozAlign:'center',hozAlign:'center',headerFilter:"input"},
                ]
            break;
            case 'vw_uso_tradicional':
                icons = function(cell, formatterParams){
                    let color = (cell.getRow().getData().activo == 1)?'bg-activo':'bg-gray';
                    return '' +
                    '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().activo+'" tbl="'+tabla+'" class="btx_activar btn btn-sm '+color+' mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Activar/Desactivar Registros "><i class="fa fa-power-off"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_editar btn btn-sm bg-orange mr-1" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></button>'+
                    '<button ide="'+cell.getRow().getData().id+'" tbl="'+tabla+'" class="btx_eliminar btn btn-sm btn-danger mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Eliminar Registros "><i class="fa fa-trash"></i></button>';
                };
                cols = [
                    {title:'Acciones',hozAlign:'center',headerHozAlign:'center',width:150,formatter:icons},
                    {title:"Nombre", field:"nombre", sorter:"string",headerHozAlign:'center',hozAlign:'center',headerFilter:"input"},
                    {title:"Grupo", field:"grupo", sorter:"string",headerHozAlign:'center',hozAlign:'center',headerFilter:"input"},
                ]
            break;
        }

        api.get('<?=base_url()?>Catalogos/ver_catalogo/'+tabla,false)
        .done(function(res){
            obj = res;
            table = new Tabulator("#tabla_principal", {
                layout:"fitColumns",
                reactiveData:true,
                pagination:"local",
                paginationSize:10,
                columns:cols,
                data:res
            });
        })
    }

    function busca_registro(registros, id) {
        return JSON.stringify(JSON.parse(registros).find(registro => registro.id === id));
    }

    $('.select2').select2();

    //FUncion para la deteccion de los cambios en los catalogos
    $('body').on('change','select[name=catalogo]',function(){
        validacion_select2();
        if($(this).val() != ''){
            tabla = $(this).val();
            actualiza_tabla(tabla);
            $('#sec_nvo').removeClass('hide');
        }
    })

    //Funcion de actualizacion de catalogos (ACTIVO O INACTIVO)
    $('body').on('click','.btx_activar',function(){
        let tbl = $(this).attr('tbl');
        let ide = $(this).attr('ide');
        let val = $(this).attr('val');
        let formData = new FormData();
        formData.append('tabla',tbl);
        formData.append('ide',ide);
        formData.append('valor',val);
        api.post('<?=base_url()?>Catalogos/catalogos_activo',formData,true)
        .done(function(data){
            let res = JSON.parse(data);
            if(res.status == 200)
                actualiza_tabla(tbl);
            else
                alertf('','Hubo un error al actualizar el registro','error',function(){ 
                    console.error(res)
                });
        })
        .fail(function(res){
            console.error(JSON.parse(res));
        })
    })

    //funcion para eliminar registros
    $('body').on('click','.btx_eliminar',function(){
        let ide = $(this).attr('ide');
        confirm('','¿Deseas eliminar el registro?','info',function(){
            api.get('<?=base_url()?>Catalogos/elimina_catalogo/'+tabla+'/'+ide)
            .done(function(data){
                let res = JSON.parse(data);
                if(res.status == 200)
                    actualiza_tabla(tabla);
                else
                    alertf('','Hubo un error al eliminar el registro','error',function(){ 
                        console.error(res)
                    });
            })
        },
        function(){
            alert('Eliminación Cancelada..!','','info');
        })
    })

    //mostrar el fomrulario de nuevo registro en los catalogos
    $('body').on('click','.btx_nvo_registro',function(){
        api.get('<?=base_url()?>Catalogos/formato_catalogo/'+tabla,false)
        .done(function(data){
            let res = JSON.parse(data);
            modal(res.titulo,res.formulario,800)
            $('.select2').select2();
        })
    })

    //funcion para cancelar el swal
    $('body').on('click','.btx_cancelar',function(){
        swal.close();
    })

    //Metodo para guardar los datos del nuevo registro en catalogos
    $('body').on('click','.btx_save',function(){
        let forms = $('#frm_catalogo');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            let formData = new FormData(forms[0]);
            api.post('<?=base_url()?>Catalogos/nvo_catalogo',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                if(res.status == 201)
                    alertf('Registro creado..!!','','success',function(){ 
                        actualiza_tabla(tabla);
                    })
                else
                    alertf('','Hubo un error al crear el registro','error',function(){ 
                        console.error(res.messages)
                    });
            })
            .fail(function(res){
                console.error(JSON.parse(res));
            })
        }
    })

    $('body').on('click','.btx_editar',function(){
        let ide = $(this).attr('ide');
        let tabla = $(this).attr('tbl');
        let formData = new FormData();
        formData.append('tabla',tabla);
        formData.append('datos',busca_registro(obj,ide));
        api.post('<?=base_url()?>Catalogos/editar_catalogo',formData,true)
        .done(function(data){
            let res = JSON.parse(data);
            modal(res.titulo,res.formulario,800)
            $('.select2').select2();
        })
        .fail(function(res){
            console.error(JSON.parse(res));
        })
    })

    $('body').on('click','.btx_actualiza',function(){
        let forms = $('#frm_catalogo');
        if(forms[0].reportValidity() === false){
            forms[0].classList.add('was-validated');
        }
        else{
            let formData = new FormData(forms[0]);
            api.post('<?=base_url()?>Catalogos/actualiza_catalogo',formData,true)
            .done(function(data){
                let res = JSON.parse(data);
                if(res.status == 200)
                    alertf('Registro actualizado..!!','','success',function(){ 
                        actualiza_tabla(tabla);
                    })
                else
                    alertf('','Hubo un error al actualizar el registro','error',function(){ 
                        console.error(res.messages)
                    });
            })
            .fail(function(res){
                console.error(JSON.parse(res));
            })
        }
    })
</script>