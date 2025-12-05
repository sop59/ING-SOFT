<?php
session_start();

include_once 'include/config.php';

if(strlen($_SESSION['alogin'])==0){ 
    header('location:index.php');
}
else {

    $oid = intval($_GET['oid']);

    if(isset($_POST['submit2'])){
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        mysqli_query($con, "INSERT INTO ordertrackhistory(orderId,status,remark) VALUES('$oid','$status','$remark')");
        mysqli_query($con, "UPDATE orders SET orderStatus='$status' WHERE id='$oid'");

        echo "<script>alert('Orden actualizada exitosamente');</script>";
    }
?>
<script language="javascript" type="text/javascript">
function f2() {
    window.close();
}
function f3() {
    window.print(); 
}
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Actualizar Orden</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div style="margin-left:50px;">
<form name="updateticket" id="updateticket" method="post"> 

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr height="50">
    <td colspan="2" class="fontkink2" style="padding-left:0px;">
        <div class="fontpink2"><b>¡Actualizar Orden!</b></div>
    </td>
</tr>

<tr height="30">
    <td class="fontkink1"><b>ID de Orden:</b></td>
    <td class="fontkink"><?php echo $oid; ?></td>
</tr>

<?php 
$ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
while($row = mysqli_fetch_array($ret)){
?>
<tr height="20">
    <td class="fontkink1"><b>En la Fecha:</b></td>
    <td class="fontkink"><?php echo $row['postingDate']; ?></td>
</tr>

<tr height="20">
    <td class="fontkink1"><b>Estado:</b></td>
    <td class="fontkink"><?php echo $row['status']; ?></td>
</tr>

<tr height="20">
    <td class="fontkink1"><b>Comentario:</b></td>
    <td class="fontkink"><?php echo $row['remark']; ?></td>
</tr>

<tr>
    <td colspan="2"><hr /></td>
</tr>
<?php } ?>

<?php 
$delivered = 'Delivered';
$rt = mysqli_query($con,"SELECT orderStatus FROM orders WHERE id='$oid'");
$current = mysqli_fetch_array($rt);
$currentStatus = $current['orderStatus'];

if($delivered == $currentStatus){
?>
<tr>
    <td colspan="2"><b>Producto Entregado</b></td>
</tr>

<?php } else { ?>

<tr height="50">
    <td class="fontkink1">Estado:</td>
    <td class="fontkink">
        <select name="status" class="fontkink" required>
            <option value="">Seleccionar Estado</option>
            <option value="in Process">En Proceso</option>
            <option value="Delivered">Entregado</option>
        </select>
    </td>
</tr>

<tr>
    <td class="fontkink1">Comentario:</td>
    <td class="fontkink">
        <textarea cols="50" rows="7" name="remark" required></textarea>
    </td>
</tr>

<tr>
    <td class="fontkink1">&nbsp;</td>
    <td>&nbsp;</td>
</tr>

<tr>
    <td class="fontkink">&nbsp;</td>
    <td class="fontkink">
        <input type="submit" name="submit2" value="Actualizar" style="cursor:pointer;" />
        &nbsp;&nbsp;
        <input type="button" value="Cerrar esta Ventana" onclick="return f2();" style="cursor:pointer;" />
    </td>
</tr>

<?php } ?>

</table>
</form>
</div>

</body>
</html>

<?php } ?>
