<?php

/**
 * @package SGI\SRLat
 */


/**
 * 
 */
class SGI_SRLat_Admin_Core
{

	private $version;

	private $opts;

	public function __construct()
	{

		//Version check
		if ($srlat_ver = get_option('sgi_srlat_ver')) :

			if (version_compare(SGI_SRLAT_VERSION,$srlat_ver,'>')) :

				update_option('sgi_srlat_ver', SGI_SRLAT_VERSION);

			endif;

			$this->version = SGI_SRLAT_VERSION;

		else :

			$srlat_ver = SGI_SRLAT_VERSION;
			add_option('sgi_srlat_ver',$srlat_ver,'no');

		endif;

		//Options init
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

		add_action('admin_init', [&$this, 'register_settings']);
        add_action('admin_menu', [&$this, 'add_settings_menu']);

        add_filter('plugin_action_links_'.SGI_SRLAT_BASENAME, array(&$this,'add_settings_link'));

	}

	public function add_settings_link($links)
	{

		$links[] = sprintf(
			'<a href="%s">%s</a>',
			admin_url('options-general.php?page=sgi-sr-latinization'),
			__('Settings','serbian-latinisation')
		);

		return $links;

	}

	public function add_settings_menu()
	{

		add_submenu_page(
            'options-general.php',
            'Transliteration',
            'Transliteration',
            'manage_options',
            'sgi-sr-latinization',
            array(&$this, 'settings_callback')
        );

	}

	public function settings_callback()
	{

		printf (
			'<div class="wrap"><h1>%s</h1>',
			__('Serbian Transliteration Settings','serbian-latinisation')
		);

        echo '<form method="POST" action="options.php">';

        settings_fields('sgi_srlat_settings');

        do_settings_sections('sgi-sr-latinization');

        submit_button();

        echo "</form>";

        echo '</div>';

	}

	public function register_settings()
	{

		register_setting(
            'sgi_srlat_settings',
            'sgi_srlat_opts',
            array(&$this, 'sanitize_opts')
        );

		//Core section
        add_settings_section(
            'sgi_srlat_core',
            __('Core settings','serbian-latinisation'),
            array(&$this, 'core_section_callback'),
            'sgi-sr-latinization'
        );

        add_settings_field(
            'sgi_srlat_opts_script',
            __('Default script', 'serbian-latinisation'),
            array(&$this, 'script_callback'),
            'sgi-sr-latinization',
            'sgi_srlat_core',
            $this->opts['core']['script']
        );

        add_settings_field(
            'sgi_srlat_opts_permalink',
            __('Fix permalinks', 'serbian-latinisation'),
            array(&$this, 'permalink_callback'),
            'sgi-sr-latinization',
            'sgi_srlat_core',
            $this->opts['core']['fix_permalinks']
        );

        add_settings_field(
            'sgi_srlat_opts_permalink',
            __('Fix permalinks', 'serbian-latinisation'),
            array(&$this, 'permalink_callback'),
            'sgi-sr-latinization',
            'sgi_srlat_core',
            $this->opts['core']['fix_permalinks']
        );

        add_settings_field(
            'sgi_srlat_opts_media',
            __('Fix media names', 'serbian-latinisation'),
            array(&$this, 'media_callback'),
            'sgi-sr-latinization',
            'sgi_srlat_core',
            $this->opts['core']['fix_media']
        );

        add_settings_field(
            'sgi_srlat_opts_search',
            __('Fix Search', 'serbian-latinisation'),
            array(&$this, 'search_callback'),
            'sgi-sr-latinization',
            'sgi_srlat_core',
            $this->opts['core']['fix_search']
        );


	}

	public function core_section_callback()
	{
		
		printf(
			'<p>%s</p>',
			__(
				'Core plugin settings control main functionality of the plugin',
				'serbian-latinisation'
			)
		);
	}

	public function script_callback($default_script)
	{
		$scripts = array(
			'cir' => __('Cyrillic','serbian-latinisation'),
			'lat' => __('Latin','serbian-latinisation')
		);

		echo '<select name="sgi_srlat_opts[core][script]">';

		foreach ($scripts as $script => $name) :

			printf(
				'<option value="%s" %s>%s</option>',
				$script,
				selected($default_script, $script, false),
				$name
			);


		endforeach;

		echo '</select>';

		printf('<p class="description">%s</p>
			',
			__('Default script used for the website if user did not select a script','serbian-latinisation')
		);

	}

	public function permalink_callback($fix_permalinks)
	{

		$wplang = get_option('WPLANG');
		$helper_text = __('Transliterate cyrillic permalinks to latin script','serbian-latinisation');

		$disabled = ( ($wplang == 'sr_RS') || ($wplang == 'bs_BA') ) ? 'disabled' : '';

		if ($disabled == 'disabled') :

			$helper_text .= sprintf(
				'<br><strong>%s</strong>',
				__('This option is currently disabled because your current locale is set to sr_RS which will automatically change permalnks','serbian-latinisation')
			);

		endif;

		printf(
			'<label for="sgi_srlat_opts[core][fix_permalinks]">
				<input type="checkbox" name="sgi_srlat_opts[core][fix_permalinks]" %s %s> %s
			</label>
			<p class="description">%s</p>
			',
			checked(true, $fix_permalinks, false),
			$disabled,
			__('Fix permalinks','serbian-latinisation'),
			$helper_text
		);
	}

	public function media_callback($fix_media)
	{

		printf(
			'<label for="sgi_srlat_opts[core][fix_media]">
				<input type="checkbox" name="sgi_srlat_opts[core][fix_media]" %s> %s
			</label>
			<p class="description">%s</p>
			',
			checked(true, $fix_media, false),
			__('Fix media names','serbian-latinisation'),
			__('Transliterate cyrillic filenames to latin','serbian-latinisation')
		);

	}

	public function search_callback($fix_search)
	{

		printf(
			'<label for="sgi_srlat_opts[core][fix_search]">
				<input type="checkbox" name="sgi_srlat_opts[core][fix_search]" %s> %s
			</label>
			<p class="description">%s</p>
			',
			checked(true, $fix_search, false),
			__('Fix Search','serbian-latinisation'),
			__('Enable searching for cyrillic titles using latin script','serbian-latinisation')
		);

	}

	public function sanitize_opts($opts)
	{

		$core_checkboxes = ['fix_permalinks','fix_media','fix_search'];
		$core_opts = $opts['core'];


		foreach($core_checkboxes as $option) :

			if (isset($core_opts[$option])) :

				$opts['core'][$option] = true;

			else : 

				$opts['core'][$option] = false;

			endif;

		endforeach;

		return $opts;

	}






}