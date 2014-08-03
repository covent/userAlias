<?php

/**
 * File based Alias to Username
 *
 * Add it to the plugins list in config.inc.php
 * Define path to the userAliasConfigFile inside config.inc.php
 * $rcmail['userAliasConfigFile'] = 'yourPathHere';
 *
 * @version @package_version@
 * @license GNU GPLv3+
 * @author Alex Lussana - Covent
 */

class userAlias extends rcube_plugin
{
    private $file;
    private $app;

    function init()
    {
        $this->app = rcmail::get_instance();
        $this->ConfigFile = $this->app->config->get('userAliasConfigFile');

        if ($this->ConfigFile) 
		{
			$this->add_hook('authenticate', array($this, 'aliasConverter'));
        }
    }

    /**
     * Searches in each line of ConfigFile for an USERNAME according to the following scheme:
		* username (-SPACE-) alias
		*i.e. Mark.Hoppus mark
		*whenever the user tries to login with its alias mark, this plugin replaces automatically mark with its full username Mark.Hoppus
	* Splits each line on space and if in position 0 the alias provided as input is found, there it returns its corresponding username in pos 1
     * @param string alias2Search is the ALIAS to search for
     * @return String corresponding to the USERNAME, empty string if no line contains the username
     */
    private function aliasSearch($alias2Search)
    {
		$searchingFile = null;
        if ($this->ConfigFile)
		{
            $searchingFile = file($this->ConfigFile);
		}
        if (empty($searchingFile))
		{
            return "";
		}
		
        // check each line for matches

        foreach ($searchingFile as $aliasLine) 
		{
            $aliasArray = preg_split('/ /', trim($aliasLine));
			if (trim($aliasArray[1]) == trim($alias2Search))
			{
			//BINGO!
				return trim($aliasArray[0]);
			}
        }
		//after foreach no lines found, return empty string
        return "";
    }


    /**
     * Searches for the username inside file, if found it replaces it with corresponding alias..
     */
	function aliasConverter($p)
    {
		$alias2Replace = $p['user'];
		$userNameFound = $this->aliasSearch($alias2Replace);
		// if empty string from aliasSearch, no alias present
		if($userNameFound <> "")
		{
			$p['user'] = $userNameFound;
		}
	    return $p;
    }


}
