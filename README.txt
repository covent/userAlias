userAlias README
==========================================

This package includes the userAlias plugin for Roundcube. This plugin allows roundcube login using an alias specified in a configuration file. For example mark.hoppus can login to Roundcube with its short alias mark.


Installation
------------


To install the plugin follow these steps:

1. Copy the userAlias folder to 'plugins' folder of your RC installation.

2. Enable the plugins 'userAlias' by editing the file 'config/config.inc.php' adding the following:
$config['plugins'] = array('userAlias’);

3. Register path to the file containing usernames/aliases table adding the following to config/config.inc.php file of your RC installation:

$config['userAliasConfigFile'] = ‘path-to-your-userAliases-file’;

4. Add entries to the userAliasConfigFile following the syntax username-SPACE-alias
i.e.

mark.hoppus mark
johndowsecond jds
sales.department@mycompany.com sales

and so on

