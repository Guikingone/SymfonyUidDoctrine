#!/bin/bash
#
# Install Composer, please refer to https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md
#

set -xe

###################################################################################################
# Allow to format the errors
# Arguments:
#   None
###################################################################################################
err() {
  echo "[$(date +'%Y-%m-%dT%H:%M:%S%z')]: $*" >&2
}

###################################################################################################
# Download, verify and install Composer
# Arguments:
#   None
###################################################################################################
function install_composer() {
  EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

  if [[ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]]; then
    err "ERROR: Invalid installer signature"
    exit 1
  fi

  php composer-setup.php --quiet --install-dir=/usr/local/bin --filename=composer
  rm composer-setup.php
}

###################################################################################################
# Launch the main script
###################################################################################################
install_composer
