<?php
session_start();
include('include/config.php');

// Si no hay sesión, redirigir
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
}
else {

    // Zona horaria de Perú
    date_default_timezone_set('America/Lima');
    $currentTime = date('d-m-Y h:i:s A', time());

    // Si se elimina un producto
    if(isset($_GET['del'])) {
        mysqli_query($con,"DELETE FROM products WHERE id = '".$_GET['id']."'");
        $_SESSION['delmsg'] = "Producto eliminado correctamente.";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrador | Gestionar Productos</title>

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background: #f8f9fb;
			min-height: 100vh;
		}

		.wrapper {
			background: transparent;
		}

		.content {
			background: transparent;
		}

		.module {
			background: white;
			border-radius: 12px;
			border: 1px solid #e5e7eb;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
			overflow: hidden;
			margin-top: 20px;
		}

		.module-head {
			background: white;
			border-bottom: 1px solid #e5e7eb;
			padding: 24px 32px;
		}

		.module-head h3 {
			color: #1f2937;
			font-weight: 700;
			font-size: 20px;
			margin: 0;
			letter-spacing: -0.5px;
		}

		.module-body {
			padding: 0;
		}

		.alert {
			padding: 12px 16px;
			border-radius: 8px;
			font-size: 13px;
			margin: 24px 32px;
			animation: slideDown 0.3s ease-out;
			border: none;
		}

		@keyframes slideDown {
			from {
				opacity: 0;
				transform: translateY(-10px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.alert-error {
			border-left: 4px solid #ef4444;
			background: #fef2f2;
			color: #991b1b;
		}

		.alert .close {
			color: inherit;
			opacity: 0.5;
			text-shadow: none;
			font-size: 18px;
		}

		.alert .close:hover {
			opacity: 1;
		}

		/* Table Styles */
		.table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0;
			margin: 0;
		}

		.table thead {
			background: #f9fafb;
		}

		.table thead th {
			padding: 16px 24px;
			text-align: left;
			font-size: 12px;
			font-weight: 700;
			color: #6b7280;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			border-bottom: 1px solid #e5e7eb;
		}

		.table tbody td {
			padding: 16px 24px;
			font-size: 14px;
			color: #374151;
			border-bottom: 1px solid #f3f4f6;
			vertical-align: middle;
		}

		.table tbody tr {
			transition: background-color 0.15s ease;
		}

		.table tbody tr:hover {
			background: #f9fafb;
		}

		.table tbody tr:last-child td {
			border-bottom: none;
		}

		/* DataTables Custom Styles */
		.dataTables_wrapper {
			padding: 0;
		}

		.dataTables_length {
			padding: 24px 32px 0;
		}

		.dataTables_length label {
			font-size: 14px;
			color: #6b7280;
			font-weight: 500;
		}

		.dataTables_length select {
			border: 1px solid #d1d5db;
			border-radius: 6px;
			padding: 6px 32px 6px 12px;
			font-size: 14px;
			color: #374151;
			margin: 0 8px;
			background: white;
		}

		.dataTables_filter {
			padding: 24px 32px 0;
		}

		.dataTables_filter label {
			font-size: 14px;
			color: #6b7280;
			font-weight: 500;
		}

		.dataTables_filter input {
			border: 1px solid #d1d5db;
			border-radius: 6px;
			padding: 8px 12px;
			font-size: 14px;
			color: #374151;
			margin-left: 8px;
			transition: all 0.2s ease;
		}

		.dataTables_filter input:focus {
			outline: none;
			border-color: #2563eb;
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.05);
		}

		.dataTables_info {
			padding: 20px 32px;
			font-size: 13px;
			color: #6b7280;
		}

		.dataTables_paginate {
			padding: 20px 32px;
			text-align: right;
		}

		.dataTables_paginate a {
			display: inline-block;
			padding: 6px 12px;
			margin: 0 2px;
			border: 1px solid #d1d5db;
			border-radius: 6px;
			color: #374151;
			text-decoration: none;
			font-size: 13px;
			font-weight: 500;
			transition: all 0.2s ease;
			background: white;
		}

		.dataTables_paginate a:hover {
			background: #f9fafb;
			border-color: #9ca3af;
		}

		.dataTables_paginate a.current {
			background: #2563eb;
			border-color: #2563eb;
			color: white;
		}

		.dataTables_paginate a.disabled {
			opacity: 0.5;
			cursor: not-allowed;
		}

		/* Action Icons */
		.table tbody td a {
			display: inline-block;
			margin-right: 8px;
			color: #6b7280;
			font-size: 16px;
			transition: all 0.2s ease;
		}

		.table tbody td a:hover {
			transform: scale(1.2);
		}

		.table tbody td a .icon-edit {
			color: #2563eb;
		}

		.table tbody td a .icon-edit:hover {
			color: #1d4ed8;
		}

		.table tbody td a .icon-remove-sign {
			color: #ef4444;
		}

		.table tbody td a .icon-remove-sign:hover {
			color: #dc2626;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.module-head {
				padding: 20px 24px;
			}

			.alert {
				margin: 20px 24px;
			}

			.dataTables_length,
			.dataTables_filter,
			.dataTables_info,
			.dataTables_paginate {
				padding-left: 24px;
				padding-right: 24px;
			}

			.table thead th,
			.table tbody td {
				padding: 12px 16px;
				font-size: 13px;
			}

			.table {
				font-size: 12px;
			}
		}

		/* DataTable Sorting */
		.table thead th.sorting,
		.table thead th.sorting_asc,
		.table thead th.sorting_desc {
			cursor: pointer;
			position: relative;
			padding-right: 30px;
		}

		.table thead th.sorting:after,
		.table thead th.sorting_asc:after,
		.table thead th.sorting_desc:after {
			position: absolute;
			right: 12px;
			font-family: 'FontAwesome';
			opacity: 0.3;
		}

		.table thead th.sorting:after {
			content: "\f0dc";
		}

		.table thead th.sorting_asc:after {
			content: "\f0de";
			opacity: 1;
			color: #2563eb;
		}

		.table thead th.sorting_desc:after {
			content: "\f0dd";
			opacity: 1;
			color: #2563eb;
		}

		/* Override Bootstrap table styles */
		.table-bordered {
			border: none;
		}

		.table-striped tbody > tr:nth-child(odd) > td,
		.table-striped tbody > tr:nth-child(odd) > th {
			background-color: transparent;
		}
	</style>
</head>

<body>

<?php include('include/header.php'); ?>

<div class="wrapper">
	<div class="container">
		<div class="row">

<?php include('include/sidebar.php'); ?>	

			<div class="span9">
				<div class="content">

					<div class="module">
						<div class="module-head">
							<h3>Gestionar Productos</h3>
						</div>

						<div class="module-body table">

						<?php if(isset($_GET['del'])) { ?>
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>Atención:</strong> 
								<?php echo htmlentities($_SESSION['delmsg']); ?>
								<?php echo htmlentities($_SESSION['delmsg']=""); ?>
							</div>
						<?php } ?>

							<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre Producto</th>
										<th>Categoría</th>
										<th>Subcategoría</th>
										<th>Compañía</th>
										<th>Fecha Creación</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>

<?php
$query = mysqli_query($con,
	"SELECT products.*, category.categoryName, subcategory.subcategory 
	 FROM products 
	 JOIN category ON category.id = products.category 
	 JOIN subcategory ON subcategory.id = products.subCategory"
);

$cnt = 1;
while($row = mysqli_fetch_array($query)) {
?>
									<tr>
										<td><?php echo htmlentities($cnt); ?></td>
										<td><?php echo htmlentities($row['productName']); ?></td>
										<td><?php echo htmlentities($row['categoryName']); ?></td>
										<td><?php echo htmlentities($row['subcategory']); ?></td>
										<td><?php echo htmlentities($row['productCompany']); ?></td>
										<td><?php echo htmlentities($row['postingDate']); ?></td>
										<td>
											<a href="edit-products.php?id=<?php echo $row['id']; ?>"><i class="icon-edit"></i></a>
											<a href="manage-products.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('¿Está seguro de eliminar este producto?')">
												<i class="icon-remove-sign"></i>
											</a>
										</td>
									</tr>
<?php
$cnt++;
}
?>
								</tbody>
							</table>

						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<?php include('include/footer.php'); ?>

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
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
