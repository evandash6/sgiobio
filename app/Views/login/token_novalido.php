<section>
<div id="vw_recupera" class="row align-items-center" style="display:none">
    <form id="frm_recupera" action="">
        <br><br>
        <div class="row">
            <div class="col-4 offset-4 bg-white esquinas shadow pb-5 pt-3">
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <h3 class="text-danger">Solicitud Caducada</h3>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-10 offset-1">
                        <span class="text">Tu petición de cambio de contraseña ya fue utilizada o esta vencida, favor de generar una nueva solicitud.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-10 offset-1 d-grid gap-2">
                        <button type="button" onclick="location.href='<?=base_url()?>Login/recuperar'" class="btn btn-success shadow"><i class="fa-solid fa-clock-rotate-left mr-2"></i> Recuperar Contraseña</button>
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
</script>
