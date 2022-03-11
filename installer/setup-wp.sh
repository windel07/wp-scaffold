#!/bin/bash

# Download wordpress core
wp core download 

# Create database
if ! wp db create; then
    echo "Failed to create database."
fi

# Install the application
wp core install --url=http://localhost:8000 --title=Test 

# Install themes
./setup-themes.sh

# Setup plugins
./setup-plugins.sh

# Run the server
wp server --host=localhost --port=8000 