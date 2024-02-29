<link rel="stylesheet" media="screen, print" href="<?=base_url()?>assets/css/tabulator.css">
<link href="<?=base_url()?>assets/css/tabulator.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/tabulator.min.js"></script>
<section id="vw_unidad" class="pt-2 mb-5 " style="display:none;">
    <div class="row">
        <div class="col-md-6">
            <h4>Unidades de Muestreo Actuales</h4>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn bg-info2 shadow btx_nueva">Registrar Nueva Unidad de Muestreo</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 bg-white esquinas shadow">
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_um"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var tabla;

    function actualiza_tabla(){
        api.get('<?=base_url()?>Registros/unidades_muestreo_html')
        .done(function(res){
            // console.log(JSON.parse(res))
            table.setData(JSON.parse(res));
        })    
    }

    $(document).ready(function(){
        $('#vw_unidad').fadeIn(2000);
        let columnas = [];
        let icons = function(cell, formatterParams){
            return '' +
            '';
        };
        columnas.push({title:'Acciones',field:"botones",hozAlign:'center',vertAlign:'middle',headerHozAlign:'center',formatter:'html',width:200},
            {title:"#", field:"consecutivo",width:90,sorter:"string",vertAlign:'middle',hozAlign:'center',headerHozAlign:'center',headerFilter:"input"},
            {title:"Buscar Unidades de Muestreo",headerFilterPlaceholder:'Buscar por: Clave de Unidad de Muestreo, Estado, Municipio, Predio, Fecha de trazo', field:"html_um",formatter:'html', sorter:"string",hozAlign:'center',headerHozAlign:'center',headerFilter:"input"},
            {title:"Avance de Captura", field:"avance", vertAlign:'middle',width:200,hozAlign:'center',formatter:'html',sorter:"string",headerHozAlign:'center',headerFilter:"input"}
        );
        
        table = new Tabulator("#tabla_um", {
            layout:"fitColumns",
            reactiveData:true,
            pagination:"local",
            paginationSize:4,
            columns:columnas
        });

        actualiza_tabla();
    })

    $('body').on('click','.btx_nueva',function(){
        location.href = '<?=base_url()?>Registros/unidad';
    })

    $('body').on('click','.btx_eliminar_um',function(){
        let um = $(this).attr('um');
        let ide = $(this).attr('ide');
        confirm('Eliminación de UM','¿Deseas eliminar la UM <b style="font-size:20px">'+um+'</b>?, considera que se eliminarán los componentes registrados bajo esta Unidada de Muestreo<br><br>','info',function(){
            api.get('<?=base_url()?>Registros/elimina_um/'+ide,true)
            .done(function(data){
                let res = JSON.parse(data);
                console.log(res);
                if(res.status == 200){
                    alertf('','Eliminación Completa','success',function(){
                        location.href = '<?=base_url()?>Registros';
                    });
                }
            })
        },
        function(){
            alert('','Eliminación Cancelada.','info');
        })
    })
</script>
