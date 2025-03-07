<?php
ini_set('display_errors', 0);
error_reporting(0);

include 'conn.php';
include 'functions.php';

const IVA_BASE = 21;
const PRESUPUESTO = 500;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>China Trip</title>
    <link rel="icon" type="image/x-icon" href="./resources/icon/favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <h1>China Trip</h1>
        <img src="./resources/icon/china.png" alt="" />
    </header>
    <div id="web-content">
        <div id="form-container" class="container mt-3 col-md-3">
            <h2 class="text-center">Registro de Gastos</h2>
            <form action="procesar.php" method="POST">
                <input type="hidden" id="accion" name="accion" value="agregar">
                <div id="form-inputs">
                    <div>
                        <label class="form-label" for="input-gasto">Gasto:</label>
                        <input type="text" class="form-control" id="input-gasto" name="gasto" placeholder="Gasto" required />
                    </div>
                    <div>
                        <label class="form-label" for="input-monto">Monto:</label>
                        <input type="text" class="form-control" id="input-monto" name="monto" placeholder="Monto" required />
                    </div>
                    <div>
                        <select class="form-select" name="tipo" id="select-tipo-gasto">
                            <option value="" disabled selected>Tipo de gasto</option>
                            <option value="Compras" >Compras</option>
                            <option value="Alcohol">Alcohol</option>
                            <option value="Comida">Comida</option>
                            <option value="Gifts">Gifts</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn">Guardar</button>
            </form>
        </div>
        <?php

        $query = "SELECT * FROM china";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
        ?>
        <div class="container mt-4">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr id="thead-tr-id">
                    <th class="thead-th-id">#</th>
                    <th class="thead-th-id">FECHA</th>
                    <th class="thead-th-id">GASTO</th>
                    <th class="thead-th-id">TIPO</th>
                    <th class="thead-th-id">BASE</th>
                    <th class="thead-th-id">IVA</th>
                    <th class="thead-th-id">MONTO</th>
                    <th class="thead-th-id">OCULTAR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $contador = 0;
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    $contador++;
                    $monto = $row['monto'];
                    $total  += $monto;
                    $ivaEspecifico = obtenerIva($row['tipo']);
                    $ivaCalculado = $monto * ($ivaEspecifico/100);
                    $base = $monto - $ivaCalculado;
                    if (!$row['ocultar']) {
                        ?>
                        <tr class="d-block d-md-table-row">
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">#:</strong> <?php echo $contador?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">FECHA:</strong> <?php echo convertirFecha($row['fecha']); ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">GASTO:</strong> <?php echo $row['gasto']; ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">TIPO:</strong> <?php echo $row['tipo']; ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">BASE:</strong> <?php echo redondearADosDecimales($base).'€'; ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">IVA:</strong> <?php echo redondearADosDecimales($ivaCalculado).'€'; ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <strong class="thead-responsive">MONTO:</strong> <?php echo redondearADosDecimales($monto).'€'; ?>
                            </td>
                            <td class="d-block d-md-table-cell">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" id="accion" name="accion" value="ocultar">
                                    <input type="hidden" id="ocultar-id" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" id="ocultar-gasto" name="gasto" value="<?php echo $row['gasto']; ?>">
                                    <input type="hidden" id="valor-actual-ocultar-id" name="valor-actual-ocultar" value="<?php echo $row['ocultar']; ?>">
                                    <button class="btn btn-sm">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr class="d-block d-md-table-row">
                            <td colspan="7" class="celda-oculta"><h3>Este registro está oculto...</h3></td>
                            <td class="d-block d-md-table-cell">
                                <form action="procesar.php" method="POST">
                                    <input type="hidden" id="accion" name="accion" value="ocultar">
                                    <input type="hidden" id="ocultar-id" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" id="ocultar-gasto" name="gasto" value="<?php echo $row['gasto']; ?>">
                                    <input type="hidden" id="valor-actual-ocultar-id" name="valor-actual-ocultar" value="<?php echo $row['ocultar']; ?>">
                                    <button class="btn btn-sm">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr class="d-block d-md-table-row">
                    <td id="total-td" colspan="8">
                        <h3>TOTAL &nbsp
                        <span id="total" class="<?php
                            if ($total < PRESUPUESTO*0.5) {
                                echo "totalOkContainer totalOk";
                            } elseif ($total >= PRESUPUESTO * 0.5 && $total < PRESUPUESTO) {
                                echo "totalWarningContainer totalWarning";
                            } else {
                                echo "totalDangerContainer totalDanger";
                            }
                        ?>">
                        <?php echo redondearADosDecimales($total).'€'; ?>
                        </span>
                        </h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

        <?php
        }else{
        ?>
            <img id="no-data-img" src="./resources/img/no-data.jpg" alt="">
        <?php
        }
        ?>
</div>
</body>
<script>
    function ajustarDisplayEnPantalla() {

    const elementos = document.querySelectorAll('.thead-responsive');

    if (window.innerWidth > 767) {
        elementos.forEach(elemento => {
            elemento.style.display = 'none';
        });
    } else {
        elementos.forEach(elemento => {
            elemento.style.display = '';
        });
    }
}

window.addEventListener('load', ajustarDisplayEnPantalla);
window.addEventListener('resize', ajustarDisplayEnPantalla);


</script>
</html>