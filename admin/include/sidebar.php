<div class="span3">
    <div class="sidebar">

        <ul class="widget widget-menu unstyled">
            <li>
                <a class="collapsed" data-toggle="collapse" href="#togglePages">
                    <i class="menu-icon icon-cog"></i>
                    <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
                    Gestión de Pedidos
                </a>
                <ul id="togglePages" class="collapse unstyled">
                    <li>
                        <a href="todays-orders.php">
                            <i class="icon-tasks"></i>
                            Pedidos de Hoy
                            <?php
                            $f1="00:00:00";
                            $from=date('Y-m-d')." ".$f1;
                            $t1="23:59:59";
                            $to=date('Y-m-d')." ".$t1;
                            $result = mysqli_query($con,"SELECT * FROM Orders WHERE orderDate BETWEEN '$from' AND '$to'");
                            $num_rows1 = mysqli_num_rows($result);
                            {
                            ?>
                                <b class="label orange pull-right"><?php echo htmlentities($num_rows1); ?></b>
                            <?php } ?>
                        </a>
                    </li>

                    <li>
                        <a href="pending-orders.php">
                            <i class="icon-tasks"></i>
                            Pedidos Pendientes
                            <?php
                            $status='Delivered';
                            $ret = mysqli_query($con,"SELECT * FROM Orders WHERE orderStatus!='$status' OR orderStatus IS NULL");
                            $num = mysqli_num_rows($ret);
                            {?>
                                <b class="label orange pull-right"><?php echo htmlentities($num); ?></b>
                            <?php } ?>
                        </a>
                    </li>

                    <li>
                        <a href="delivered-orders.php">
                            <i class="icon-inbox"></i>
                            Pedidos Entregados
                            <?php
                            $status='Delivered';
                            $rt = mysqli_query($con,"SELECT * FROM Orders WHERE orderStatus='$status'");
                            $num1 = mysqli_num_rows($rt);
                            {?>
                                <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                            <?php } ?>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="manage-users.php">
                    <i class="menu-icon icon-group"></i>
                    Administrar Usuarios
                </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li><a href="category.php"><i class="menu-icon icon-tasks"></i> Crear Categoría </a></li>
            <li><a href="subcategory.php"><i class="menu-icon icon-tasks"></i> Subcategoría </a></li>
            <li><a href="insert-product.php"><i class="menu-icon icon-paste"></i> Insertar Producto </a></li>
            <li><a href="manage-products.php"><i class="menu-icon icon-table"></i> Administrar Productos </a></li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li><a href="user-logs.php"><i class="menu-icon icon-tasks"></i> Registro de Accesos de Usuarios </a></li>

            <li>
                <a href="logout.php">
                    <i class="menu-icon icon-signout"></i>
                    Cerrar Sesión
                </a>
            </li>
        </ul>

    </div><!--/.sidebar-->
</div><!--/.span3-->
