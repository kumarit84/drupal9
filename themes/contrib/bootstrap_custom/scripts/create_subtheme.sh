#!/bin/bash
# Script to quickly create sub-theme.

echo '
+------------------------------------------------------------------------+
| With this script you could quickly create bootstrap_custom sub-theme     |
| In order to use this:                                                  |
| - bootstrap_custom theme (this folder) should be in the contrib folder   |
+------------------------------------------------------------------------+
'
echo 'The machine name of your custom theme? [e.g. mycustom_bootstrap_custom]'
read CUSTOM_bootstrap_custom

echo 'Your theme name ? [e.g. My custom bootstrap_custom]'
read CUSTOM_bootstrap_custom_NAME

if [[ ! -e ../../custom ]]; then
    mkdir ../../custom
fi
cd ../../custom
cp -r ../contrib/bootstrap_custom $CUSTOM_bootstrap_custom
cd $CUSTOM_bootstrap_custom
for file in *bootstrap_custom.*; do mv $file ${file//bootstrap_custom/$CUSTOM_bootstrap_custom}; done
for file in config/*/*bootstrap_custom.*; do mv $file ${file//bootstrap_custom/$CUSTOM_bootstrap_custom}; done

# Remove create_subtheme.sh file, we do not need it in customized subtheme.
rm scripts/create_subtheme.sh

# mv {_,}$CUSTOM_bootstrap_custom.theme
grep -Rl bootstrap_custom .|xargs sed -i -e "s/bootstrap_custom/$CUSTOM_bootstrap_custom/"
sed -i -e "s/SASS Bootstrap Starter Kit Subtheme/$CUSTOM_bootstrap_custom_NAME/" $CUSTOM_bootstrap_custom.info.yml
echo "# Check the themes/custom folder for your new sub-theme."