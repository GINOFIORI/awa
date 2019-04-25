<div class="col-sm-4 b-r" style="padding-top:10px; padding-bottom:0px; padding-right:0px; padding-left:0px">
  <div class="col-md-12">
    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4' style='text-align: left'>
      <label style="color: black; font-size: 8pt;">Codigo Artículo</label>
    </div>
    <div class="input-group col-xs-12 col-sm-12 col-md-7 col-lg-7"> 
      <input  id = "codAdmin" 
              name  = "codAdmin"
              value =""
              class ="form-control"
              type  ="text" 
              placeholder ="Ingresar Código"
              style = "height: 22px; font-size: 8pt" 
              onChange ="">
        <span class="input-group-btn">
          <button type='button' 
                  id='buscar'
                  class='btn btn-xs btn-primary'
                  data-toggle="modal" 
                  data-target="#buscarArticulos"
                  >
            <span class="fa fa-search" ></span>
          </button>
        </span>
      </input>
    </div>
  </div>
  <div class="col-md-12">
    <div>
      <div class='col-md-12'>
          <div id="cargandoArticulo" style="visibility: visible;"><i class=" fa fa-spinner fa-spin fa-2x" ></i></div>
      </div>
    </div>
  </div>
</div>