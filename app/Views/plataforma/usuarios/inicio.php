<link rel="stylesheet" media="screen, print" href="<?=base_url()?>assets/css/tabulator.css">
<link href="<?=base_url()?>assets/css/tabulator.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/tabulator.min.js"></script>
    
    <section class="pt-2 mb-5">
        <div id="vw_usuarios" class="row align-items-center" style="display:none">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4>Usuarios Actuales</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn bg-info2 btx_nuevo"><i class="fa fa-user-plus mr-2"></i>Nuevo Usuario</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 bg-white shadow esquinas">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="" id="tabla_usuarios"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    var table;

    let columnas = [];
    let icons = function(cell, formatterParams){
        let color = (cell.getRow().getData().activo == 1)?'bg-activo':'bg-gray';
        return '' +
        '<button ide="'+cell.getRow().getData().id+'" val="'+cell.getRow().getData().activo+'" class="btx_activar btn btn-sm '+color+' mr-1" data-toggle="tooltip" data-placement="top" title="Botón para Activar/Desactivar Usuarios "><i class="fa fa-power-off"></i></button>' + 
        '<button ide="'+cell.getRow().getData().id+'" class="btx_editar btn btn-sm bg-orange text-white mr-1"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Botón para Asignar Perfil a Usuario "></i></button>';
    };
    columnas.push({title:'Acciones',hozAlign:'center',headerHozAlign:'center',formatter:icons,width:120},
        {title:"Nombre", field:"nombre_usuario",width:220, sorter:"string",headerHozAlign:'center',headerFilter:"input"},
        {title:"Correo", field:"email", sorter:"string",hozAlign:'center',headerHozAlign:'center',headerFilter:"input"},
        {title:"Estado", field:"entidad_txt", sorter:"string",headerHozAlign:'center',headerFilter:"input"},
        {title:"Municipio", field:"municipio_txt", sorter:"string",headerHozAlign:'center',headerFilter:"input"},
        {title:"Organización", field:"nombre_ins", sorter:"string",headerHozAlign:'center',headerFilter:"input"},
        {title:"Perfil", field:"perfil", sorter:"string",hozAlign:'center',headerHozAlign:'center',headerFilter:"input"}
    );
    
    table = new Tabulator("#tabla_usuarios", {
        layout:"fitDataFill",
        reactiveData:true,
        pagination:"local",
        paginationSize:15,
        columns:columnas
    });

    function actualiza_tabla(){
        api.get('/public/usuarios/muestra_usuarios')
        .done(function(res){
            table.setData(JSON.parse(res).resultado);
        })    
    }

    $(document).ready(function(){
        $('#vw_usuarios').fadeIn(1000);
        actualiza_tabla();
    })

    $('body').on('click','.btx_activar',function(){
        let ide = $(this).attr('ide');
        let val = $(this).attr('val');
        api.get('/public/usuarios/activar/'+ide+'/'+val,false)
        .done(function(res){
            actualiza_tabla();
        })   
    })

    $('body').on('click','.btx_editar',function(){
        let id = $(this).attr('ide');
        location.href = '<?=base_url()?>Usuarios/nuevo/'+id;
    })

    $('body').on('click','.btx_nuevo',function(){
        location.href = '<?=base_url()?>Usuarios/nuevo';
    })

    

</script>
