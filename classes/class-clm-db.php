<?php
/**
 * 
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* 
*/
interface i_sitDB {
    function __construct();
    function install_sit_tbl();
    function install_sit_meta_tbl();
}

/**
* 
*/
//class sit_DB implements i_sit_DB {
class sitDB {
    /**
     * Holds the values to be used in the fields callbacks
     */
    public $wpdb;
    public $index;
    public $sit_settings;
    public $db, $tbl_name, $wp_tbl;
        
    /**
    * 
    */
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        
        add_action( 'admin_init', array( $this, 'install_sit_tbl' ) );
        add_action( 'admin_init', array( $this, 'install_sit_meta_tbl' ) );
    }

    /**
    *
    */
    public function install_sit_tbl() {

        global $wpdb;
        $this->db = $wpdb;
        $this->tbl_name = $this->db->prefix . 'sit';
        $charset_collate = $this->db->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->tbl_name} (
          id INT(200) NOT NULL AUTO_INCREMENT,
          post_id INT(200),
          primary_time DATETIME,
          is_active VARCHAR(5) DEFAULT 'off',
          UNIQUE KEY id (id) ); ";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    /**
    *
    */
    public function install_sit_meta_tbl() {

        global $wpdb;
        $this->db = $wpdb;
        $this->tbl_name = $this->db->prefix . 'sit_meta';
        $charset_collate = $this->db->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->tbl_name} (
          id INT(200) NOT NULL AUTO_INCREMENT,
          sit_id INT(200),
          primary_time DATETIME,
          is_active VARCHAR(5) DEFAULT 'off',
          UNIQUE KEY id (id) ); ";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

}

$sit_db = new sitDB();


