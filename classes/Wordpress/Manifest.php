<?php

namespace Strawberrysoup\Wordpress;

define('THEME_FOLDER_URI', get_template_directory_uri());
define('THEME_FOLDER_DIR', get_template_directory());
define('PUBLIC_FOLDER', THEME_FOLDER_DIR . '/public');
define('LOCAL_CACHE', THEME_FOLDER_DIR . '/cache');

/**
 * Class Manifest
 * @package Strawberrysoup\Wordpress
 */
class Manifest
{
    private static $manifest_files = [];

    public function __construct()
    {
        $this::loadManifest();

        if (!is_admin()) {
            add_action('init', [__CLASS__, 'preload']);
        }

        add_action('enqueue_block_editor_assets', [__CLASS__, 'blockEditorAssets']);
    }

    /**
     * Loads asset manifest file array into array property
     */
    public static function loadManifest()
    {
        $manifest_path = PUBLIC_FOLDER . '/dist/manifest.json';

        if (file_exists($manifest_path)) {
            self::$manifest_files = json_decode(file_get_contents($manifest_path), true);
        }
    }

    /**
     * Preload function to load main css & js files from asset manifest file
     */
    public static function preload()
    {
        if (!is_iterable(self::$manifest_files)) {
            return;
        }

        foreach (self::$manifest_files as $name => $file) {
            // Skip editor styles from preload
            if (strpos($name, 'editor') !== false || strpos($name, '.map') !== false) {
                continue;
            }

            $filename = get_template_directory_uri() . "/public/dist/$file";

            if (strpos($file, '.js')) {
                wp_enqueue_script($name, $filename, [], null, true);
                header("Link: <$filename>;as=script;rel=preload", false);
            }

            if (strpos($file, '.css')) {
                wp_enqueue_style($name, $filename);
                header("Link: <$filename>;as=style;rel=preload", false);
            }
        }
    }

    /**
     * This will add styles to the block editor in the WP Admin
     */
    public static function blockEditorAssets()
    {
        $editor_style_file = self::$manifest_files['editor.css'];
        $editor_script_file = self::$manifest_files['editor.js'];
        wp_enqueue_style('block-editor-styles', get_theme_file_uri() . "/public/dist/{$editor_style_file}", false, '1.0', 'all');
        wp_enqueue_script('block-editor-js', get_theme_file_uri() . "/public/dist/{$editor_script_file}");
    }
}
