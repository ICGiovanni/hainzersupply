<div class="panel-body">

    <div class="row">
        <div class="col-md-12">
            <label for="nombreDistribuidor" class="sr-only">Nombre del distribuidor: </label>
            <input type="text" id="nombreDistribuidor" name="nombreDistribuidor" class="form-control" placeholder="Nombre del distribuidor">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="representanteDistribuidor" class="sr-only">Representante: </label>
            <input type="text" id="representanteDistribuidor" name="representanteDistribuidor" class="form-control" placeholder="Representante">
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <label for="telefonoDistribuidor" class="sr-only">Telefono oficina: </label>
            <input type="text" id="telefonoDistribuidor" name="telefonoDistribuidor" class="form-control" placeholder="Telefono oficina">
        </div>
        <div class="col-md-5">
            <label for="celularDistribuidor" class="sr-only">Celular: </label>
            <input type="text" id="celularDistribuidor" name="celularDistribuidor" class="form-control" placeholder="Celular">
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">

            <label for="emailDistribuidor" class="sr-only">Correo electronico: </label>
            <div class="input-group">
                <span class="input-group-addon">@</span>
                <input type="text" id="emailDistribuidor" name="emailDistribuidor" class="form-control" placeholder="Correo electronico:">
            </div>

        </div>

        <div class="col-md-5">
            <label for="nivelDistribuidor" class="sr-only">Nivel: </label>
            <select class="form-control"  id="nivelDistribuidor" name="nivelDistribuidor">
                <option value="0">Seleccione un nivel de distribuidor</option>
                <?php
                    foreach($instDistribuidores->getNiveles() as $nivel){
                        echo "<option value='".$nivel['idNivel']."'>".$nivel['descripcion']."</option>";
                    }
                ?>
            </select>
        </div>
    </div>

</div>