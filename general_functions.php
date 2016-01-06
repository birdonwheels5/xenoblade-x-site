<?php

    function binary_search($sorted_array, $search_term)
    {
        $left = 0;
        $right = count($sorted_array);
        
        // Usual case, use binary search for improved search speed (since the list is already ordered)
        while($left <= $right)
        {
            $midpoint = floor($left + (($right - $left) / 2));
            
            if(strcasecmp($sorted_array[$midpoint], $search_term) == 0)
            {
                // Player found, return their position in the API object
                return $midpoint;
            }
            // Use the player's names to compare them (these are in alphabetical order)
            else if(strcasecmp($sorted_array[$midpoint], $search_term) < 0) 
            {
                $left = $midpoint + 1;
            }
            else
            {
                $right = $midpoint - 1;
            }
        }
    }
        
    // Returns an array of all settings from the config file
    // Additional config options can be added as functionality expands.
    function load_config()
    {
        $filename = "/var/xenoblade/config.txt";
        $mysql_user = "";
        $mysql_host = "";
        $mysql_pass = "";
        $mysql_database = "";
    
        $settings = array();
        
        if(fopen($filename, "r") == false)
        {
            $log_message = "CRITICAL: Unable to load config file! Webpages will not load at all without it.";
            log_to_file($log_message);
        }
        $handle = fopen($filename, "r") or die ("Error loading config file! Please contact a system administrator to get this fixed! Webservices are non-functional without it.");
        while (($line = fgets($handle)) !== false)
        {
            // Fetch config information line-by-line
            if (strcmp(stristr($line, "mysql_user:"), $line) == 0)
            {
                $mysql_user = trim(str_ireplace("mysql_user:", "", $line));
            }
            if (strcmp(stristr($line, "mysql_host:"), $line) == 0)
            {
                $mysql_host = trim(str_ireplace("mysql_host:", "", $line));
            }
            if (strcmp(stristr($line, "mysql_pass:"), $line) == 0)
            {
                $mysql_pass = trim(str_ireplace("mysql_pass:", "", $line));
            }
            if (strcmp(stristr($line, "mysql_database:"), $line) == 0)
            {
                $mysql_database = trim(str_ireplace("mysql_database:", "", $line));
            }
            
        }
        
        fclose($handle);
        
        
        $settings[0] = $mysql_user;
        $settings[1] = $mysql_host;
        $settings[2] = $mysql_pass;
        $settings[3] = $mysql_database;
        
        // Check to see if any of the settings are empty. If they are, 
        // that means that there is a typo in one of the settings
        // ie "myr_rpc_uer: " instead of "myr_rpc_user: "
        for($i = 0; $i < count($settings); $i++)
        {
            if(empty($settings[$i]))
            {
                $log_message = "CRITICAL: Unable to load config file due to a damaged setting! Please go through the config file to correct the error. Webpages will not load at all without the config file.";
                log_to_file($log_message);
                
                die ("Error loading config file! Please contact a system administrator to get this fixed! Webservices are non-functional without it.");
            }
        }
        
        return $settings;
    }
    
    // Logs a given message to the log file.
    function log_to_file($log_message)
    {
        $log_filename = "/var/xenoblade/log.txt";
        
        // Append the date and time of message to the beginning of the message
        $text = date("Y-m-d H:i:s") . ": " . $log_message . PHP_EOL;
        file_put_contents($log_filename, $text, FILE_APPEND) or print "Error loading logs file! Please contact a system administrator.";
    }
    
    // Prints out html for the header buttons. Another function will handle printing all the buttons.
    function print_header_button($url, $description)
    {
        print "
        <div class=\"button\">\n
            <p><a href =\"" . $url . "\">" . $description . "</a></p>\n
        </div>\n";
    }
    
    function print_header_logo()
    {
        print "
        <div class=\"logoContainer\">\n
            <img src=\"img/logo.png\" style=\"width:150%;height:75%;\">\n
        </div>\n";
    }
    
    function print_header()
    {
        print_header_logo();
        print_header_button("index.php", "Home");
        print_header_button("augment_search.php", "Augment Search");
        print_header_button("material_search.php", "Material Search");
        print_header_button("ground_gear_list.php", "Ground Gear List");
        print_header_button("superweapon_list.php", "Skell Superweapon List");
    }

?>
