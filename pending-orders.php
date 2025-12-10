<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:login.php');
}
else{
	if (isset($_GET['id'])) {

		mysqli_query($con,"delete from orders where userId='".$_SESSION['id']."' and paymentMethod is null and id='".$_GET['id']."' ");
	}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	    <title>Historial de Pedidos Pendientes</title>

	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

		<!-- Demo -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">

		<!-- Icons -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!-- Fonts --> 
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/images/favicon.ico">

	</head>

<body class="cnt-home">

<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>
</header>

<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Inicio</a></li>
				<li class='active'>Carrito de Compras</li>
			</ul>
		</div>
	</div>
</div>

<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row inner-bottom-sm">
			<div class="shopping-cart">
				<div class="col-md-12 col-sm-12 shopping-cart-table">
	<div class="table-responsive">

<form name="cart" method="post">	

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Imagen</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Precio Unitario</th>
					<th>Costo de Envío</th>
					<th>Total</th>
					<th>Método de Pago</th>
					<th>Fecha del Pedido</th>
					<th>Acción</th>
				</tr>
			</thead>

			<tbody>

<?php 
$query=mysqli_query($con,"select products.productImage1 as pimg1,products.productName as pname,products.id as c,orders.productId as opid,orders.quantity as qty,products.productPrice as pprice,products.shippingCharge as shippingcharge,orders.paymentMethod as paym,orders.orderDate as odate,orders.id as oid from orders join products on orders.productId=products.id where orders.userId='".$_SESSION['id']."' and orders.paymentMethod is null");

$cnt=1;
$num=mysqli_num_rows($query);

if($num>0)
{
while($row=mysqli_fetch_array($query))
{
?>
<tr>
	<td><?php echo $cnt;?></td>
	<td class="cart-image">
		<a class="entry-thumbnail" href="detail.html">
			<img src="admin/productimages/<?php echo $row['proid'];?>/<?php echo $row['pimg1'];?>" alt="" width="84" height="146">
		</a>
	</td>

	<td>
		<h4><a href="product-details.php?pid=<?php echo $row['opid'];?>"><?php echo $row['pname'];?></a></h4>
	</td>

	<td><?php echo $qty=$row['qty']; ?></td>

	<td><?php echo $price=$row['pprice']; ?></td>

	<td><?php echo $shippcharge=$row['shippingcharge']; ?></td>

	<td><?php echo (($qty*$price)+$shippcharge);?></td>

	<td><?php echo $row['paym']; ?></td>

	<td><?php echo $row['odate']; ?></td>

	<td><a href="pending-orders.php?id=<?php echo $row['oid']; ?>">Eliminar</a></td>
</tr>

<?php 
$cnt++;
} ?>

<tr>
	<td colspan="9">
		<div class="cart-checkout-btn pull-right">
			<button type="submit" name="ordersubmit" class="btn btn-primary">
				<a href="payment-method.php" style="color:white;">Proceder al Pago</a>
			</button>
		</div>
	</td>
</tr>

<?php } else { ?>

<tr>
<td colspan="10" align="center"><h4>No se encontraron resultados</h4></td>
</tr>

<?php } ?>

			</tbody>
		</table>

	</div>
</div>

		</div>
		</div>
		</form>

<?php echo include('includes/brands-slider.php');?>

</div>
</div>

<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

</body>
</html>

<?php } ?>
