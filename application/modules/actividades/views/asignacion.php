<form class="uniForm" name="usuario" id="usuario" action="" method="post" enctype="multipart/form-data">
	<?php
		if(validation_errors()){
	?>
	<div class="error">
		<strong>ATENCIÓN:</strong>
		Por favor verifique la información proporcionada, uno o más campos contienen datos no admitidos o se encuentran sin información.
	</div>
	<?php
		}
	?>

	<fieldset class="inlineLabels">
		<legend>Actividad de Equipo</legend>
		<div class="ctrlHolder">
			<label for="grupal">Seleccionar:</label>
			<span class="inputHolder">
				<select name="Datos[grupal]" id="grupal" class="chosen">
					<?php echo $this->actividad->combo_equipo(); ?>
				</select>
				<p class="formHint">actividad que harán todos los integrantes</p>
				<?php echo form_error('Datos[grupal]'); ?>
			</span>
		</div>
	</fieldset>

	<fieldset class="inlineLabels">
		<legend>Actividad Individual</legend>
		<?php for ($i=0; $i<$this->registro->numero_registros; $i++){ ?>
		<div class="ctrlHolder">
			<label for="<?php echo $this->registro->lobato_cum; ?>"><?php echo $this->registro->lobato_nombre; ?>:</label>
			<span class="inputHolder">
				<select name="Datos[<?php echo $this->registro->lobato_cum; ?>]" id="<?php echo $this->registro->lobato_cum; ?>" class="chosen">
					<?php echo $this->actividad->combo_individual(); ?>
				</select>
				<p class="formHint">actividad individual del elemento</p>
				<?php echo form_error('Datos[<?php echo $this->registro->lobato_cum; ?>]'); ?>
			</span>
		</div>

		<?php $this->registro->siguiente(); } ?>
	</fieldset>
	<div class="pieBtn">
		<button type="submit"><span class="ui-icon ui-icon-check"></span> Asignar</button>
	</div>
</form>
<script type="text/javascript">
$(function() {
	$(".chosen").chosen();
});
</script>