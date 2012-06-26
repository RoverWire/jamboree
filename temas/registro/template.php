<?php $site_root = ruta(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro Nacional</title>
<?php echo $header; ?>
<!--[if IE 6]>
<?php echo $site_root; ?>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/reset.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/text.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/grid.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/uniform.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/jquery-ui.css" media="screen" />
<?php echo $_styles; ?>

<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/ie6.css" media="screen" /><![endif]--> 
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo $site_root; ?>temas/registro/css/ie.css" media="screen" /><![endif]-->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<?php echo $_scripts; ?>

</head>

<body class="main_gradient">
<div class="contenedor">
    <div id="header">
        <div id="head_main">
        	<a id="log_out" href="#"><span>Salir</span></a>
            <div id="head_user"><strong>Luis Felipe Pérez</strong><br /><a href="#">configurar cuenta</a></div>
        </div>
        <div id="head_nav">
        	<ul>
            	<li><a href="#">Inicio</a></li>
                <li><a href="#">Registro</a></li>
                <li><a href="#">Staff</a></li>
                <li><a href="#">Campos</a></li>
                <li><a href="#">Membresía</a></li>
                <li><a href="#">Usuarios</a></li>
                <li><a href="#">Configuracion</a></li>
            </ul>
        </div>
    </div>
    <div id="contenido" class="container_16">
    	<div id="sidebar" class="grid_4 alpha">
        	<div class="titulo_lateral">
            	Opciones
            </div>
            <?php echo $sidebar; ?>
        </div>
        
        <div class="grid_12">
        	<?php echo $content; ?>
        </div>
        <div class="clearfix">&nbsp;</div>
    </div>
    <div id="footer">
	  <p>Registro de Eventos Nacionales v2.0</p>
      <img src="<?php echo $site_root; ?>temas/registro/img/footer_img.png" name="footer_img" width="110" height="40" id="footer_img" alt="" />
	</div>
</div>
</body>
</html>