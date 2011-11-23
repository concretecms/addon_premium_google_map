<?php defined('C5_EXECUTE') or die(_("Access Denied.")); 
$c = Page::getCurrentPage();
?>
<style>
#googleAdvancedMapCanvas<?=$bID?>{ width:<?=($w)?$w:'100%'?>; border:0px none; height:<?=($h)?$h:'400px'?>;}
</style>   
<script type="text/javascript"> 
function googleMapInit<?=$bID?>() { 
	try{
		var geoXml<?=$bID?>=null;

		var latlng = new google.maps.LatLng(<?=$latitude?>, <?=$longitude?>);
		//var mapControl = google.maps.MapTypeControlOptions();
	    var mapOptions = {
	      zoom: <?=$zoom?>,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.<?=$map_type_constant?>,
	      mapTypeControl: true,
	      navigationControl: true,
	      navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN},
	      streetViewControl: <?=($streetview?'true':'false')?>
		};
	    
	    var map = new google.maps.Map(document.getElementById('googleAdvancedMapCanvas<?=$bID?>'), mapOptions);
	    <?php
		if( strlen($kml_file_path) ){ ?>
			geoXml<?=$bID?> = new google.maps.KmlLayer("<?=$kml_file_path; ?>");			
			geoXml<?=$bID?>.setMap(map);

			/* reset the zoom if the kml doesn't specify a lookat param */
			google.maps.event.addListenerOnce(geoXml<?=$bID?>, "defaultviewport_changed", function() {
			    google.maps.event.addListenerOnce(map, "bounds_changed", function() {
			    	geoXml<?=$bID?>.set('preserveViewport', true);
			    	if(map.getZoom() >= 20) {
						map.setZoom(<?=$zoom?>);
				    }
				});
			}); 
									
		<?php } ?>

	}catch(e){} 
}
</script>
<? if( strlen($title)>0){ ?><h3><?=$title?></h3><? } ?>
<div id="googleAdvancedMapCanvas<?=$bID?>" class="googleAdvancedMapCanvas"></div>
<? if(strlen($kml_file_path) && $kml_link){ ?>
	<div class="ccm-note"><a href="<?=$this->url('/download_file', $kml_fID)?>" target="_blank">Download KML for Google Earth</a></div>
<? } ?>
<script type="text/javascript">$(function() {googleMapInit<?=$bID?>();});</script> 