<?php

class SGI_SRLat_Frontend
{

	private $cookie_lang;
	
	private $opts;

	public static $instance;

	public function __construct()
	{

		if (defined('ICL_LANGUAGE_CODE')) :

			$in_serbian = (ICL_LANGUAGE_CODE == 'sr') ? true : false;

		else :

			$in_serbian = true;

		endif;

		$srlat_opts = get_option(
			'sgi_srlat_opts',
			array(
				'core' => array(
					'script'		 => 'cir',
					'fix_permalinks' => (get_option('WPLANG') == 'sr_RS') ? false : true,
					'fix_media'		 => true,
					'fix_search'	 => true,
				),
		));

		$this->opts = $srlat_opts;

		$this->cookie_lang = $this->get_script();

		if ( ($this->cookie_lang == 'lat') && $in_serbian ) :

			add_action('wp_head', array(&$this,'buffer_start'), 99);
			add_action('wp_footer', array(&$this,'buffer_end'), 99);
			
			add_action('rss_head', array(&$this,'buffer_start'), 99);		
			add_action('rss_footer', array(&$this,'buffer_end'), 99);		

			add_action('atom_head', array(&$this,'buffer_start'), 99);		
			add_action('atom_footer', array(&$this,'buffer_end'), 99);		
			
			add_action('rdf_head', array(&$this,'buffer_start'), 99);		
			add_action('rdf_footer', array(&$this,'buffer_end'), 99);		
			
			add_action('rss2_head', array(&$this,'buffer_start'), 99);		
			add_action('rss2_footer', array(&$this,'buffer_end'), 99);	

			add_filter('gettext', array(&$this, 'convert_script'), 9);
			add_filter('gettext_with_context', array(&$this, 'convert_script'), 9);
			add_filter('ngettext', array(&$this, 'convert_script'), 9);
			add_filter('ngettext_with_context', array(&$this, 'convert_script'), 9);

			add_filter('wp_title',array (&$this,'convert_title'),200,3);

		endif;

		add_filter('posts_search', array(&$this,'fix_search'),20,2);

		if (defined('ICL_LANGUAGE_CODE')) :

			add_filter('icl_ls_languages', array(&$this,'change_wpml_language_list'),50,1);

		endif;

		self::$instance = $this;

	}

	public static function get_instance()
	{

		if (self::$instance === null)
			self::$instance = new self();

		return self::$instance;

	}

	public function get_cookie_lang()
	{
		return $this->cookie_lang;
	}

	private function get_script()
	{
		if (!isset($_REQUEST['sr_pismo'])) :

			return $this->check_cookie();

		else :

			$lng = $_REQUEST['sr_pismo'];

			//$lng = ( ($lng != 'cir') || ($lng != 'lat') ) ? 'lat' : $lng;

			setcookie("sgi_pismo", $lng, strtotime("+3 months"), "/");

			return $lng;

		endif;

	}

	private function check_cookie()
	{

		if (isset($_COOKIE['sgi_pismo'])) :

			$lng = $_COOKIE['sgi_pismo'];
			//$lng = ( ($lng != 'cir') || ($lng != 'lat') ) ? 'lat' : $lng;

			return $lng;

		else :

			//echo 'ovde smo';

			setcookie("sgi_pismo", $this->opts['core']['script'], strtotime("+3 months"), "/");

			return $this->opts['core']['script'];

		endif;

	}

	public function change_wpml_language_list($active_languages)
	{

		$new_languages = $active_languages;

		$sr_cir = $sr_lat = $active_languages['sr'];

		$sr_cir['native_name'] = 'српски (ћир)';
		$sr_cir['translated_name'] = $sr_cir['translated_name'].' (cyr)';
		$sr_cir['url'] = $sr_lat['url'].'?sr_pismo=cir';

		$sr_lat['native_name'] = 'српски (lat)';
		$sr_lat['translated_name'] = $sr_lat['translated_name'].' (lat)';
		$sr_lat['url'] = $sr_lat['url'].'?sr_pismo=lat';

		unset($active_languages['sr']);

		foreach ($active_languages as $lang_code => $lang_data) :

			$new_languages[$lang_code] = $lang_data;

		endforeach;

		if ($this->cookie_lang == 'cir') :

			$new_languages['sr_lat'] = $sr_lat;
			$new_languages['sr'] = $sr_cir;

		else :

			$new_languages['sr'] = $sr_lat;
			$new_languages['sr_cir'] = $sr_cir;

		endif;

		return $new_languages;
	}

	public function fix_search($search,$query)
	{

		if (!$this->opts['core']['fix_search'])
			return $search;

		if ( !$query->is_main_query()) :

			return $search;

		endif;

		if ($_GET['s'] == '')
			return $search;

		if (!is_search())
			return $search;

		$search = sgi_sql_search($search);

		return $search;

	}

	public function buffer_start()
	{

		ob_start();

	}

	public function buffer_end()
	{

		//ob_end_flush();
		$output = ob_get_clean();
		echo $this->convert_script($output);

	}

	public function convert_title($title,$sep,$location)
	{

		return $this->convert_script($title);

	}

	public function convert_script($text)
	{

		return SGI_Translit_Core::cir_to_lat($text);

	}



}