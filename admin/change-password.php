<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata'); // Cambiar según tu zona horaria
$currentTime = date('d-m-Y h:i:s A', time());

if(isset($_POST['submit']))
{
    $sql = mysqli_query($con,"SELECT password FROM admin WHERE password='".md5($_POST['password'])."' AND username='".$_SESSION['alogin']."'");
    $num = mysqli_fetch_array($sql);
    if($num > 0)
    {
        $con = mysqli_query($con,"UPDATE admin SET password='".md5($_POST['newpassword'])."', updationDate='$currentTime' WHERE username='".$_SESSION['alogin']."'");
        $_SESSION['msg'] = "¡Contraseña actualizada correctamente!";
    }
    else
    {
        $_SESSION['msg'] = "La contraseña actual no coincide.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrador | Cambiar Contraseña</title>
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
			padding: 32px;
		}

		.alert {
			padding: 12px 16px;
			border-radius: 8px;
			font-size: 13px;
			margin-bottom: 24px;
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

		.alert-success {
			border-left: 4px solid #10b981;
			background: #ecfdf5;
			color: #065f46;
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

		.form-horizontal .control-group {
			margin-bottom: 24px;
		}

		.control-label {
			font-weight: 600;
			color: #374151;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			padding-top: 8px;
		}

		.controls input[type="password"] {
			width: 100%;
			padding: 11px 14px;
			border: 1px solid #d1d5db;
			border-radius: 8px;
			font-size: 14px;
			font-family: 'Inter', sans-serif;
			background: #f9fafb;
			transition: all 0.2s ease;
			color: #1f2937;
		}

		.controls input[type="password"]::placeholder {
			color: #9ca3af;
		}

		.controls input[type="password"]:focus {
			outline: none;
			border-color: #2563eb;
			background: white;
			box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.05);
		}

		.btn-primary {
			background: #2563eb;
			border: none;
			border-radius: 8px;
			padding: 11px 24px;
			font-size: 14px;
			font-weight: 600;
			transition: all 0.2s ease;
			font-family: 'Inter', sans-serif;
			color: white;
			text-shadow: none;
		}

		.btn-primary:hover {
			background: #1d4ed8;
			box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
			color: white;
		}

		.btn-primary:active {
			transform: scale(0.98);
		}

		.btn-primary:focus {
			background: #1d4ed8;
			color: white;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.module-head {
				padding: 20px 24px;
			}

			.module-body {
				padding: 24px;
			}

			.control-label {
				margin-bottom: 8px;
			}
		}

		/* Override Bootstrap styles */
		.form-horizontal .control-group {
			border: none;
			background: transparent;
		}

		.span8 {
			width: 100% !important;
			margin-left: 0 !important;
		}

		.row-fluid [class*="span"] {
			float: none;
			margin-left: 0;
		}
	</style>

	<script type="text/javascript">
function valid()
{
	if(document.chngpwd.password.value=="")
	{
		alert("¡El campo de contraseña actual está vacío!");
		document.chngpwd.password.focus();
		return false;
	}
	else if(document.chngpwd.newpassword.value=="")
	{
		alert("¡El campo de nueva contraseña está vacío!");
		document.chngpwd.newpassword.focus();
		return false;
	}
	else if(document.chngpwd.confirmpassword.value=="")
	{
		alert("¡El campo de confirmar contraseña está vacío!");
		document.chngpwd.confirmpassword.focus();
		return false;
	}
	else if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value)
	{
		alert("¡La nueva contraseña y su confirmación no coinciden!");
		document.chngpwd.confirmpassword.focus();
		return false;
	}
	return true;
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
							<h3>Cambiar Contraseña</h3>
						</div>
						<div class="module-body">

<?php if(isset($_POST['submit'])) { ?>
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg']=""); ?>
							</div>
<?php } ?>

	<form class="form-horizontal row-fluid" name="chngpwd" method="post" onSubmit="return valid();">
									
		<div class="control-group">
			<label class="control-label" for="basicinput">Contraseña Actual</label>
			<div class="controls">
				<input type="password" placeholder="Ingresa tu contraseña actual" name="password" class="span8 tip" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="basicinput">Nueva Contraseña</label>
			<div class="controls">
				<input type="password" placeholder="Ingresa tu nueva contraseña" name="newpassword" class="span8 tip" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="basicinput">Confirmar Nueva Contraseña</label>
			<div class="controls">
				<input type="password" placeholder="Vuelve a ingresar tu nueva contraseña" name="confirmpassword" class="span8 tip" required>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button type="submit" name="submit" class="btn btn-primary">Guardar Cambios</button>
			</div>
		</div>

	</form>

						</div>
					</div>
					
				</div><!--/.content-->
			</div><!--/.span9-->

		</div>
	</div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php');?>


<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>

</body>
<?php } ?>