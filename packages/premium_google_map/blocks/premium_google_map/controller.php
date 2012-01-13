<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class PremiumGoogleMapBlockController extends BlockController {
	
	var $pobj;
	
	protected $btTable = 'btGoogleMapPremium';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "220";
	protected $btWrapperClass = 'ccm-ui';
	
	public $title = "";
	public $api_key = "";
	public $api_version = 'v3';
	public $kml_fID = 0;
	public $kml_link = 1;
	public $w = "100%"; 
	public $h = "400px"; 
	public $map_type='Normal';
	public $show_earth=0;
	public $latitude = "";
	public $longitude = "";
	public $zoom = 3;	
	public $streetview = false;
	
	
	
	public $map_types=array('Normal'=>'ROADMAP', 'Hybrid'=>'HYBRID', 'Satellite'=>'SATELLITE', 'Terrain'=>'TERRAIN' );
	public $map_types_v2=array('Normal'=>'G_NORMAL_MAP', 'Hybrid'=>'G_HYBRID_MAP', 'Satellite'=>'G_SATELLITE_MAP', 'Terrain'=>'G_PHYSICAL_MAP' );
	
	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("The premium Google Map lets you add a KML data file and specify additional unavailable in the regular Google Map block.");
	}
	
	
	public function getBlockTypeName() {
		return t("Google Map (Premium)");
	}		
	
	
	public function on_page_view() {
		$html = Loader::helper('html');
		if($this->api_version == 'v3') {
			$this->addHeaderItem('<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>');
		} else {
			$api_key = $this->api_key;
			$this->addHeaderItem('<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$api_key.'" type="text/javascript"></script>');
			if($this->show_earth) {
				$this->addHeaderItem('<script type="text/javascript" src="http://www.google.com/jsapi?key='.$api_key.'" type="text/javascript"></script>');
			}
		}		
	}
	
	
	public function add() {
		$db = Loader::db();		
		$q = 'SELECT api_key FROM '.$this->btTable.' WHERE api_key!="" ';
		$this->api_key = $db->getOne($q);
	}
	
	function view(){ 
		$this->set('bID', $this->bID);	
		$this->set('title', $this->title);
		$this->set('api_key', $this->api_key);
		$this->set('kml_fID', $this->kml_fID);
		$this->set('kml_link', $this->kml_link);
		$this->set('w', $this->w);	
		$this->set('kml_file_path', $this->getFileURL() );
		$this->set('map_type_constant', $this->getMapTypeConstant() );		
		$this->set('show_earth', $this->show_earth);
		$this->set('load_earth', $this->load_earth);
		$this->set('latitude', $this->latitude);
		$this->set('longitude', $this->longitude);
		$this->set('zoom', $this->zoom);
		$this->set('streetview',($this->streetview?true:false));
		
		if($this->api_version == 'v3') {
			$this->render('v3');
		} else {
			$this->render('view');
		}
	}
	
	function getFileID(){
		return intval($this->kml_fID);
	}
	
	function getFileObject() {
		return File::getByID($this->kml_fID);
	}		
	
	public function getFileURL(){
		$db = Loader::db();
		if(!intval($this->kml_fID)) return '';
		$f = File::getByID($this->kml_fID);
		return $f->getURL();
	}
	
	public function validate($args) {
		$error = Loader::helper('validation/error');
		
		if($args['api_version'] == 'v2') {
			if(!strlen($args['api_key'])) {
				$error->add(t('Please enter a valid Google Maps API key.'));
			}	
		}
		
		if(!is_numeric($args['zoom'])) {
			$error->add(t('Please enter a zoom number from 0 to 21.'));
		}
		
		if($error->has()) {
			return $error;
		}
	}
	
	
	public function save($data) { 
		$args = $data;
		$args['title'] = isset($data['title']) ? trim($data['title']) : '';
		$args['api_key'] = isset($data['api_key']) ? trim($data['api_key']) : '';
		$args['kml_fID'] = (intval($data['fID']))?intval($data['fID']):intval($this->kml_fID); 
		$args['kml_link'] = ($data['kml_link']?1:0);
		$args['w'] = ($data['w']) ? trim($data['w']) : '100%';
		$args['h'] = ($data['h']) ? trim($data['h']) : '400px';	
		$args['map_type'] = ($data['map_type']) ? trim($data['map_type']) : 'Normal';			
		$args['show_earth'] = intval($data['show_earth']);
		$args['load_earth'] = intval($data['load_earth']);	
		$args['zoom'] = (intval($data['zoom'])>=0 && intval($data['zoom'])<=21) ? intval($data['zoom']) : 3;
		$args['latitude']=( strlen($data['latitude'])>0 )? floatval($data['latitude']):0;
		$args['longitude']=( strlen($data['longitude'])>0 )? floatval($data['longitude']):0;
		parent::save($args);
	}
	
	protected function getMapTypeConstant(){
		$key=$this->map_type;
		if($this->api_version == 'v3') {
			$types = $this->map_types;
		} else {
			$types = $this->map_types_v2;
		}
		
		if(!array_key_exists($key,$types)) {
			return $types['Normal']; 
		}
		return $types[$key];		
	}	
}
	
?>