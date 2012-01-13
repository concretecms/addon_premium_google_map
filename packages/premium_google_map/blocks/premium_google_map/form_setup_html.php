<?php defined('C5_EXECUTE') or die(_("Access Denied."));

$includeAssetLibrary = true;
$al = Loader::helper('concrete/asset_library');
if(intval($mapObj->kml_fID)>0){ 
	$bf = $mapObj->getFileObject();
}
?>
<fieldset>
	<div class="clearfix">
		<?php echo $form->label('title',t('Map Title'));?>
		<div class="input">
			<?php echo $form->text('title',$mapObj->title);?>
			<div class="help-block">(<?=t('Optional')?>)</div>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('map_type',t('Default View'));?>
		<div class="input">
			<select id="ccm_googlemap_block_map_type" name="map_type">
			<? foreach($mapObj->map_types as $map_type_key=>$constant){ ?>
			<option value="<?=$map_type_key?>" <?=($map_type_key==$mapObj->map_type)?'selected':'' ?>><?=$map_type_key?></option>
			<? } ?>
		</select>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('api_version',t('Google API Version'));?>
		<div class="input">
			<?php echo $form->select('api_version',array('v3'=>'Version 3','v2'=>t('Version 2')), $mapObj->api_version )?>
			<div class="help-block"><?php echo t('Version 2 supports google earth, requires api key')?></div>
		</div>
	</div>
	
	<div id="ccm_googlemap_block_v2" class="clearfix" style="display:none">
		<?php echo $form->label('api_key',t('Google Maps API Key')); ?>
		<div class="input">
			<?php echo $form->text('api_key',$mapObj->api_key);?>
			<div class="help-block"><a href="http://code.google.com/apis/maps/signup.html" target="_blank"><?=t('Sign up for your key')?></a></div>
		</div>
		<div class="input">
			<ul class="inputs-list">
				<li>
					<label><input type="checkbox" value="1" name="load_earth" <?=($mapObj->load_earth)?'checked':'' ?> /> 
					<span><?=t('Try to use google Earth on load')?></span></label>
				</li>
				<li>
					<label><input type="checkbox" value="1" name="show_earth" <?=($mapObj->show_earth)?'checked':'' ?> />
					<span><?=t('Show Google Earth Button')?></span></label>
				</li>
			</ul>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('w',t('Width'));?>
		<div class="input">
			<?php echo $form->text('w',$mapObj->w);?>
		</div>
	</div>	
	<div class="clearfix">
		<?php echo $form->label('h',t('Height'));?>
		<div class="input">
			<?php echo $form->text('h',$mapObj->h);?>
		</div>
	</div>
   	<div class="clearfix">
		<?php echo $form->label('zoom',t('Zoom'));?>
		<div class="input">
			<?php echo $form->text('zoom',$mapObj->zoom);?>
			<div class="help-block"><?=t('Enter a number from 0 to 21, with 21 being the most zoomed in.')?> </div>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('latitude',t('Latitude'));?>
		<div class="input">
			<?php echo $form->text('latitude',$mapObj->latitude);?>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('longitude',t('Longitude'));?>
		<div class="input">
			<?php echo $form->text('longitude',$mapObj->longitude);?>
		</div>
	</div>
	<div class="clearfix">
		<?php echo $form->label('ccm-b-file',t('KML File'));?>
		<div class="input">
			<?php echo $al->file('ccm-b-file', 'fID', t('Choose File'), $bf);?>
			<div class="help-block">
			<a href="http://code.google.com/apis/kml/documentation/" target="_blank"><?=t("What's a KML file?")?></a><br />
			<?=t('(For your KML file to work, it has to be accessible by google over the internet)'); ?>
			</div>
		</div>
		<div class="input">
			<ul class="inputs-list">
			<li>
				<label><?php echo $form->checkbox('kml_link', 1,($kml_link?1:0));?> 
				<span><?php echo t('Display kml download link')?></span></label>
			</li>
			</ul>
		</div>
	</div>
</fieldset>

<script language="javascript">
$(function() {
	if($('#api_version').val() == 'v2') {
		$('#ccm_googlemap_block_v2').show();
	}
	$('#api_version').change(function(){
		if($('#api_version').val() == 'v2') {
			$('#ccm_googlemap_block_v2').show();
		} else {
			$('#ccm_googlemap_block_v2').hide();
		} 
	});
});
</script>