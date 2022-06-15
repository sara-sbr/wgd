<?php
/**
 * Plugin Name: Import Plugin
 * Description: Import Plugin - Wholegrain Digital Developer Test
 * Version: 0.1
 * Author: Wholegrain Digital
*/

namespace WGD;

class ImportPlugin
{
    public static function init(): void
    {
      // Call functions to register when plugin is initiated
      static::register();

      // Add menu page to run the CSV import manually
      //add_menu_page('Import Locations', 'Import Locations', 'edit_pages', plugins_url('import-plugin/pages/import-locations.php'), '',  'dashicons-tide', 30);

    }

    // A function to register the post type and taxonomy
    public static function register(): void
    {

      add_action('init', array(self::class, 'register_wgd_post_type'));
      add_action('init', array(self::class, 'register_wgd_taxonomy'));
      add_action('admin_menu', array(self::class, 'import_locations_menu'));

    }
    
    // A function to register the post type
    public static function register_wgd_post_type() {

      $single_name = 'Location';
      $multi_name = 'Locations';

      $labels = array(
        'name'                  => __($single_name),
        'singular_name'         => __($single_name),
        'menu_name'             => __($multi_name),
        'name_admin_bar'        => __($single_name),
        'add_new'               => __('Add New ' . $single_name),
        'add_new_item'          => __('Add New ' . $single_name),
        'new_item'              => __('New ' . $single_name),
        'edit_item'             => __('Edit ' . $single_name),
        'view_item'             => __('View ' . $single_name),
        'all_items'             => __('All ' . $multi_name),
        'search_items'          => __('Search ' . $multi_name),
        'parent_item_colon'     => __('Parent ' . $multi_name . ':'),
        'not_found'             => __('No ' . $multi_name . ' found.'),
        'not_found_in_trash'    => __('No ' . $multi_name . ' found in Trash.'),
      );

      $args = array(
          'labels'             => $labels,
          'public'             => true,
          'publicly_queryable' => true,
          'show_ui'            => true,
          'show_in_menu'       => true,
          'query_var'          => true,
          'slug'               => 'locations',
          'rewrite'            => array( 'slug' => 'locations' ),
          'capability_type'    => 'post',
          'has_archive'        => true,
          'hierarchical'       => false,
          'menu_position'      => null,
          'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
          'show_in_rest'       => true, /* enable gutenberg */
      );

      register_post_type( 'wgd-locations', $args );
    }


    // A function to register the taxonomy
    public static function register_wgd_taxonomy() {

      $single_name_tax = 'Category';
      $multi_name_tax = 'Categories';

      $labels = array(
        'name'              => __($multi_name_tax),
        'singular_name'     => __($single_name_tax),
        'search_items'      => __('Search ' . $multi_name_tax),
        'all_items'         => __('All ' . $multi_name_tax),
        'parent_item'       => __('Parent ' . $single_name_tax),
        'parent_item_colon' => __('Parent ' . $single_name_tax . ':'),
        'edit_item'         => __('Edit ' . $single_name_tax),
        'update_item'       => __('Update ' . $single_name_tax),
        'add_new_item'      => __('Add New ' . $single_name_tax),
        'new_item_name'     => __('New ' . $single_name_tax . ' Name'),
        'menu_name'         => __($single_name_tax),
      );

      $args = array(
          'hierarchical'      => true,
          'labels'            => $labels,
          'show_ui'           => true,
          'show_admin_column' => true,
          'query_var'         => false, // hide from public
          'public'            => false, // hide from public
          'rewrite'           => false, // hide from public
      );

      register_taxonomy( 'wgd-category', array( 'wgd-locations' ), $args );
    }

    public static function import_locations_menu() {
      add_menu_page(
        __('Import Locations'),
        __('Import Locations'),
        'manage_options',
        'import-locations',
        array(self::class, 'import_locations_contents'),
        'dashicons-schedule',
        30
        );
      }
      
    public static function import_locations_contents() {
      
      require_once('pages/import-locations.php');

    }

}

\WGD\ImportPlugin::init();
