<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Facturas</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <title>Registro de Facturas</title>
    <style>

    </style>
  </head>

  <body style="background-image: url(https://static.vecteezy.com/system/resources/previews/009/668/606/original/aesthetic-floral-flower-background-in-earth-tone-color-free-png.png);">
    <?php
    require "conexion.php";
    ?>
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <h1 class="mb-3 mt-3 shadow p-2" style="border-radius: 10px; background-color: white;">Registro de Facturas</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <form method="POST" action="" class="form-control shadow">
            <h3>Cargar factura</h3>
            <input
              type="date"
              name="fecha_emision"
              class="form-control shadow mb-3 mt-3"
              title="Fecha de emisión"
              required
            />
            <div class="input-group mb-3">
              <span class="input-group-text">$</span>
              <input
                type="number"
                name="monto"
                step="0.01"
                placeholder="Monto"
                class="form-control shadow"
                required
              />
            </div>
            <button type="submit" name="btnGuardar" class="btn btn-primary">
              Guardar Factura
            </button>
          </form>
        </div>
        <?php $mostrarInteres = mostrarInteres(); ?>
        <div class="col-4">
            <form action="" method="post" class="form-control shadow">
                <h3>Cargar interes</h3>
                <?php
                while($registro=mysqli_fetch_assoc($mostrarInteres)){?>
                  <div class="row">
                      <div class="col mt-3">
                        <h6>Dias</h6>
                      </div>
                      <div class="col mt-3">
                        <h6>Interes</h6>
                      </div>                      
                    </div>                      
                    <div class="row">
                      <div class="col mb-3 mt-3">
                          <input type="number" name="dia1" id="dia1" class="form-control shadow" 
                          placeholder="<?php echo $registro['int_dia1'];?>" value="<?php echo $registro['int_dia1'];?>"/>
                      </div>
                      <div class="col mb-3 mt-3">
                          <input type="number" name="int1" id="int1" class="form-control shadow" 
                          placeholder="<?php echo $registro['int_1'];?>" value="<?php echo $registro['int_1'];?>"/>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col mb-3">
                          <input type="number" name="dia2" id="dia2" class="form-control shadow" 
                          placeholder="<?php echo $registro['int_dia2'];?>" value="<?php echo $registro['int_dia2'];?>"/>
                      </div>
                      <div class="col mb-3">
                          <input type="number" name="int2" id="int2" class="form-control shadow" 
                          placeholder="<?php echo $registro['int_2'];?>" value="<?php echo $registro['int_2'];?>"/>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col mb-3">
                          <input type="number" name="dia3" id="dia3" class="form-control shadow"
                          placeholder="<?php echo $registro['int_dia3'];?>" value="<?php echo $registro['int_dia3'];?>"/>
                      </div>
                      <div class="col mb-3">
                          <input type="number" name="int3" id="int3" class="form-control shadow"
                          placeholder="<?php echo $registro['int_3'];?>" value="<?php echo $registro['int_3'];?>"/>
                      </div>
                  </div>
                <?php } ?>
                  <button type="submit" name="btnInteres" class="btn btn-primary">
                  Calcular Interes
                  </button>
              </div>
            </form>
            <div class="col-4">
              
              <img src="imagenes/qrcode-generado.png" alt="GitHub de Gonzalo Rojas" >
              
            </div>
        </div>

      <?php
    if(isset($_POST['btnGuardar'])){
        procesar();
    }
    if(isset($_POST['btnInteres'])){
        interes();
        mostrarInteres();
    } 
    $facturas=mostrar();
    ?>

    <div class="row">
        <div class="col mt-4"></div>
      <table class="table table-striped-columns">
        <thead style="border-radius: 20px;">
          <th>id factura</th>
          <th>monto</th>
          <th>Emision</th>
          <th>Vencimiento</th>
          <th>dias</th>
          <th>interes</th>
          <th>Monto Interes</th>
          <th>Total</th>
        </thead>
        <tbody style="border-radius: 20px;">
          <?php
                while($registro=mysqli_fetch_assoc($facturas)){?>
          <tr>
            <td>
              <?php echo $registro['fac_id'];?>
            </td>
            <?php $monto = $registro['fac_monto'];?>
            <td>
              <?php echo $registro['fac_monto'];?>
            </td>
            <td>
              <?php echo $registro['fac_emision'];?>
            </td>
            <td>
              <?php echo $registro['fac_vencimiento'];?>
            </td>
              <?php $dias_retraso = retraso($registro); ?>
            <td>
              <?php echo $dias_retraso; ?>
            </td>
            <?php $interes = calcularInteres($dias_retraso);?>
            <td><?php echo $interes;?>%</td>
            <?php $montoInt = $interes * $monto / 100;?>
            <td>
              <?php echo $montoInt; ?>
            </td>
            <?php $total = $montoInt + $monto;?>
            <td>
              <?php echo $total; ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
  </body>
</html>
