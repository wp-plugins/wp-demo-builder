<?php
/**
 * @version    $Id$
 * @package    WPDB_Demo_Builder
 * @author     WPDemoBuilder Team <admin@wpdemobuilder.com>
 * @copyright  Copyright (C) 2014 WPDemoBuilder.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.wpdemobuilder.com
 */

if ( ! class_exists( 'WPDB_Demo_Builder' ) ) :

/**
 *
 * Init Class
 *
 */
class WPDB_Demo_Builder {
	/**
	 * Reference to WordPress file system abstraction.
	 *
	 * @var  object
	 */
	protected static $fs;

	/**
	 * Array of directory/file name needs to be excluded from archiving.
	 *
	 * @var  array
	 */
	protected static $excludes = array( '.git', '.svn', 'site-package', 'wp-demo-builder' );

	/**
	 * Number of directory to archive per chunk.
	 *
	 * @var  integer
	 */
	protected static $chunk = 10;

        /**
         * WP Demo Builder server URL.
         *
         * @var  string
         */
        protected static $server = 'http://www.wpdemobuilder.com/cpanel/';

	/**
	 * Define default settings.
	 *
	 * @var  array
	 */
	protected static $settings = array(
		'enable_button'   => 1,
		'button_position' => 'left',
		'button_label'    => '',
		'button_style'    => 'dark',
		'button_icon'    => '',
	);

	/**
	 * Define remote arguments for Ajax-requests.
	 *
	 * @var  array
	 */
    protected static $remote_get_args = array(
        'timeout'     => 60,
    );

        protected static $multisites_extra_tables = array(
            'blogs',
            'blog_versions',
            'registration_log',
            'signups',
            'site',
            'sitemeta',
            'sitecategories'
        );
        /**
         * Define icons for demo buider register button.
         *
         * @var  array
         */
        protected static $ico_moon = array("icon-home" => "home", "icon-user" => "user", "icon-locked" => "locked",
            "icon-comments" => "comments", "icon-comments-2" => "comments-2", "icon-out" => "out",
            "icon-redo" => "redo", "icon-undo" => "undo", "icon-file-add" => "file-add",
            "icon-plus" => "plus", "icon-pencil" => "pencil", "icon-pencil-2" => "pencil-2",
            "icon-folder" => "folder", "icon-folder-2" => "folder-2", "icon-picture" => "picture",
            "icon-pictures" => "pictures", "icon-list-view" => "list-view", "icon-power-cord" => "power-cord",
            "icon-cube" => "cube", "icon-puzzle" => "puzzle", "icon-flag" => "flag",
            "icon-tools" => "tools", "icon-cogs" => "cogs", "icon-cog" => "cog",
            "icon-equalizer" => "equalizer", "icon-wrench" => "wrench", "icon-brush" => "brush",
            "icon-eye" => "eye", "icon-checkbox-unchecked" => "checkbox-unchecked", "icon-checkbox" => "checkbox",
            "icon-checkbox-partial" => "checkbox-partial", "icon-star" => "star", "icon-star-2" => "star-2",
            "icon-star-empty" => "star-empty", "icon-calendar" => "calendar", "icon-calendar-2" => "calendar-2",
            "icon-help" => "help", "icon-support" => "support", "icon-warning" => "warning",
            "icon-checkmark" => "checkmark", "icon-cancel" => "cancel", "icon-minus" => "minus",
            "icon-remove" => "remove", "icon-mail" => "mail", "icon-mail-2" => "mail-2",
            "icon-drawer" => "drawer", "icon-drawer-2" => "drawer-2", "icon-box-add" => "box-add",
            "icon-box-remove" => "box-remove", "icon-search" => "search", "icon-filter" => "filter",
            "icon-camera" => "camera", "icon-play" => "play", "icon-music" => "music",
            "icon-grid-view" => "grid-view", "icon-grid-view-2" => "grid-view-2", "icon-menu" => "menu",
            "icon-thumbs-up" => "thumbs-up", "icon-thumbs-down" => "thumbs-down", "icon-cancel-2" => "cancel-2",
            "icon-plus-2" => "plus-2", "icon-minus-2" => "minus-2", "icon-key" => "key",
            "icon-quote" => "quote", "icon-quote-2" => "quote-2", "icon-database" => "database",
            "icon-location" => "location", "icon-zoom-in" => "zoom-in", "icon-zoom-out" => "zoom-out",
            "icon-expand" => "expand", "icon-contract" => "contract", "icon-expand-2" => "expand-2",
            "icon-contract-2" => "contract-2", "icon-health" => "health", "icon-wand" => "wand",
            "icon-refresh" => "refresh", "icon-vcard" => "vcard", "icon-clock" => "clock",
            "icon-compass" => "compass", "icon-address" => "address", "icon-feed" => "feed",
            "icon-flag-2" => "flag-2", "icon-pin" => "pin", "icon-lamp" => "lamp",
            "icon-chart" => "chart", "icon-bars" => "bars", "icon-pie" => "pie",
            "icon-dashboard" => "dashboard", "icon-lightning" => "lightning",
            "icon-move" => "move", "icon-next" => "next", "icon-previous" => "previous",
            "icon-first" => "first", "icon-last" => "last", "icon-loop" => "loop",
            "icon-shuffle" => "shuffle", "icon-arrow-first" => "arrow-first", "icon-arrow-last" => "arrow-last",
            "icon-arrow-up" => "arrow-up", "icon-arrow-right" => "arrow-right", "icon-arrow-down" => "arrow-down",
            "icon-arrow-left" => "arrow-left", "icon-arrow-up-2" => "arrow-up-2", "icon-arrow-right-2" => "arrow-right-2",
            "icon-arrow-down-2" => "arrow-down-2", "icon-arrow-left-2" => "arrow-left-2", "icon-play-2" => "play-2",
            "icon-menu-2" => "menu-2", "icon-arrow-up-3" => "arrow-up-3", "icon-arrow-right-3" => "arrow-right-3",
            "icon-arrow-down-3" => "arrow-down-3", "icon-arrow-left-3" => "arrow-left-3", "icon-printer" => "printer",
            "icon-color-palette" => "color-palette", "icon-camera-2" => "camera-2", "icon-file" => "file",
            "icon-file-remove" => "file-remove", "icon-copy" => "copy", "icon-cart" => "cart",
            "icon-basket" => "basket", "icon-broadcast" => "broadcast", "icon-screen" => "screen",
            "icon-tablet" => "tablet", "icon-mobile" => "mobile", "icon-users" => "users",
            "icon-briefcase" => "briefcase", "icon-download" => "download", "icon-upload" => "upload",
            "icon-bookmark" => "bookmark", "icon-out-2" => "out-2" );
        /**
         * Hook into WordPress.
         *
         * @return  void
         */
        public static function hook() {
        // Register plugin activation action
        register_activation_hook( WPDB_PLUGIN, array( __CLASS__, 'check_localhost' ) );

		// Register filter to add extra query variable
		add_filter( 'query_vars', array( __CLASS__, 'query_vars' ) );

		// Register action to check extra query variable
		add_action( 'parse_query', array( __CLASS__, 'parse_query' ) );

		// Register init action
		//add_action( 'init', array( __CLASS__, 'check_localhost' ) );
		add_action( 'init', array( __CLASS__, 'init'            ) );

		add_action( 'admin_init', array( __CLASS__, 'wpdb_plugin_redirect' ) );
	}

	/**
	 * Auto redirect user after active the plugin
	 *
	 * @return void
	 */

	public static function wpdb_plugin_redirect()
	{
		$url = admin_url( 'admin.php?page=wpdb-base-site' );
		if ( get_option( 'wpdb_activation_redirect', false ) ) {
			delete_option( 'wpdb_activation_redirect' );
			wp_redirect( $url );
		}
	}

	/**
	 * Check if plugin is installed on localhost when being activated.
	 *
	 * @return void
	 */
	public static function check_localhost() {
		$is_local = false;

		if ( in_array($_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) {
			$is_local = true;
		}

		if ( 0 == strcasecmp( 'localhost', $_SERVER['HTTP_HOST'] ) ) {
			$is_local = true;
		}

		if ( preg_match( '/^(192\.168\.\d+\.\d+|172\.(1[6-9]|2[0-9]|3[01])\.\d+\.\d+|10\.\d+\.\d+\.\d+|169\.254\.\d+\.\d+)$/', $_SERVER['HTTP_HOST'] ) ) {
			$is_local = true;
		}

		if ( $is_local ) {
			// Our plugin cannot run properly on localhost server, deactivate it
			deactivate_plugins( WPDB_PLUGIN, true, is_network_admin() );

			// Then, redirect to an error page
			//if ( doing_action( 'init' ) ) {
				//wp_die( __( 'We are sorry! You cannot run WP Demo Builder plugin in localhost environment.', WPDB_TEXT ) );
			//} else {
			die( __( 'We are sorry! You cannot run WP Demo Builder plugin in localhost environment.', WPDB_TEXT ) );
			//}

			// Exit immediately to prevent WordPress from processing further
			exit;
		}

		add_option( 'wpdb_activation_redirect', true );
	}

        /**
         * Check multisite is enabled
         */
        static function check_multisite()
        {
            if(defined('MULTISITE') && MULTISITE === true)
            {
                return true;
            }
            return false;
        }

        /**
         * Check plugin active for network
         *
         * @return bool
         */
        static function check_is_active_for_network()
        {
            if ( ! function_exists( 'is_plugin_active_for_network' ) )
                require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
            // Makes sure the plugin is defined before trying to use it
            if ( is_plugin_active_for_network( 'wp-demo-builder/main.php' ) ) {
                return true;
            }
            return false;
        }

        /**
         * Register extra query variable.
         *
         * @param   array  $qvars  Current allowed query variables.
         *
         * @return  array
         */
        public static function query_vars( $qvars ) {
            array_push( $qvars, 'wp-demo-builder-action' );

		return $qvars;
	}

        /**
         * Check extra query variable.
         *
         * @param   object  $wp_query  WordPress query object.
         *
         * @return  void
         */
        public static function parse_query( $wp_query ) {
            if ( 'download' == $wp_query->get( 'wp-demo-builder-action' ) ) {

			// Get random string
			$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

                if ( is_null( $rand ) ) {
                    throw new Exception( __( 'Invalid session key.', WPDB_TEXT ) );
                }

			$file_name = 'temp_archive_' . $rand;

			// Force download site package
			self::download_package($file_name);
		}
	}

	/**
	 * Initialization.
	 *
	 * @return  void
	 */
	public static function init() {
		// Get global variables
		global $pagenow;

        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');

        self::$fs = new WP_Filesystem_Direct(array());

		// Add admin menu
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		// Register AJAX action if requested page is `admin-ajax.php`
		if ( 'admin-ajax.php' == $pagenow ) {
			add_action( 'wp_ajax_wp-demo-builder', array( __CLASS__, 'do_action' ) );
		}

		// Register action to load assets for WP Demo Builder button in frontend
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'frontend_assets' ) );

		// Register action to render WP Demo Builder button in frontend
		add_action( 'wp_print_footer_scripts', array( __CLASS__, 'print_embed_code' ) );
	}

	/**
	 * Add admin menu for base site page.
	 *
	 * @return  void
	 */
	public static function admin_menu() {
		// Register admin menus
		add_menu_page(
			__( 'Demo Builder', WPDB_TEXT ), // Page title
			__( 'Demo Builder', WPDB_TEXT ), // Menu name
			'export',                        // Required capability
			'wpdb-base-site',                // Menu slug
			array( __CLASS__, 'base_site' ), // Associated function
			null,                            // Menu icon
			'50.' . rand( 1000, 9999 )       // Menu position
		);

		add_submenu_page(
			'wpdb-base-site',                // Parent slug
			__( 'Demo Builder', WPDB_TEXT ), // Page title
			__( 'Base Site', WPDB_TEXT ),    // Menu name
			'export',                        // Required capability
			'wpdb-base-site',                // Menu slug
			array( __CLASS__, 'base_site' )  // Associated function
		);

		add_submenu_page(
			'wpdb-base-site',                         // Parent slug
			__( 'Demo Builder Settings', WPDB_TEXT ), // Page title
			__( 'Settings', WPDB_TEXT ),              // Menu name
			'manage_options',                         // Required capability
			'wpdb-embed-settings',                    // Menu slug
			array( __CLASS__, 'embed_settings' )      // Associated function
		);
	}

	/**
	 * Render base site page.
	 *
	 * @return  void
	 */
	public static function base_site() {
		// Enqueue assets
		self::enqueue_assets( 'base_site' );

		// Get latest site package
		//$file = self::get_package();

		/*if ( ! empty( $file ) ) {
			// Convert file size from byte unit to MB
			$file['size'] = ( round( $file['size'] / 1048576, 2 ) ) . ' MB';
		}*/

			// Get local plugin information
			$plugin_file = basename( ( WPDB_PLUGIN ) );
			$local_plugin_info = get_plugins( '/' . WPDB_TEXT );
			$local_plugin_version = $local_plugin_info[$plugin_file]['Version'];
			
			// Get remote plugin information from wordpress.org
			require( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			$remote_plugin_info = plugins_api( 'plugin_information', array( 'slug' => WPDB_TEXT ) );
			
			/** Check for Errors & Display the results */
			if ( is_wp_error( $remote_plugin_info ) ) {
				
				$notificationMsg = 'Cannot connect to WordPress SubVersion to get the plugin information.';
				include_once dirname( dirname( __FILE__ ) ) . '/templates/update-plugin-notification.php';
				return true;
				
			}
			
			$remote_plugin_version = $remote_plugin_info->version;
			
			/** Check version if local version < reomote version, then force user to update the plugin to the latest version */
			if (version_compare($local_plugin_version, $remote_plugin_version, '<'))
			{
				$notificationMsg = 'Current version of WPDemoBuilder plugin is outdated! Please update to latest version.';
				include_once dirname( dirname( __FILE__ ) ) . '/templates/update-plugin-notification.php';
				return true;
			}
		
            //Check folder upload is wriable or not
            $isWriableUploadsDir = true;
            $path = wp_upload_dir();
            if ( !is_writable( $path['basedir'] ) ) {
                $isWriableUploadsDir = false;
            }
            $apppath = ABSPATH;
            $folders = array(ABSPATH.'wp-admin',ABSPATH.'wp-content/index.php',ABSPATH.'wp-includes',ABSPATH.'wp-config.php',ABSPATH.'wp-load.php',ABSPATH.'wp-blog-header.php',ABSPATH.'wp-settings.php');
            foreach( $folders as $folder ) {
                if ( self::check_perms($folder) === false ) {
                    $isWriableUploadsDir = false;
                }
            }
            $multisiteEnabled  = self::check_multisite();
            // Load page template
            include_once dirname( dirname( __FILE__ ) ) . '/templates/base-site.php';
       }

        static function check_perms($check) {
            if( !is_file($check) && is_dir($check) ) {
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($check,
                        RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::SELF_FIRST);
                foreach ($iterator as $fileinfo) {
                    if ( is_dir($fileinfo) ) {
                        return self::check_perms($fileinfo);
                    }
                    if (!$fileinfo->isWritable()) {

                        return false;
                    }
                }
            }elseif( is_file($check) ) {
                return is_writable($check);
            }else {
                return false;
            }
        }
        /**
         * Render settings page.
         *
         * @return  void
         */
        public static function embed_settings() {
            // Enqueue assets
            self::enqueue_assets( 'embed_settings', false );

            // Check if we need to save settings
            if ( ! empty( $_POST ) ) {
                $settings = self::$settings;

                // Validate input
                foreach ( $settings as $key => $default ) {
                    if ( isset( $_POST[ $key ] ) ) {
                        // State that settings should be saved
                        $save = true;

                        $settings[ $key ] = esc_sql( $_POST[ $key ] );
                    }
                }
            }

            // Save settings
            if ( isset( $save ) && true === $save ) {
                update_option( 'wp_demo_builder_settings', $settings );
            }

            // Get saved settings
            if ( ! isset( $settings ) ) {
                $settings = get_option( 'wp_demo_builder_settings', self::$settings );
            }

            // Get Iconmoo
            $icon_moons = self::$ico_moon;
            asort($icon_moons);

            // Load settings template
            include_once dirname( dirname( __FILE__ ) ) . '/templates/embed-settings.php';
        }

        /**
         * Enqueue assets for base site page.
         *
         * @param   string   $page       Page asset name.
         * @param   boolean  $load_base  Whether to load base assets or not?
         *
         * @return  void
         */
        protected static function enqueue_assets( $page, $load_base = true ) {
            // Google Font
            wp_enqueue_style("GoogleFontTitiliumWeb", "http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,600,700,900");
            if ( $page != 'embed_settings' ) {
                // 3rd-party CSS
                wp_enqueue_style( 'bootstrap', plugins_url( 'assets/3rd-party/bootstrap-3.1.1-dist/css/bootstrap.min.css', dirname( __FILE__ ) ) );
                wp_enqueue_style( 'bootstrap-theme', plugins_url( 'assets/3rd-party/bootstrap-3.1.1-dist/css/bootstrap-theme.min.css', dirname( __FILE__ ) ) );
            }

            if ( $page == 'embed_settings' ) {
                // 3rd-party Iconmoon CSS
                wp_enqueue_style( 'wpdb-icon-moon', plugins_url( 'assets/3rd-party/font-icomoon/css/icomoon.css', dirname( __FILE__ ) ) );
            }

            // 3rd-party JS
            wp_enqueue_script( 'bootstrap', plugins_url( 'assets/3rd-party/bootstrap-3.1.1-dist/js/bootstrap.min.js', dirname( __FILE__ ) ) );

            // Load base assets if requested
            if ( $load_base ) {
                wp_enqueue_style ( 'wpdb-base', plugins_url( 'assets/css/base.css', dirname( __FILE__ ) ) );
                wp_enqueue_script( 'wpdb-base', plugins_url( 'assets/js/base.js'  , dirname( __FILE__ ) ) );

                // Load socket.io
                wp_enqueue_script( 'socket-io', 'http://www.wpdemobuilder.com:3000/socket.io/socket.io.js' );
            }

            // Load page specific assets
            $page = str_replace( '_', '-', $page );

            wp_enqueue_style ( $page, plugins_url( "assets/css/{$page}.css", dirname( __FILE__ ) ) );
            wp_enqueue_script( $page, plugins_url( "assets/js/{$page}.js"  , dirname( __FILE__ ) ) );
        }

        /**
         * Get site package.
         *
         * @return  array  An array containing path, URL, creation time and file size of site package. NULL will be returned if there is no any site package exists.
         */
        protected static function get_package($file_name) {
            // Check if any site package exists
            $path = wp_upload_dir();
            $file = glob( $path['basedir'] . '/site-package/' . $file_name . '.zip' );

            if ( ! $file || ! count( $file ) ) {
				throw new Exception( __( 'Cannot make zip file', WPDB_TEXT ) );
            } else {
                /*if ( count( $file ) > 1 ) {
                    // Keep only latest site package
                    sort( $file );

				for ( $i = 0, $n = count( $file ) - 1; $i < $n; $i++ ) {
					self::$fs->delete( $file[ $i ] );
				}
			}*/

                // Prepare data for site package
                $file = array_pop( $file );
                $link = str_replace( '\\', '/', str_replace( $path['basedir'], $path['baseurl'], $file ) );
                $time = date( 'M jS, g:i a', self::$fs->mtime( $file ) );
                $size = self::$fs->size( $file );
				return array( 'file' => $file, 'link' => $link, 'time' => $time, 'size' => $size );
            }
        }

	/**
	 * Do AJAX action.
	 *
	 * @return  void
	 */
	public static function do_action() {
		try {
			// Verify action state
			$state = isset( $_GET['state'] ) ? $_GET['state'] : null;

			if ( empty( $state ) || ! method_exists( __CLASS__, $state ) ) {
				throw new Exception( __( 'Invalid processing state.', WPDB_TEXT ) );
			}

			// Make sure directory for storing site package does exists
			$path = wp_upload_dir();
			$basedir = $path['basedir'];
			$path = $basedir . '/site-package';

			// Check folder upload is wriable or not
			if ( !is_writable( $basedir ) ) {
				throw new Exception( __( 'The UPLOADS folder is UNWRITABLE', WPDB_TEXT ) );
			}

			if ( ! self::$fs->exists( $path ) || ! self::$fs->is_dir( $path ) ) {
				if ( ! self::$fs->mkdir( $path ) ) {
					throw new Exception( __( 'Cannot create directory to store base site package.', WPDB_TEXT ) );
				}
			}

			// Execute current state
			$result = array(
				'status' => 'success',
				'data'   => call_user_func( array( __CLASS__, $state ) ),
			);
		} catch ( Exception $e ) {
			$result = array(
				'status' => 'failure',
				'data'   => $e->getMessage(),
			);
		}

            // Send response then exit immediately
            exit( json_encode( $result ) );
        }
        protected static function show_multisites() {
            $sites = wp_get_sites(
                array(
                    'public'     => 1,
                    'archived'   => 0,
                    'mature'     => 0,
                    'spam'       => 0,
                    'deleted'    => 0,
                )
            );
            // Load template to render form for choosing base site to work with
            include_once dirname( dirname( __FILE__ ) ) . '/templates/multisites.php';
            exit;
        }
        /**
         * Authenticate Demo Builder customer.
         *
         * @return  void
         */
        protected static function authenticate() {
            // Preset handle
            $handle = 'login';

            // Get customer email and password to authenticate
            $email    = isset( $_POST['email'   ] ) ? $_POST['email'   ] : null;
            $password = isset( $_POST['password'] ) ? $_POST['password'] : null;
            // Get task
            $task = isset( $_REQUEST['task'] ) ? $_REQUEST['task'] : null;

		if ( ! empty( $email ) && ! empty( $password ) && ! empty( $task ) ) {
			// Build query
			$query[] = 'email='    . $email;
			$query[] = 'password=' . $password;
			$query[] = 'task='     . $task;
            $query[] = 'remoteurl=' . urlencode(site_url());
            $query[] = 'version=' . self::get_wpdemobuilder_version();

			if ( isset( $_REQUEST['base_site_id'] ) ) {
				$query[] = 'base_site_id=' . (int) $_REQUEST['base_site_id'];
			}

			$query = implode( '&', $query );

			// Send authentication request to WP Demo Builder server
			$result = wp_remote_get( self::$server . 'customer/remote-authentication?' . $query, self::$remote_get_args );

			if ( is_wp_error( $result ) ) {
				exit( $result->get_error_message() );
			} else {
				// Parse server response
				$request = json_decode( $result['body'] );

				if ( ! $request ) {
					// Invalid server response
					exit( $result['body'] );
				} else {
					// Preset handle
					$handle = 'execute';

					if ( 'login_fail' == $request->status ) {
						// Customer authentication fail
						$handle = 'login';
						$error  = $request->response;
					} elseif ( 'confirm' == $request->status ) {
						// Customer has to confirm which base site to work with
						$handle = 'confirm';
					}
				}
			}
		}

		switch ( $handle ) {
			case 'login':
				// Load template to render form for authentication
				include_once dirname( dirname( __FILE__ ) ) . '/templates/authenticate.php';
			break;

			case 'confirm':
				// Load template to render form for choosing base site to work with
				include_once dirname( dirname( __FILE__ ) ) . '/templates/select-site.php';
			break;

                case 'execute':

                    if( !is_object( $request->response ) ) {
                        $request->response = (object) $request->response;
                    }
                    // Store base site id to response object
                    $request->response->base_site_id = isset( $_REQUEST['base_site_id'] ) ? (int) $_REQUEST['base_site_id'] : 0;

				// Execute custom function
				if ( method_exists( __CLASS__, $task ) ) {
					$request = call_user_func( array( __CLASS__, $task ), $request );
				}

				// Send response
				exit( json_encode( $request->response ) );
			break;
		}

		// Exit immediately to prevent the plugin from generating and returning JSON status
		exit;
	}

	/**
	 * Cancel site archiving process.
	 *
	 * @return  void
	 */
	protected static function cancel() {
		// Get random string
		$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

		if ( is_null( $rand ) ) {
			throw new Exception( __( 'Invalid random string.', WPDB_TEXT ) );
		}

		// Get site package directory
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/site-package/';
		$sql_path = $path . $rand . '/';

		// Delete database dump file
		if ( self::$fs->exists( $sql_path ) || self::$fs->is_dir( $sql_path ) ) {
			self::$fs->rmdir( $sql_path, true );
		}

		// Delete directory list file
		if ( self::$fs->exists( $path . 'directory_list.tmp' ) && self::$fs->is_file( $path . 'directory_list.tmp' ) ) {
			self::$fs->delete( $path . 'directory_list.tmp' );
		}

		// Delete temporary archive file
		$temp_archive_name = 'temp_archive_' . $rand . '.zip';

		if ( self::$fs->exists( $path . $temp_archive_name ) && self::$fs->is_file( $path . $temp_archive_name ) ) {
			self::$fs->delete( $path . $temp_archive_name );
		}

		return;
	}

	/**
	 * Prepare database for exporting.
	 *
	 * @return  void
	 */
	protected static function prepare_db() {
		global $wpdb, $table_prefix;


            if( isset($_REQUEST['blog_id']) && !empty($_REQUEST['blog_id']) ) {
                $table_prefix = $wpdb->get_blog_prefix($_REQUEST['blog_id']);
                $tables = $wpdb->tables( 'blog', true , (int) $_REQUEST['blog_id'] );
                if ( !in_array( 'users', array_keys($tables) ) ) {
                    $tables[ 'users' ] = $table_prefix . 'users';
                    $tables[ 'usermeta' ] = $table_prefix . 'usermeta';
                }
                $tables = array_values($tables);
            } else {
                $tables = array_keys( $wpdb->get_results( "SHOW TABLES", OBJECT_K ) );
            }

            return array(
                'current' => 0,
                'total'   => count( $tables ),
                'name'    => substr( current($tables), strlen( $table_prefix ) ),
            );
        }

	/**
	 * Export requested database table.
	 *
	 * @return  void
	 */
	protected static function export_db() {
		global $wpdb, $table_prefix;

		// Get random string
		$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

		if ( is_null( $rand ) ) {
			throw new Exception( __( 'Invalid random string.', WPDB_TEXT ) );
		}

            if( isset($_REQUEST['blog_id']) && !empty($_REQUEST['blog_id']) ) {
                $table_prefix = $wpdb->get_blog_prefix($_REQUEST['blog_id']);
                // Get all database tables
                $tables = $wpdb->tables( 'blog', true , (int) $_REQUEST['blog_id'] );

                if ( !in_array( 'users', array_keys($tables) ) ) {
                    $tables[ 'users' ] = $table_prefix . 'users';
                    $tables[ 'usermeta' ] = $table_prefix . 'usermeta';
                }
                $tables = array_values($tables);
            } else {
                // Get all database tables
                $tables = array_keys( $wpdb->get_results( 'SHOW TABLES;', OBJECT_K ) );
            }

            // Get table being exported
            $table = isset( $_GET['from'] ) ? $table_prefix . $_GET['from'] : null;
            $alias_table = defined('BLOG_ID_CURRENT_SITE') ? $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE) . $_GET['from'] : $table;
            // Get real table

            if ( empty( $table ) || false === ( $index = array_search( $table, $tables ) ) ) {
                throw new Exception( __( 'Invalid database table name.', WPDB_TEXT ) );
            }

            $real_table = $table;

            if( isset( $_REQUEST['blog_id'] ) && ! empty( $_REQUEST['blog_id'] ) ) {
                if ( $_GET['from'] == 'users' || $_GET['from'] == 'usermeta' ) {
                    // check if exist table users
                    if($wpdb->get_var("SHOW TABLES LIKE '". $table ."'") != $table ) {
                        $real_table = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE) . $_GET['from'];
                    }
                }
            }

            // Export table structure and data
            $export = array();

            // Drop existing table first
            $export[] = "DROP TABLE IF EXISTS `{$alias_table}`;";

            // Get table creation schema
            $results = $wpdb->get_results( "SHOW CREATE TABLE `{$real_table}`;", ARRAY_A );
            $results = str_replace( 'CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $results[0]['Create Table'] );
            $results = str_replace( $real_table , $alias_table , $results );

            $export[] = str_replace( "\n", '', $results ) . ';';

            // Get table data
            $results = $wpdb->get_results( "SELECT * FROM `{$real_table}` WHERE 1;", ARRAY_A );

            if( isset( $_REQUEST['blog_id'] ) && ! empty( $_REQUEST['blog_id'] ) ) {
                if ( $_GET['from'] == 'users' || $_GET['from'] == 'usermeta' ) {
                    $users_of_blog = get_users(array(
                        'blog_id' => (int) $_REQUEST['blog_id']
                    ));
                    if ( !empty( $users_of_blog ) ) {
                        if( count( $users_of_blog ) === 1 ) {
                            if( $_GET['from'] == 'users' ) {
                                $results = $wpdb->get_results( "SELECT * FROM `{$real_table}` WHERE user_login = '".$users_of_blog[0]->user_login."';", ARRAY_A );
                            } elseif ( $_GET['from'] == 'usermeta' ) {
                                $results = $wpdb->get_results( "SELECT * FROM `{$real_table}` WHERE user_id = '".$users_of_blog[0]->ID."';", ARRAY_A );
                            }
                        } elseif ( count( $users_of_blog ) > 1 ) {
                            $user_login_array = array();
                            foreach ( $users_of_blog as $user_of_blog ) {
                                $user_login_array[] = $user_of_blog->ID;
                            }
                            if( $_GET['from'] == 'users' ) {
                                $results = $wpdb->get_results( "SELECT * FROM `{$real_table}` WHERE ID IN ('".implode('\',\'',$user_login_array)."');", ARRAY_A );
                            } elseif ( $_GET['from'] == 'usermeta' ) {
                                $results = $wpdb->get_results( "SELECT * FROM `{$real_table}` WHERE user_id IN ('".implode('\',\'',$user_login_array)."');", ARRAY_A );
                            }
                        }
                    }
                }
            }
            $counted = 0;

		foreach ( $results as $result ) {
			if ( ! isset( $keys ) || $counted > 9 ) {
				if ( ! isset( $keys ) ) {
					// Generate table keys
					$keys = '(`' . implode( '`, `',   array_keys( $result ) ) . '`)';
				} else {
					// Get current index
					$current = count( $export ) - 1;

					// Update last INSERT query
					$export[ $current ] = substr( $export[ $current ], 0, -1 ) . ';';

					// Reset the number of row dumped
					$counted = 0;
				}

                    $export[] = "INSERT INTO `{$alias_table}` {$keys} VALUES";
                }

			// Prepare table values
			if ( $table_prefix . 'options' == $table && 'active_plugins' == $result['option_name'] ) {
				$active_plugins = maybe_unserialize( $result['option_value'] );
				$remain_plugins = array();

				// Remove WP Demo Builder plugin from active plugins list
				foreach ( $active_plugins as $plugin ) {
					if ( 'wp-demo-builder/main.php' != $plugin ) {
						$remain_plugins[] = $plugin;
					}
				}

				$result['option_value'] = maybe_serialize( $remain_plugins );
			}

                if ( $table_prefix . 'options' == $table && $table_prefix . 'user_roles'  == $result['option_name'] ) {

                    if( defined('BLOG_ID_CURRENT_SITE') ) {
                        $result['option_name'] = $wpdb->get_blog_prefix(BLOG_ID_CURRENT_SITE) . 'user_roles';
                    }
                }
                // Generate table values
                $values = array();

			foreach ( array_values( $result ) as $value ) {
				$values[] = str_replace( array( '\\', "\r", "\n", "'" ), array( '\\\\', '\\r', '\\n', "\\'" ), $value );
			}

			$export[] = "('" . implode( "', '", $values ) . "'),";

			// Inscrease the number of row dumped
			$counted++;
		}

		// Save exported SQL statement to file
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/site-package/';
		$sql_path = $path . $rand . '/';

		if ( ! self::$fs->exists( $sql_path ) || ! self::$fs->is_dir( $sql_path ) ) {
			if ( ! self::$fs->mkdir( $sql_path ) ) {
				throw new Exception( __( 'Cannot create directory to store database file.', WPDB_TEXT ) );
			}
		}
		$export = implode( "\n", $export );
		$export = substr( $export, 0, -1 ) . ';';

		if ( $index > 0 ) {
			$export = self::$fs->get_contents( $sql_path . 'database_dump.sql' ) . "\n\n{$export}";
		}

		if ( ! self::$fs->put_contents( $sql_path . 'database_dump.sql', $export ) ) {
			throw new Exception( __( 'Cannot write exported database to file.', WPDB_TEXT ) );
		}

		// Add database dump file to the root of site package if the whole database is exported
		if ( ! isset( $tables[ ++$index ] ) ) {
			// Delete junk temporary archive file
			$temp_archive_name = 'temp_archive_' . $rand . '.zip';

			if ( self::$fs->exists( $path . $temp_archive_name ) && self::$fs->is_file( $path . $temp_archive_name ) ) {
				self::$fs->delete( $path . $temp_archive_name );
			}

			// Create temporary archive file
			if ( ! self::update_archive( $sql_path . 'database_dump.sql', $rand, $sql_path ) ) {
				throw new Exception( __( 'Cannot create site package archive.', WPDB_TEXT ) );
			}

			// Remove database dump file
			self::$fs->rmdir( $sql_path, true );
		}

		return array(
			'current' => $index,
			'total'   => count( $tables ),
			'name'    => isset( $tables[ $index ] ) ? substr( $tables[ $index ], strlen( $table_prefix ) ) : null,
		);
	}

	/**
	 * Prepare files for archiving.
	 *
	 * @return  void
	 */
	protected static function prepare_files() {
		// Get all nested directories inside WordPress directory
		$directories = self::get_directories();

		// Write directory list to a temporary file so we don't need to get it again
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/site-package/directory_list.tmp';

		self::$fs->put_contents( $path, json_encode( $directories ) );

		return array(
			'current' => 0,
			'total' => count( $directories ),
			'name' => substr( $directories[0], strlen( ABSPATH ) ),
		);
	}

        /**
         * Archive requested directories.
         *
         * @return  void
         */
        protected static function archive_files() {
            global $wpdb , $table_prefix;
            if( isset($_REQUEST['blog_id']) && !empty($_REQUEST['blog_id']) ) {
                $table_prefix = $wpdb->get_blog_prefix($_REQUEST['blog_id']);
            }
            // Get all nested directories inside WordPress directory
            $path  = wp_upload_dir();
            $cache = $path['basedir'] . '/site-package/directory_list.tmp';

		if ( ! self::$fs->exists( $cache ) || ! self::$fs->is_file( $cache ) ) {
			$directories = self::get_directories();
		} else {
			$directories = json_decode( self::$fs->get_contents( $cache ) );
		}

		// Get starting index of directories being archived
		$index = isset( $_GET['from'] ) ? (int) $_GET['from'] : null;

            if ( is_null( $index ) || ! isset( $directories[ $index ] ) ) {
                throw new Exception( __( 'Invalid directory structure.', WPDB_TEXT ) );
            }

		// Get random string
		$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

            if ( is_null( $rand ) ) {
                throw new Exception( __( 'Invalid session key.', WPDB_TEXT ) );
            }

		// Get all files being archived
		$total = count( $directories );
		$files = array();

		for ( $i = $index; $i < $total && $i < ($index + self::$chunk); $i++ ) {
			$items = self::$fs->dirlist( $directories[ $i ] );

			foreach ( $items as $item ) {
				if ( 'f' == $item['type'] ) {
					// Generate full path to this file
					$item = rtrim( $directories[ $i ], '\\/' ) . '/' . $item['name'];

					// Store this file to list
					$files[] = $item;
				}
			}

		}

		// Add these files to site package
		self::update_archive( $files, $rand );

		// Delete cache file if site archiving is completed
		if ( ! isset( $directories[ $i ] ) && self::$fs->exists( $cache ) && self::$fs->is_file( $cache ) ) {
			self::$fs->delete( $cache );
		}

		return array(
			'current' => $i,
			'total'   => $total,
			'name'    => substr( isset( $directories[ $i ] ) ? $directories[ $i ] : $directories[ $total - 1 ], strlen( ABSPATH ) ),
		);
	}

	/**
	 * Add files to archive.
	 *
	 * @param   mixed   $files     Either a file path or array of file path.
	 * @param   string  $base_dir  Base directory to remove from file path inside archive.
	 * @param   string  $archive   Path to archive file.
	 *
	 * @return  boolean
	 */
	protected static function update_archive( $files, $postfix, $base_dir = ABSPATH ) {
		// Generate path to temporary archive file
		$archive = wp_upload_dir();
		$archive = $archive['basedir'] . '/site-package/temp_archive_' . $postfix . '.zip';

		// Instantiate a PclZip object to archive files
		if ( ! class_exists( 'PclZip' ) ) {
			include_once ABSPATH . 'wp-admin/includes/class-pclzip.php';
		}

		$archive = new PclZip( $archive );

		// Add files to archive
		return $archive->add( $files, PCLZIP_OPT_REMOVE_PATH, $base_dir );
	}

	/**
	 * Get all nested directories from WordPress root path.
	 *
	 * @params  string  $path  Path to look for sub-directories.
	 *
	 * @return  void
	 */
	protected static function get_directories( $path = ABSPATH ) {
		// Prepare variable to hold the list of directories
		static $directories;

		if ( ! isset( $directories ) ) {
			$directories = array( ABSPATH );
		}

		// Get sub-directories
		if ( $items = self::$fs->dirlist( $path ) ) {
			foreach ( $items as $item ) {
				if ( 'd' == $item['type'] && ! in_array( basename( $item['name'] ), self::$excludes ) ) {
					// Generate full path to this directory
					$item = rtrim( $path, '\\/' ) . '/' . $item['name'];

					// Store directory to list
					$directories[] = $item;

					// Get nested sub-directories
					self::get_directories( $item );
				}
			}
		}

		return $directories;
	}

	/**
	 * Push base site package to WP Demo Builder server.
	 *
	 * @return  void
	 */
	protected static function push_package() {

		// Get random string
		$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

            if ( is_null( $rand ) ) {
                throw new Exception( __( 'Invalid session key.', WPDB_TEXT ) );
            }

		// Get site package directory
		//$path = wp_upload_dir();
		//$path = $path['basedir'] . '/site-package/';
		//$file = date( 'Y-m-d_H-i-s' ) . '.zip';

		// Rename temporary archive file
		$file_name 	= 'temp_archive_' . $rand;
		//self::$fs->move( $path . 'temp_archive_userid_' . $uid . '_' . $rand . '.zip', $path . $file );

            // Get base site package info
            $file = self::get_package($file_name);

			if(!isset($file['file']) || !self::zip_is_valid($file['file']))
			{
				throw new Exception( __( 'Invalid or unsupported zip format.', WPDB_TEXT ) );
			}

            return array(
                'url'   => site_url( 'index.php?wp-demo-builder-action=download&rand=' . $rand ),
                'size'  => $file['size'],
            );
        }

	/**
	 * Get embed code to render panel to build demo site.
	 *
	 * @param   array   $request  Authentication response from WP Demo Builder server.
	 *
	 * @return  void
	 */
	protected static function get_embed_code( $request ) {
		// Make sure embed code is changed
		$embed_code = get_option( 'wp_demo_builder_embed_code', null );
        $base_site_id = get_option('wp_demo_builder_base_site_id',null);
		if ( $embed_code == $request->response->data ) {
			$request->response->success = true;
		} else {
			// Save embed code to current user meta
			$request->response->success = update_option( 'wp_demo_builder_embed_code', $request->response->data );
		}

		// Update response
		if ( ! $request->response->success ) {
			$request->response->message = __( 'Cannot save embed code!', WPDB_TEXT );
		}

		// Store server URL to response
		$request->response->server = self::$server;

		return $request;
	}

	/**
	 * Load frontend assets for WP Demo Builder button.
	 *
	 * @return  void
	 */
	public static function frontend_assets() {
		// Get embed code
		$embed_code = get_option( 'wp_demo_builder_embed_code', null );

		if ( empty( $embed_code ) ) {
			return;
		}

		// Get saved settings
		$settings = get_option( 'wp_demo_builder_settings', self::$settings );

		if ( 0 === (int) $settings['enable_button'] ) {
			return;
		}

		wp_enqueue_style( 'wpdb-style', plugins_url( 'assets/css/wpdb-style.css', dirname( __FILE__ ) ) );
		wp_enqueue_style( 'wpdb-icon-moon', plugins_url( 'assets/3rd-party/font-icomoon/css/icomoon.css', dirname( __FILE__ ) ) );
	}

	/**
	 * Render WP Demo Builder button in frontend.
	 *
	 * @return  void
	 */
	public static function print_embed_code() {
		// Get global variables
		global $pagenow;

		// Hide demo builder registration form for if requested page is `wp-login.php` or the URL being accessed is in the admin section
		if ( 'wp-login.php' == $pagenow || is_admin() ) {
			return;
		}

		// Get embed code
		$embed_code = get_option( 'wp_demo_builder_embed_code', null );

		if ( empty( $embed_code ) ) {
			return;
		}

		// Get saved settings
		$settings = get_option( 'wp_demo_builder_settings', self::$settings );

		if ( 0 === (int) $settings['enable_button'] ) {
			return;
		}

		// Load button template
		include_once dirname( dirname( __FILE__ ) ) . '/templates/print-embed-code.php';
	}

	/**
	 * Get login form from WP Demo Builder server.
	 */
	protected static function login_form() {
		$result = wp_remote_get( self::$server . 'customer/login?ref=plugin', self::$remote_get_args );

		exit( $result['body'] );
	}

	/**
	 * Download base site package.
	 *
	 * @param   string  $file_name  Archive file name
	 *
	 * @return  void
	 */
	protected static function download_package( $file_name = null ) {
        @ini_set('memory_limit','-1');
		// Get base site package info
		$package = self::get_package($file_name);

		// Send necessary headers
		header( 'Content-Type: application/octet-stream'                                                 );
		header( 'Content-Length: ' . self::$fs->size( $package['file'] )                                 );
		header( 'Content-Disposition: attachment; filename=' . urlencode( basename( $package['file'] ) ) );
		header( 'Cache-Control: no-cache, must-revalidate, max-age=60'                                   );
		header( 'Expires: Sat, 01 Jan 2000 12:00:00 GMT'                                                 );

		// Send file content
		echo self::$fs->get_contents( $package['file'] );

		// Exit immediately to prevent WordPress from processing further
		exit;
	}

		/**
		 * Check zip file is valid
		 *
		 * @param $path
		 *
		 * @return bool
		 */
		static function zip_is_valid($path) {
			$zip = zip_open($path);
			if (is_resource($zip)) {
				// it's ok
				zip_close($zip); // always close handle if you were just checking
				return true;
			} else {
				return false;
			}
		}
        /**
         * Delete site package.
         *
         * @return  void
         */
        protected static function delete_package() {

		// Get random string
		$rand = isset( $_GET['rand'] ) ? $_GET['rand'] : null;

		if ( is_null( $rand ) ) {
			return null;
		}

		// Check if any site package exists
		$file_name = 'temp_archive_' . $rand;

		$path = wp_upload_dir();
		$file = glob( $path['basedir'] . '/site-package/' . $file_name . '.zip' );

		if ( ! $file || ! count( $file ) ) {
			return null;
		} else {
			// delete package
			$file = array_pop( $file );
			self::$fs->delete( $file );
		}

		return null;
	}

	/**
	 * Re-connect to get embed code
	 *
	 * @return  void
	 */
	protected static function re_connect() {
		// Get customer email, password and base_site_id to re-connect
		$email    		= isset( $_POST['email'] ) ? $_POST['email'] : null;
		$password 		= isset( $_POST['password'] ) ? $_POST['password'] : null;
		$base_site_id 	= isset( $_POST['base_site_id'] ) ? $_POST['base_site_id'] : null;

		if ( ! empty( $email ) && ! empty( $password ) && ! empty( $base_site_id ) ) {
			// Build query
			$query['body'] 			= array( 'email' => $email, 'password' => $password, 'base_site_id' => $base_site_id, 'remoteurl' => urlencode( site_url() ) );
			$query['method'] 		= 'POST';
			$query['timeout'] 		= self::$remote_get_args['timeout'];

			$result = wp_remote_post( self::$server . 'customer/client/get-embed-code', $query );

			if ( is_wp_error( $result ) ) {
				exit( '<div class="alert alert-danger">' . $result->get_error_message() . '</div>' );
			} else {
				// Parse server response
				$request = json_decode( $result['body'] );

				if ( ! $request ) {
					// Invalid server response
					exit( $result['body'] );
				} else {
					// Customer authentication fail
					if ( 'false' == $request->result ) {
						exit( '<div class="alert alert-danger">' . $request->message . '</div>' );
					} elseif ( 'true' == $request->result ) {
						// Save embed code to current user meta
						if ( ! update_option( 'wp_demo_builder_embed_code', $request->response ))
						{
							exit( '<div class="alert alert-danger">' . __( 'Cannot save embed code!', WPDB_TEXT ) . '</div>' );
						} else {
							exit( '<div class="alert alert-success">' . __( 'You have re-connected successfully', WPDB_TEXT ) . '</div>' );
						}
					}
				}
			}
		}

		// Exit immediately to prevent the plugin from generating and returning JSON status
		$return = array( 'result' => 'false', 'response' => '', 'message' => __( 'Invalid parameters.', WPDB_TEXT ) );
		exit( json_encode( $return ) );
	}

    /**
     * Get wpdemobuilder plugin version
     */
    static function get_wpdemobuilder_version() {
        $plugin_data = get_plugin_data( dirname( dirname( __FILE__ ) ). '/main.php' );
        $plugin_version = $plugin_data['Version'];
        return $plugin_version;
    }
}

endif;
