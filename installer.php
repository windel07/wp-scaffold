<?php

$dotenv = Dotenv\Dotenv::createImmutable(dirname( __FILE__ ));
$dotenv->load();

$isLocal = 1 == $_ENV['LOCAL'] ? true : false;

$dbName = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : null;
$dbUser = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : null;
$dbPass = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : null;
$dbHost = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : null;

$siteURL = $isLocal ? "http://localhost:8080" : (isset($_ENV['SITE_URL']) ? $_ENV['SITE_URL'] : null);
$siteTitle = isset($_ENV['SITE_TITLE']) ? $_ENV['SITE_TITLE'] : null;

# Check database configuration
if( !$dbName || !$dbUser || !$dbHost) :
    shell_exec("echo \"Invalid database configuration\"");
    shell_exec("read");
# Check site url and title
elseif( !$siteURL || !$siteTitle ) :
    shell_exec("echo \"Site url or title cannot be empty\"");
    shell_exec("read");
endif;

$commands = [
    "wp config create --dbname=$dbName --dbuser=$dbUser --dbpass=$dbPass --dbhost=$dbHost",
    "wp config shuffle-salts",
    "wp db create",
    "wp core install --url=$siteURL --title=$siteTitle",
    "wp plugin delete hello",
    "wp plugin activate elementor",
    "wp theme delete --all --force",
    "wp theme install https://github.com/Idea-Maker-Agency/genesis/archive/refs/heads/dev.zip --insecure",
    "wp theme install https://github.com/Idea-Maker-Agency/genesis-child/archive/refs/heads/dev.zip --activate --insecure",
];

if( $isLocal ) 
    $commands[] = "wp server";

# Run commands
foreach( $commands as $command ) :
    echo shell_exec($command);
endforeach;