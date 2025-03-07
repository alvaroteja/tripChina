<?php
ini_set('display_errors', 0);
error_reporting(0);

include 'functions.php';
const DEBUGER_ON = false;



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>China Trip</title>
    <link rel="icon" type="image/x-icon" href="./resources/icon/favicon.png" />
</head>
<body>
	<?php
	echoDebugInfo('Esto es lo que viene por el POST:');
	printRDebug($_POST);
	if ($_POST) {

		$accion = $_POST['accion'];

		switch ($accion) {
			case 'agregar':
			$gasto = $_POST["gasto"];
			$monto = $_POST["monto"];
			$tipo = $_POST["tipo"];
			if (!esNumeroPositivo($monto)) {

				echoDebugInfo('El monto no es un número, contiene texto o es un número negativo');
				?>
				<script type="text/javascript">
					Swal.fire({
						icon: "error",
						title: "Dato no válido...",
						text: "El monto no es un número, contiene texto o es un número negativo!"
					}).then(function() {
						window.location = "index.php";
					});
				</script>
				<?php
				break;
			}

			if ($tipo=='') {

				echoDebugInfo('El tipo de gasto está vacío');
				?>
				<script type="text/javascript">
					Swal.fire({
						icon: "error",
						title: "Tipo de gasto no válido...",
						text: "Selecciona un tipo de gasto!"
					}).then(function() {
						window.location = "index.php";
					});
				</script>
				<?php
				break;
			}



			echoDebugInfo("Estas dentro de agregar");

			$sql = "INSERT INTO china (gasto, monto, tipo) VALUES ('$gasto', '$monto', '$tipo')";

			echoDebugInfo("esta es la query: $sql");

			if (ejecutar_query($sql) == 'ok') {
				echoDebugInfo("La query da ok");
				?>
				<script>
					Swal.fire({
						icon: 'success',
						title: 'Listo!',
						text: '<?php echo $gasto?> agregado exitosamente!'
					}).then(function() {
						window.location = "index.php";
					});
				</script>
				<?php
			}else{
				echoDebugInfo("La query no da ok");
			}
			break;

			case 'ocultar':
			echoDebugInfo("Estas dentro de ocultar");
			$id = $_POST["id"];
			$gasto = $_POST["gasto"];
			$valorActualOcultar = $_POST["valor-actual-ocultar"];

			$ocultar;
			$ocultar = ($valorActualOcultar == 1) ? 0 : 1;

			$sql = "UPDATE china SET ocultar='$ocultar' WHERE id=$id";
			echoDebugInfo("La query es $sql");
			if (ejecutar_query($sql) == 'ok') {
				echoDebugInfo("La query dio ok");
				?>
				<script>
					Swal.fire({
						icon: 'success',
						title: 'Listo !!!',
						text: 'Visualización de <?php echo $gasto ?> cambiada Exitosamente!'
					}).then(function() {
						window.location = "index.php";
					});
				</script>
				<?php
			}
			break;
		}
	}
	else{
		echoDebugInfo('No hay nada en el POST!!');
		?>
		<script type="text/javascript">
			Swal.fire({
				icon: "error",
				title: "Oops...",
				text: "No tienes Permiso!"
			}).then(function() {
				window.location = "index.php";
			});
		</script>
		<?php
	}
	?>
</body>
</html>