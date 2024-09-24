<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT ID_CORREO, ID_CLIENTE, NOMBRE, NOMBRE_COMPLETO, CORREO, TIPO FROM correos_electronicos INNER JOIN clientes on clientes.id = correos_electronicos.id_cliente where estado = 'activo'";
$result = $cn->query($sqlSelect);

?>
<table class="table-striped js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm" id="MyTable2">
	<thead>
		<tr>
			<th>ID</th>
			<th>Correo Electronico</th>
			<th>Cliente</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = $result->fetch_assoc()) { ?>
			<tr onclick="editar_correo('<?php echo $row['ID_CORREO'] ?>','<?php echo $row['NOMBRE_COMPLETO'] ?>','<?php echo $row['CORREO'] ?>','<?php echo $row['TIPO'] ?>','<?php echo $row['ID_CLIENTE'] ?>')">
				<td>
					<span class="d-block fs-5"><?php echo $row['ID_CORREO'] ?></span>
				</td>
				<td>
					<a class="d-flex align-items-center">
						<div class="flex-grow-1 ms-3">
							<span class="d-block h5 text-inherit mb-0"><?php echo $row['NOMBRE_COMPLETO'] ?></span>
							<span class="d-block fs-5 text-body"><?php echo $row['CORREO'] ?></span>
						</div>
					</a>
				</td>
				<td>
					<span class="d-block fs-5"><?php echo $row['NOMBRE'] ?></span>
				</td>
				<td>
					<span class="legend-indicator bg-success"></span><?php echo $row['TIPO'] ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('#MyTable2').DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": " Primero ",
					"last": " Ultimo ",
					"next": " Proximo ",
					"previous": " Anterior  "
				}
			},
			"lengthMenu": [
				[20, 25, 30, 40, 50, -1],
				[20, 25, 30, 40, 50, "All"]
			]
		})
	});
</script>