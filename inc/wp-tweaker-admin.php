<?php
if (!defined('wp-tweaker-admin'))
{
  exit;
}

class WPTweaker_SettingsPage
{
    private $wptweaker_options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'wptweaker_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'wptweaker_page_init' ) );
    }

    public function wptweaker_add_plugin_page()
    {
        $page = add_options_page(
            'WP-Tweaker',
            'WP-Tweaker',
            'manage_options',
            'wptweaker-settings',
            array( $this, 'wptweaker_create_admin_page' )
        );
        add_action(
    			'load-' .$page,
    			array(
    				__CLASS__,
    				'add_help'
    			)
    		);
    }

    public function wptweaker_create_admin_page()
    {
        // Set class property
        $this->wptweaker_options = get_option( 'wptweaker_settings' )
        ?>
        <div class="wrap">
            <h1>Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    public function wptweaker_page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'wptweaker_settings', // Option name
            array( $this, 'wptweaker_sanitize' ) // Sanitize
        );

        add_settings_section(
          'wptweaker_setting_section_header', // ID
            'Unneeded Header-Info', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_section(
            'wptweaker_setting_section_external_data', // ID
            'External ressources and data', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_section(
            'wptweaker_setting_section_database', // ID
            'Boosting Database', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_section(
            'wptweaker_setting_section_loading_time', // ID
            'Optimize the Page Speed', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_section(
            'wptweaker_setting_section_security', // ID
            'Security settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'wptweaker_setting_1',
            'Disable the WordPress-Version in the header.',
            array( $this, 'callback_wptweaker_setting_1' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_2',
            'Deactivate WP-Emojis',
            array( $this, 'callback_wptweaker_setting_2' ),
            'my-setting-admin',
            'wptweaker_setting_section_external_data'
        );

        add_settings_field(
            'wptweaker_setting_3',
            'Remove the Windows Live Writer',
            array( $this, 'callback_wptweaker_setting_3' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_4',
            'Remove the RSD-Links',
            array( $this, 'callback_wptweaker_setting_4' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_5',
            'Remove RSS-Links',
            array( $this, 'callback_wptweaker_setting_5' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_6',
            'Remove Shortlinks',
            array( $this, 'callback_wptweaker_setting_6' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_7',
            'Remove links to adjacent Posts',
            array( $this, 'callback_wptweaker_setting_7' ),
            'my-setting-admin',
            'wptweaker_setting_section_header'
        );

        add_settings_field(
            'wptweaker_setting_8',
            'Limit Post-Revisions to 5',
            array( $this, 'callback_wptweaker_setting_8' ),
            'my-setting-admin',
            'wptweaker_setting_section_database'
        );
        add_settings_field(
            'wptweaker_setting_9',
            'Disable automatic http-requests by Plugins & Themes [WARNING: this will also stop the update-notifications!]',
            array( $this, 'callback_wptweaker_setting_9' ),
            'my-setting-admin',
            'wptweaker_setting_section_external_data'
        );
        add_settings_field(
            'wptweaker_setting_10',
            'Disable the WordPress-Heartbeat',
            array( $this, 'callback_wptweaker_setting_10' ),
            'my-setting-admin',
            'wptweaker_setting_section_loading_time'
        );
        add_settings_field(
            'wptweaker_setting_11',
            'Disable login error message',
            array( $this, 'callback_wptweaker_setting_11' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_12',
            'Disable new Theme on major WP-Updates',
            array( $this, 'callback_wptweaker_setting_12' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_13',
            'Disable the XML-RPC',
            array( $this, 'callback_wptweaker_setting_13' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_14',
            'Disable post by e-mail function',
            array( $this, 'callback_wptweaker_setting_14' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_15',
            'Remove url-field from comments',
            array( $this, 'callback_wptweaker_setting_15' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_16',
            'Disable url auto-linking in comments',
            array( $this, 'callback_wptweaker_setting_16' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_17',
            'Remove the login-shake for wrong credentials',
            array( $this, 'callback_wptweaker_setting_17' ),
            'my-setting-admin',
            'wptweaker_setting_section_security'
        );
        add_settings_field(
            'wptweaker_setting_18',
            'Automatically empty the WP-trash every 7 days',
            array( $this, 'callback_wptweaker_setting_18' ),
            'my-setting-admin',
            'wptweaker_setting_section_loading_time'
        );
        add_settings_field(
            'wptweaker_setting_19',
            'Remove query strings from ressources',
            array( $this, 'callback_wptweaker_setting_19' ),
            'my-setting-admin',
            'wptweaker_setting_section_loading_time'
        );
        add_settings_field(
            'wptweaker_setting_20',
            'Disable auto-saving of posts',
            array( $this, 'callback_wptweaker_setting_20' ),
            'my-setting-admin',
            'wptweaker_setting_section_database'
        );

    }

    public function wptweaker_sanitize( $wptweaker_input )
    {
        $wptweaker_new_input = array();
        if( isset( $wptweaker_input['wptweaker_setting_1'] ) )
            $wptweaker_new_input['wptweaker_setting_1'] = absint( $wptweaker_input['wptweaker_setting_1'] );
        if( isset( $wptweaker_input['wptweaker_setting_2'] ) )
            $wptweaker_new_input['wptweaker_setting_2'] = absint( $wptweaker_input['wptweaker_setting_2'] );
        if( isset( $wptweaker_input['wptweaker_setting_3'] ) )
            $wptweaker_new_input['wptweaker_setting_3'] = absint( $wptweaker_input['wptweaker_setting_3'] );
        if( isset( $wptweaker_input['wptweaker_setting_4'] ) )
            $wptweaker_new_input['wptweaker_setting_4'] = absint( $wptweaker_input['wptweaker_setting_4'] );
        if( isset( $wptweaker_input['wptweaker_setting_5'] ) )
            $wptweaker_new_input['wptweaker_setting_5'] = absint( $wptweaker_input['wptweaker_setting_5'] );
        if( isset( $wptweaker_input['wptweaker_setting_6'] ) )
            $wptweaker_new_input['wptweaker_setting_6'] = absint( $wptweaker_input['wptweaker_setting_6'] );
        if( isset( $wptweaker_input['wptweaker_setting_7'] ) )
            $wptweaker_new_input['wptweaker_setting_7'] = absint( $wptweaker_input['wptweaker_setting_7'] );
        if( isset( $wptweaker_input['wptweaker_setting_8'] ) )
            $wptweaker_new_input['wptweaker_setting_8'] = absint( $wptweaker_input['wptweaker_setting_8'] );
        if( isset( $wptweaker_input['wptweaker_setting_9'] ) )
            $wptweaker_new_input['wptweaker_setting_9'] = absint( $wptweaker_input['wptweaker_setting_9'] );
        if( isset( $wptweaker_input['wptweaker_setting_10'] ) )
            $wptweaker_new_input['wptweaker_setting_10'] = absint( $wptweaker_input['wptweaker_setting_10'] );
        if( isset( $wptweaker_input['wptweaker_setting_11'] ) )
            $wptweaker_new_input['wptweaker_setting_11'] = absint( $wptweaker_input['wptweaker_setting_11'] );
        if( isset( $wptweaker_input['wptweaker_setting_12'] ) )
            $wptweaker_new_input['wptweaker_setting_12'] = absint( $wptweaker_input['wptweaker_setting_12'] );
        if( isset( $wptweaker_input['wptweaker_setting_13'] ) )
            $wptweaker_new_input['wptweaker_setting_13'] = absint( $wptweaker_input['wptweaker_setting_13'] );
        if( isset( $wptweaker_input['wptweaker_setting_14'] ) )
            $wptweaker_new_input['wptweaker_setting_14'] = absint( $wptweaker_input['wptweaker_setting_14'] );
        if( isset( $wptweaker_input['wptweaker_setting_15'] ) )
            $wptweaker_new_input['wptweaker_setting_15'] = absint( $wptweaker_input['wptweaker_setting_15'] );
        if( isset( $wptweaker_input['wptweaker_setting_16'] ) )
            $wptweaker_new_input['wptweaker_setting_16'] = absint( $wptweaker_input['wptweaker_setting_16'] );
        if( isset( $wptweaker_input['wptweaker_setting_17'] ) )
            $wptweaker_new_input['wptweaker_setting_17'] = absint( $wptweaker_input['wptweaker_setting_17'] );
        if( isset( $wptweaker_input['wptweaker_setting_18'] ) )
            $wptweaker_new_input['wptweaker_setting_18'] = absint( $wptweaker_input['wptweaker_setting_18'] );
        if( isset( $wptweaker_input['wptweaker_setting_19'] ) )
            $wptweaker_new_input['wptweaker_setting_19'] = absint( $wptweaker_input['wptweaker_setting_19'] );
        if( isset( $wptweaker_input['wptweaker_setting_20'] ) )
            $wptweaker_new_input['wptweaker_setting_20'] = absint( $wptweaker_input['wptweaker_setting_20'] );
        return $wptweaker_new_input;
    }

    public function print_section_info()
    {
        print 'Turn each function/feature seperately on or off.';
    }

    public function callback_wptweaker_setting_1()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_1" name="wptweaker_settings[wptweaker_setting_1]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_1'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_1" name="wptweaker_settings[wptweaker_setting_1]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_1'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_2()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_2" name="wptweaker_settings[wptweaker_setting_2]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_2'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_2" name="wptweaker_settings[wptweaker_setting_2]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_2'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_3()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_3" name="wptweaker_settings[wptweaker_setting_3]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_3'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_3" name="wptweaker_settings[wptweaker_setting_3]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_3'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_4()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_4" name="wptweaker_settings[wptweaker_setting_4]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_4'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_4" name="wptweaker_settings[wptweaker_setting_4]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_4'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_5()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_5" name="wptweaker_settings[wptweaker_setting_5]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_5'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_5" name="wptweaker_settings[wptweaker_setting_5]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_5'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_6()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_6" name="wptweaker_settings[wptweaker_setting_6]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_6'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_6" name="wptweaker_settings[wptweaker_setting_6]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_6'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_7()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_7" name="wptweaker_settings[wptweaker_setting_7]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_7'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_7" name="wptweaker_settings[wptweaker_setting_7]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_7'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_8()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_8" name="wptweaker_settings[wptweaker_setting_8]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_8'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_8" name="wptweaker_settings[wptweaker_setting_8]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_8'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_9()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_9" name="wptweaker_settings[wptweaker_setting_9]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_9'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_9" name="wptweaker_settings[wptweaker_setting_9]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_9'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_10()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_10" name="wptweaker_settings[wptweaker_setting_10]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_10'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_10" name="wptweaker_settings[wptweaker_setting_10]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_10'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_11()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_11" name="wptweaker_settings[wptweaker_setting_11]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_11'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_11" name="wptweaker_settings[wptweaker_setting_11]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_11'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_12()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_12" name="wptweaker_settings[wptweaker_setting_12]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_12'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_12" name="wptweaker_settings[wptweaker_setting_12]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_12'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_13()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_13" name="wptweaker_settings[wptweaker_setting_13]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_13'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_13" name="wptweaker_settings[wptweaker_setting_13]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_13'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_14()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_14" name="wptweaker_settings[wptweaker_setting_14]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_14'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_14" name="wptweaker_settings[wptweaker_setting_14]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_14'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_15()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_15" name="wptweaker_settings[wptweaker_setting_15]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_15'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_15" name="wptweaker_settings[wptweaker_setting_15]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_15'] == 1  ? "checked" : ''
             );
     }

     public function callback_wptweaker_setting_16()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_16" name="wptweaker_settings[wptweaker_setting_16]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_16'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_16" name="wptweaker_settings[wptweaker_setting_16]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_16'] == 1  ? "checked" : ''
             );
     }
     public function callback_wptweaker_setting_17()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_17" name="wptweaker_settings[wptweaker_setting_17]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_17'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_17" name="wptweaker_settings[wptweaker_setting_17]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_17'] == 1  ? "checked" : ''
             );
     }
     public function callback_wptweaker_setting_18()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_18" name="wptweaker_settings[wptweaker_setting_18]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_18'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_18" name="wptweaker_settings[wptweaker_setting_18]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_18'] == 1  ? "checked" : ''
             );
     }
     public function callback_wptweaker_setting_19()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_19" name="wptweaker_settings[wptweaker_setting_19]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_19'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_19" name="wptweaker_settings[wptweaker_setting_19]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_19'] == 1  ? "checked" : ''
             );
     }
     public function callback_wptweaker_setting_20()
     {
         printf(
             '<input type="radio" id="wptweaker_setting_20" name="wptweaker_settings[wptweaker_setting_20]" value="0" %s /> off ',
             $this->wptweaker_options['wptweaker_setting_20'] == 0  ? "checked" : ''
             );
         printf(
             '<input type="radio" id="wptweaker_setting_20" name="wptweaker_settings[wptweaker_setting_20]" value="1" %s /> on ',
             $this->wptweaker_options['wptweaker_setting_20'] == 1  ? "checked" : ''
             );
     }

     public static function add_help()
   	{
   		$screen = get_current_screen();

   		$screen->add_help_tab(
   			array(
   				'id'	  => 'wpt_categories',
   				'title'	  => 'Tweaker categories',
   				'content' => '<p>This plugin allows you to optimize the following things about your WordPress:</p>'.
   							 '<ul>'.
   							 	'<li><em>Unneeded header-info</em><br />'.
   							 	'WordPress comes with many header-informations that nobody but the WordPress-devs really need ;)</li>'.

   							 	'<li><em>External ressources and data</em><br />'.
   							 	'WordPress uses a lot of external ressources and data that slow down your blog!</li>'.

   							 	'<li><em>Boosting Database</em><br />'.
   							 	'The database of WordPress can act like a beast. Take controll over it!</li>'.

   							 	'<li><em>Optimize the Page Speed</em><br />'.
   							 	'WordPress comes with sooo many functions and options so speeding WordPress up is always a great idea!</li>'.

                  '<li><em>Security settings</em><br />'.
   							 	'Every tweaking is worthless unless you ignore WordPress security!</li>'.
   							 '</ul>'
   			)
   		);
   		$screen->add_help_tab(
   			array(
   				'id'	  => 'wpt_settings',
   				'title'	  => 'Settings',
   				'content' => '<p><strong>You can activate and deactivate every single option by itself!</strong><p>'.
   							 '<p>Depending on your plugins and installed theme some of the provided features will cause trouble. Try deactvating some of the features whenever you run into any trouble tweaking your WordPress!'
   			)
   		);
   		$screen->add_help_tab(
   			array(
   				'id'	  => 'wpt_documentation',
   				'title'	  => 'Documentation',
   				'content' => '<p>One day there will be an awesome documentation.</p>'.
   							 '<p>I guess.</p>'
   			)
   		);
   		$screen->set_help_sidebar(
   			'<p><strong>About the author</p>'.
   			'<p><a href="https://www.instagram.com/digitalarbyter/" target="_blank">Instagram</a></p>'.
   			'<p><a href="https://digitalarbyter.de" target="_blank">WWW</a></p>'
   		);
   	}

}
?>
