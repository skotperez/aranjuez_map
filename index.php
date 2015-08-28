<?php
// content depending on mode: edition or not
if ( array_key_exists('mode',$_GET) ) {
	if ( function_exists('filter_var') ) { $mode = filter_var($_GET['mode'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); }
	else { $mode = htmlspecialchars($_GET['mode'], ENT_QUOTES); }
}
else { $mode = "false"; }
if ( $mode == 'edit' ) {
	$allowEdit = "true";
	$modal_edit_mode = '
<div class="modal" id="edit_mode" tabindex="-1" role="dialog" aria-labelledby="modalEditMode" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p>Para comenzar a editar el mapa, pincha en el icono del lapiz de la derecha, tras cerrar este mensaje.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Empezar a editar</button>
			</div>
		</div>
	</div>
</div>
	';
	$navbar_right = '<ul class="nav navbar-nav navbar-right"><li><a href="/">Salir del modo edición</a></li></ul>';
}
else {
	$allowEdit = "false";
	$navbar_right = '<ul class="nav navbar-nav navbar-right"><li><a href="?mode=edit"><span class="glyphicon glyphicon-pencil"></span> Activar el modo edición</a></li></ul>';
}
$umap_options = "scaleControl=false&miniMap=true&scrollWheelZoom=true&zoomControl=true&allowEdit=".$allowEdit."&moreControl=false&datalayersControl=true&onLoadPanel=undefined&captionBar=false";

// OUTPUT ?>
<!DOCTYPE html>
<html lang="es-ES">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Aranjuez, un oasis en la vega del Tajo</title>

<?php
// meta tags
$metatit = "Aranjuez, un oasis en la vega del Tajo";
$metadesc = "Cartografía colaborativa de recursos territoriales en el entorno de Aranjuez";
$metaperma = "http://aranjuez.surcosurbanos.es";
$metaimg = "http://aranjuez.surcosurbanos.es/images/screenshot.png";

// sharing buttons
if ( function_exists('filter_var') ) {
	$share_perma = filter_var($metaperma,FILTER_SANITIZE_ENCODED);
	$share_img = filter_var($metaimg,FILTER_SANITIZE_ENCODED);
	$share_tit = filter_var($metatit,FILTER_SANITIZE_ENCODED);
	$share_desc = filter_var($metadesc,FILTER_SANITIZE_ENCODED);

} else {
	$share_perma = urlencode($metaperma);
	$share_img = urlencode($metaimg);
	$share_tit = urlencode($metatit);
	$share_desc = urlencode($metadesc);

}
$share_buttons = array(
	array("facebook","Facebook","http://facebook.com/sharer.php?u=".$share_perma),
	array("twitter","Twitter","http://twitter.com/home?status=".$share_tit."%20".$share_perma),
	array("googleplus","Google Plus","https://plus.google.com/share?url=".$share_perma),
	array("linkedin","Linkedin","https://www.linkedin.com/shareArticle?url=".$share_perma."&mini=true&title=".$share_tit."&summary=".$share_desc."&source=".$share_tit),
	array("tumblr","Tumblr","http://www.tumblr.com/share/link?url=".$share_perma."&name=".$share_tit."&description=".$share_desc),
	array("pinterest","Pinterest","http://pinterest.com/pin/create/button/?url=".$share_perma."&media=".$share_img."&name=".$share_tit."&description=".$share_desc),
);

?>
<!-- generic meta -->
<meta content="Asociación Surcos Urbanos" name="author" />
<meta name="title" content="<?php echo $metatit ?>" />
<meta name="description" content="<?php echo $metadesc ?>" />
<meta content="cartografía colaborativa, Aranjuez, biodiversidad, ciclo hidrológico, equipamientos culturales" name="keywords" />
<!-- facebook meta -->
<meta property="og:title" content="<?php echo $metatit ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php echo $metadesc ?>" />
<meta property="og:url" content="<?php echo $metaperma ?>" />
<meta property="og:image" content="<?php echo $metaimg; ?>" />

<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="style.css" rel="stylesheet">

</head>

<body>

<nav id="pre" class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pre-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/"><h1 id="main-tit">Aranjuez, un oasis en la vega del Tajo</h1></a>
	</div>
	<div class="collapse navbar-collapse" id="pre-collapse">
		<ul class="nav navbar-nav">
			<li><a href="#proyecto" data-toggle="modal" data-target="#proyecto">El proyecto</a></li>
			<li><a href="#mapa" data-toggle="modal" data-target="#mapa">La cartografía</a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Compartir</a>
				<ul class="dropdown-menu" role="menu">
					<?php foreach ( $share_buttons as $sb ) {
						echo "<li class='share-button share-".$sb[0]."'><a target='_blank' href='".$sb[2]."'>".$sb[1]."</a></li>";
					} ?>
				</ul>
			</li>
		</ul>
		<?php echo $navbar_right ?>
	</div><!-- #pre-collapse -->
</div>
</nav>

<?php echo $modal_edit_mode; ?>
<!-- Modal mapa -->
<div class="modal fade" id="mapa" tabindex="-1" role="dialog" aria-labelledby="modalMapaTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="ModalMapaTitle">Cartografía colaborativa</h2>
			</div>
			<div class="modal-body">
				<p>En este mapa colaborativo puedes incluir información sobre las áreas y elementos del entorno agrario de Aranjuez, localizándolos y añadiendo una pequeña descripción y una imagen.</p>
				<p>Hay cuatro categorías diferentes:</p>
				<ul>
					<li>SOPORTE. Aquí se incluirían los espacios importantes para la biodiversidad.</li>
					<li>REGULACIÓN. Espacios importantes desde el punto de vista de los ciclos naturales. Que contribuyen a la regulación del clima, de la temperatura, al ciclo hidrológico...</li>
					<li>ABASTECIMIENTO. Son los que aportan alimentos, agua para el consumo, y otro tipo de materiales...</li>
					<li>CULTURA. Todos los espacios y construcciones relacionados con el arte y la cultura, las tradiciones, el ocio, la observación de la naturaleza, el deporte, el aprendizaje...</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal proyecto -->
<div class="modal fade" id="proyecto" tabindex="-1" role="dialog" aria-labelledby="modalProyectoTitle" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="ModalProyectoTitle">Aranjuez, un oasis en la vega del Tajo</h2>
			</div>
			<div class="modal-body">
				<p><strong>Descubriendo los servicios de los ecosistemas del entorno urbano</strong></p>
				<p>Durante el mes de mayo de 2015, la Universidad Politécnica de Madrid, junto a las asociaciones Surcos Urbanos y el Observatorio para una Cultura del Territorio, desarrollan en Aranjuez un conjunto de actividades que pretenden acercar a la ciudadanía los espacios agrarios del entorno urbano, para comprender todos los servicios que estos ecosistemas prestan a la ciudad y, así entender la necesidad de su preservación y dinamización. ¡No te pierdas ninguna de las actividades!</p>
				<div role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#actividades" aria-controls="profile" role="tab" data-toggle="tab">Actividades</a></li>
						<li role="presentation"><a href="#organizaciones" aria-controls="messages" role="tab" data-toggle="tab">Organizaciones participantes</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="actividades">
							<h4>Exposición "Aranjuez, un oasis en la vega del Tajo. Los servicios de los ecosistemas"</h4>
							<dl>
								<dt>Lugar</dt><dd>Centro Cultural Isabel de Farnesio</dd>
								<dt>Fechas</dt><dd>jueves 21 a sábado 30 de junio de 2015</dd>
							</dl>
							<h4>Itinerarios exploradores en bicicleta "Rastreando los servicios de los ecosistemas"</h4>
							<dl>
								<dt>Lugar</dt><dd>Ruta en bici por las huertas (1,5 horas). Punto de salida y llegada en la entrada del Jardín del Príncipe en la calle la Reina.</dd>
								<dt>Fechas</dt><dd>viernes 12 de junio de 2015 a las 19:00 horas y domingo 14 de junio de 2015 a las 11:00 horas</dd>
								<dt>Inscripción gratuita</dt><dd>oct@observatorioculturayterritorio.org</dd>
							</dl>
						</div>
						<div role="tabpanel" class="tab-pane" id="organizaciones">
							<ul class="list-inline list-vair">
								<li><a href="https://surcosurbanos.wordpress.com/" title="Surcos Urbanos"><img src="images/organiza-01.png" alt="Surcos Urbanos" /></a></li>
								<li><a href="http://observatorioculturayterritorio.org/wordpress/" title="Observatorio para una Cultura del Territorio"><img src="images/organiza-02.jpg" alt="Observatorio para una Cultura del Territorio" /></a></li>
								<li><a href="http://www2.aq.upm.es/Departamentos/Urbanismo/blogs/paec-sp/" title="Grupo de Investigación Arquitectura, Urbanismo y Sostenibilidad, UPM"><img src="images/organiza-03.jpg" alt="Grupo de Investigación Arquitectura, Urbanismo y Sostenibilidad, UPM" /></a></li>
								<li><a href="http://www.upm.es/ETSIMontes/Empresas/GI/EcolPaisaje/" title="Grupo de Investigación Ecología y Paisaje, UPM"><img src="images/organiza-04.jpg" alt="Grupo de Investigación Ecología y Paisaje, UPM" /></a></li>
								<li><a href="http://www.aranjuez.es/" title="Ayuntamiento de Aranjuez"><img src="images/organiza-05.jpg" alt="Ayuntamiento de Aranjuez" /></a></li>
								<li><a href="http://www.fecyt.es/" title="Fundación Española para la Ciencia y Tecnología, FECYT"><img src="images/organiza-06.png" alt="Fundación Española para la Ciencia y Tecnología, FECYT" /></a></li>
								<li><a href="http://www.idi.mineco.gob.es/portal/site/MICINN/menuitem.7eeac5cd345b4f34f09dfd1001432ea0/?vgnextoid=83b192b9036c2210VgnVCM1000001d04140aRCRD" title="Plan Nacional de I+D+i 2008-2011"><img src="images/organiza-07.png" alt="Plan Nacional de I+D+i 2008-2011" /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
			</div>
		</div>
	</div>
</div>

<iframe id="map" width="50%" height="100%" frameBorder="0" src="http://umap.openstreetmap.fr/en/map/aranjuez-testing_34167?<?php echo $umap_options ?>"></iframe>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php if ( $mode == 'edit' ) { ?>
	<script type="text/javascript">
	    $(window).load(function(){
	        $('#edit_mode').modal('show');
	    });
	</script>
<?php }

// include stats tracking code
include("stats.php");
?>


</body></html>
