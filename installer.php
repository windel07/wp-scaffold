<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname( __FILE__ ));
$dotenv->load();

$isLocal = 1 == $_ENV['LOCAL'] ? true : false;

$dbName = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : null;
$dbUser = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : null;
$dbPass = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : null;
$dbHost = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null;

$siteURL = $isLocal ? "http://localhost:8080" : (isset($_ENV['SITE_URL']) ? $_ENV['SITE_URL'] : null);
$siteTitle = isset($_ENV['SITE_TITLE']) ? $_ENV['SITE_TITLE'] : null;

$parentTheme = isset($_ENV['PARENT_THEME']) ? $_ENV['PARENT_THEME'] : null;
$childTheme = isset($_ENV['CHILD_THEME']) ? $_ENV['CHILD_THEME'] : null;


# --- Check .env values --- #

if( !$siteURL && !$siteTitle ) :
    \cli\line("%RSite title and url cannot be empty.%n");
elseif( !$parentTheme && !$childTheme ) :
    \cli\line("%RParent and child theme cannot be empty.%n");
endif;


# --- Generate config --- #

$config = WP_CLI::runcommand("config create --dbname=$dbName --dbuser=$dbUser --dbpass=$dbPass --dbhost=$dbHost --force", [
    'return' => 'all',
    'exit_error' => false
]);

if( !$config->stderr ) :
    WP_CLI::runcommand("config shuffle-salts");

    # --- Create database --- #

    $db = WP_CLI::runcommand("db create", [
        'return' => 'all',
        'exit_error' => false
    ]);

    if( !$db->stderr ) :
        # --- Install WP core --- #
        
        $install = WP_CLI::runcommand("core install --url=$siteURL --title=\"$siteTitle\"", [
            'return' => 'all',
            'exit_error' => false
        ]);
        
        if( !$install->stderr ) :
            \cli\line("%G$install->stdout%n");

            # --- Setup plugins --- #

            WP_CLI::runcommand("plugin delete hello");
            WP_CLI::runcommand("plugin activate elementor");


            # --- Setup themes --- #
            
            WP_CLI::runcommand("theme delete --all --force");
            WP_CLI::runcommand("theme install $parentTheme --insecure --force");
            WP_CLI::runcommand("theme install $childTheme --insecure --force --activate");


            # --- Setup initial pages --- #

            $pages = WP_CLI::runcommand("post list --post_type=page --format=ids", [
                'return' => true,
            ]);

            WP_CLI::runcommand("post delete {$pages} --force");

            $front_page = WP_CLI::runcommand("post create --post_title=Home --post_type=page --post_author=1 --post_status=publish --porcelain", [
                'return' => true,
            ]);
            WP_CLI::runcommand("post create --post_title=About --post_type=page --post_author=1 --post_status=publish");
            WP_CLI::runcommand("post create --post_title=Contact --post_type=page --post_author=1 --post_status=publish"); 

            WP_CLI::runcommand("option update page_on_front $front_page");
            
            if( $isLocal ) :
                WP_CLI::runcommand("server");
            endif;
        else :
            \cli\line("%R$install->stderr%n");
        endif;
    else :
        \cli\line("%R$db->stderr%n");
    endif;
else :
    \cli\line("%R$config->stderr%n");
endif;