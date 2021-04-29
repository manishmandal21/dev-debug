<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://manishmandal.com
 * @since      1.0.0
 *
 * @package    Dev_Debug
 * @subpackage Dev_Debug/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dev_Debug
 * @subpackage Dev_Debug/admin
 * @author     Manish Mandal <manish.mandal21@gmail.com>
 */
class Dev_Debug_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dev_Debug_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dev_Debug_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dev-debug-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dev_Debug_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dev_Debug_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dev-debug-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function dev_debug_saved_function ($opt) {
	    /** This function is provided to update constants in wp-config file after saving the settings from the panel */

	        $wpdebug = $opt['dev-debug-wp-debug'] == 0 ? 'false' : 'true';
            $config_transformer = new WPConfigTransformer( ABSPATH . 'wp-config.php' );
            $config_transformer->update( 'constant', 'WP_DEBUG', $wpdebug, array( 'raw' => true ) );

            $debuglog = $opt['dev-debug-wp-debug-log'] == 0 ? 'false' : 'true';
            $config_transformer->update( 'constant', 'WP_DEBUG_LOG', $debuglog, array( 'raw' => true ) );

            $debuglogdisplay = $opt['dev-debug-wp-debug-display'] == 0 ? 'false' : 'true';
            $config_transformer->update( 'constant', 'WP_DEBUG_DISPLAY', $debuglogdisplay, array( 'raw' => true ) );

            $debugscript = $opt['dev-debug-script-debug'] == 0 ? 'false' : 'true';
            $config_transformer->update( 'constant', 'SCRIPT_DEBUG', $debugscript, array( 'raw' => true ) );





    }


    public function dev_debug_wp_maintenance_mode() {
        $maintencetext = get_option('dev_debug')['maintenance-mode-text'];
        if (!current_user_can('edit_themes') || !is_user_logged_in()) {
            wp_die(isset($maintencetext) ? $maintencetext : 'The website is under schedule maintenance. Please check after sometime.');
        }
    }

    public function dev_debug_show_template_file_name_on_top( $wp_admin_bar ) {

        if ( is_admin() or ! is_super_admin() ) {
            return;
        }
        global $template;
        $file_name		 = basename( $template );
        $relative_path	 = str_replace( ABSPATH . 'wp-content/', '', $template );
        $current_theme		 = wp_get_theme();
        $current_theme_name	 = $current_theme->Name;
        if ( is_child_theme() ) {
            $child_name	 = __( 'Theme name: ', 'show-current-template' ) . $current_theme_name;
            $parent_theme_name	 = $current_theme->parent()->Name;
            $parent_theme_name	 = ' (' . $parent_theme_name . __( "'s child", 'show-current-template' ) . ")";
            $parent_or_child	 = $child_name . $parent_theme_name;
        } else {
            $parent_or_child = __( 'Theme name: ', 'show-current-template' )
                . $current_theme_name . ' (' . __( 'not a child theme', 'show-current-template' ) . ')';
        }


        global $wp_admin_bar;
        $args = array(
            'id'	 => 'show_template_file_name_on_top',
            'title'	 => __( 'Template:', 'show-current-template' )
                . '<span class="show-template-name"> ' . $file_name . '</span>',
        );

        $wp_admin_bar->add_node( $args );

        $wp_admin_bar->add_menu( array(
            'parent' => 'show_template_file_name_on_top',
            'id'	 => 'template_relative_path',
            'title'	 => __( 'Template Path:', 'show-current-template' )
                . '<span class="show-template-name"> ' . $relative_path . '</span>',
        ) );

        $wp_admin_bar->add_menu( array(
            'parent' => 'show_template_file_name_on_top',
            'id'	 => 'is_child_theme',
            'title'	 => $parent_or_child,
        ) );

    }





}
