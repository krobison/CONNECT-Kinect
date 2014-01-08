#!/bin/bash

# Write permissions for laravel to save data (logging,sessions)
chmod o+w -R app/storage

# Write permissions for HTML purifyer
chmod o+w app/purify/HTMLPurifier/DefinitionCache/Serializer

# Write permissions to upload cs prject files
chmod o+w assets/csproject_files

# Write permissions to save profile pictures
chmod o+w assets/img/profile_images

echo "Permissions have been changed"
echo "If you recieved permissions errors, you may have to give yourself write permissions on the failed files"
