#!/bin/bash

# Delete initial plugins
wp plugin delete $(wp plugin list --field=name)

# Install plugins
wp plugin install $("classic-editor" "elementor")