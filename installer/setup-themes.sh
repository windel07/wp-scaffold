#!/bin/bash

wp theme delete --all --force
wp theme install https://github.com/Idea-Maker-Agency/wordpress/raw/dev/genesis.zip
wp theme install https://github.com/Idea-Maker-Agency/wordpress/raw/dev/genesis-child.zip --activate
wp theme update genesis