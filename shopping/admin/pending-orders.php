<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin'])==0){	
    header('location:index.php');
}
else{

// Zona horaria corregida (Perú)
date_default_timezone_set('America/Lima');
$currentTime = date('d-m-Y h:i:s A', time());

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrador | Órdenes Pendientes</title>

	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

	<script type="text/javascript">
	var popUpWin = 0;
	function popUpWindow(URLStr, left, top, width, height){
		if(popUpWin){
			if(!popUpWin.closed) popUpWin.close();
		}
		popUpWin = window.open(
			URLStr,
			'popUpWin',
			'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,'+
			'resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+',top='+top
		);
	}
	</script>

</head>
<body>
<?php include('include/header.php');?>


<div class="wrapper">
	<div class="container">
		<div class="row">

			<?php include('include/sidebar.php');?>	

			<div class="span9">
				<div class="content">

					<div class="module">
						<div class="module-head">
							<h3>Órdenes Pendientes</h3>
						</div>

						<div class="module-body table">

						<?php if(isset($_GET['del'])){ ?>
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>¡Error!</strong>  
								<?php 
									echo htmlentities($_SESSION['delmsg']); 
									echo htmlentities($_SESSION['delmsg']="");
								?>
							</div>
						<?php } ?>

						<br />

						<!-- CONTENEDOR RESPONSIVE (SOLUCIÓN DEL PROBLEMA DE TABLA CORTADA) -->
						<div class="table-responsive">

						<table cellpadding="0" cellspacing="0" border="0" 
							class="datatable-1 table table-bordered table-striped display">

							<thead>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th width="120">Email / Teléfono</th>
									<th>Dirección de Envío</th>
									<th>Producto</th>
									<th>Cantidad</th>
									<th>Monto</th>
									<th>Fecha de Orden</th>
									<th>Acción</th>
								</tr>
							</thead>

							<tbody>
							<?php 
							$status = 'Delivered';

							$query = mysqli_query($con,
							"SELECT 
								users.name AS username,
								users.email AS useremail,
								users.contactno AS usercontact,
								users.shippingAddress AS shippingaddress,
								users.shippingCity AS shippingcity,
								users.shippingState AS shippingstate,
								users.shippingPincode AS shippingpincode,
								products.productName AS productname,
								products.shippingCharge AS shippingcharge,
								orders.quantity AS quantity,
								orders.orderDate AS orderdate,
								products.productPrice AS productprice,
								orders.id AS id  
							 FROM orders 
							 JOIN users ON orders.userId = users.id 
							 JOIN products ON products.id = orders.productId 
							 WHERE orders.orderStatus != '$status' 
							 OR orders.orderStatus IS NULL");

							$cnt = 1;
							while($row = mysqli_fetch_array($query)){
							?>	

								<tr>
									<td><?php echo htmlentities($cnt); ?></td>
									<td><?php echo htmlentities($row['username']); ?></td>

									<td>
										<?php echo htmlentities($row['useremail']); ?>
										<br>
										<?php echo htmlentities($row['usercontact']); ?>
									</td>

									<td>
										<?php 
											echo htmlentities(
												$row['shippingaddress'] . ", " .
												$row['shippingcity'] . ", " .
												$row['shippingstate'] . " - " .
												$row['shippingpincode']
											);
										?>
									</td>

									<td><?php echo htmlentities($row['productname']); ?></td>
									<td><?php echo htmlentities($row['quantity']); ?></td>

									<td>
										<?php echo htmlentities(
											$row['quantity'] * $row['productprice'] + $row['shippingcharge']
										); ?>
									</td>

									<td><?php echo htmlentities($row['orderdate']); ?></td>

									<td>
										<a href="updateorder.php?oid=<?php echo htmlentities($row['id']); ?>" 
											title="Actualizar Orden" target="_blank">
											<i class="icon-edit"></i>
										</a>
									</td>
								</tr>

							<?php $cnt++; } ?>
							</tbody>

						</table>

						</div> <!-- FIN table-responsive -->

						</div>
					</div>

				</div><!--/.content-->
			</div><!--/.span9-->

		</div>
	</div>
</div>

<?php include('include/footer.php');?>


<!-- Scripts -->
<script src="scripts/jquery-1.9.1.min.js"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="scripts/flot/jquery.flot.js"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>

<script>
$(document).ready(function() {
	$('.datatable-1').dataTable();
	$('.dataTables_paginate').addClass("btn-group datatable-pagination");
	$('.dataTables_paginate > a').wrapInner('<span />');
	$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
	$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
});
</script>

</body>
</html>
<?php } ?>
