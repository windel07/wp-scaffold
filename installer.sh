#!/bin/bash

echo "While we wait.. Re-hydrate!"

# Download wordpress core ---

vendor/bin/wp core download 

# Create database ---

vendor/bin/wp db create

# Install the application ---

vendor/bin/wp core install --url=http://localhost:8000 --title=Test 

# Setup themes ---

# Delete initial themes
vendor/bin/wp theme delete --all --force

# Install themes
for theme in $(cat utils/themes.txt); do
    name=${theme//"https://github.com/Idea-Maker-Agency/"/""}
    name=${name//"/archive/refs/heads/dev.zip"/""}
    
    wget $theme -O "$name.zip" -q

    vendor/bin/wp theme install "$name.zip" --activate

    mv "project/wp-content/themes/$name-dev" "project/wp-content/themes/$name"
    rm "$name.zip"
done

vendor/bin/wp theme activate genesis-child
vendor/bin/wp theme update genesis

# Setup plugins ---

# Delete initial plugins
vendor/bin/wp plugin delete $(vendor/bin/wp plugin list --field=name)

# Install plugins
for plugin in $(cat utils/plugins.txt); do
    vendor/bin/wp plugin install $plugin --activate
done

# Delete initial pages
vendor/bin/wp post delete $(wp post list --post_type='page' --format=ids)

# Create pages
for page in $(cat utils/pages.txt); do
    vendor/bin/wp post create --post_title=$page --post_type=page --post_status=publish
done

# Set homepage
vendor/bin/wp option update page_on_front 7

# Run the server ---

vendor/bin/wp server --host=localhost --port=8000 