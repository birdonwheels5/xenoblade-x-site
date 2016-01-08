<!DOCTYPE html>

<html>
    
    <?php
        include "augment_functions.php";
        include "material_functions.php";
        include "general_functions.php";
        include "crafting_functions.php";
        
        // Load database settings from config file
        $settings = array();
        $settings = load_config();
        
        $mysql_user = $settings[0];
        $mysql_host = $settings[1];
        $mysql_pass = $settings[2];
        $mysql_database = $settings[3];
        
        // Establish connection to the database
        $con = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_database);
        
        if (mysqli_connect_errno()) 
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            $log_message = "CRITICAL: Failed to connect to database while attempting to update the database tables! Please check your database and database settings!";
            log_to_file($log_message);
        }
        
        mysqli_query($con, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
        
        $superweapons_raw_data = get_superweapons_data($con);
        
        // $superweapons_raw_data[0] contains all augment names
        $search_result = binary_search($superweapons_raw_data[0], $_GET["superweapon"]);
    ?>
	<head>
		<meta charset="ISO-8859-1">
		<title>
            <?php
                // Print out the current augment as the page title.
                if ($_SERVER["REQUEST_METHOD"] == "GET") 
                {
                    if(empty($_GET["superweapon"]))
                    {
                        print "Skell Superweapon List";
                    }
                    else if(strcasecmp($superweapons_raw_data[0][$search_result], $_GET["superweapon"]) != 0)
                    {
                        print "Skell Superweapon List ";
                    }
                    else
                    {
                        print $superweapons_raw_data[0][$search_result];
                    }
                }
            ?>
        </title>
		<link rel="stylesheet" type="text/css" href="styles.css" title="Default Styles" media="screen"/>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" title="Font Styles"/>
        
	</head>
	
	<body link="#E2E2E2" vlink="#ADABAB">
		<center><div class="container">
	
		
			<header>
		
				<?php print_header(); ?>
				
			</header>
			
			<article style="color:#FFFFFF;">
				<p>
					<!-- <center><img src="logo_big.png"></center> Insert Main Logo here -->
					
					<hr/>
					<center><h1>Xenoblade Chronicles X Craftable Superweapons</h1></center>
					<hr/>
					<p>
						
						<div class="box">
							<p>
								<center><h3>Craftable Superweapons</h3></center>
								
								Click on the superweapon you would like to find more details for.
                                <br/><br/>
                                Notes: <br/>
                                <ul>
                                    <li>Miranium costs for all superweapons are: lv 30: 10000, lv 50: 20000, lv 60: 30000.</li>
                                    <br/>
                                    <li><a href ="https://docs.google.com/spreadsheets/d/1g0YR4M8RAHiRhCbAvV4tjXXHLEhRMrARzZMYAUGmyZ4/pub#" target="_blank">Full spreadsheet that was used</a>, created by Gessenkou. I made many additions/corrections for this site's version, but there are still errors and missing entries in the database. If you encounter an enemy with a jumbled name, please email me with the name of the armor, material the enemy drops, and the name of the enemy (if you can find it) at birdonwheels5 4t gm41l d0t com.</li>
                                    <li>This webpage was created by birdonwheels5.</li>
                                    <li><a href="https://github.com/birdonwheels5/xenoblade-x-site/" target="_blank">Source code</a></li>
                                </ul>
								
							</p>
						</div>
                        
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET") 
                            {
                                if(empty($_GET["superweapon"]))
                                {
                                    
                                    print "<div class=\"box\">\n";
                                    print "
                                    <center><h3>Skell Superweapon Index</h3>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Weapon Name</b>
                                                <td/>
                                                <td>
                                                    <b>Slot</b>
                                                <td/>
                                                <td>
                                                    <b>Lv</b>
                                                <td/>
                                                <td>
                                                    <b>Force</b>
                                                <td/>
                                                <td>
                                                    <b>Attribute</b>
                                                <td/>
                                                <td>
                                                    <b>Battle Traits</b>
                                                <td/>
                                            </tr>";
                                    print print_superweapons($superweapons_raw_data);
                                    print "</center></div>\n";
                                    
                                    die();
                                }
                                
                                if(strcasecmp($superweapons_raw_data[0][$search_result], $_GET["superweapon"]) != 0)
                                {
                                    print "<div class=\"box\">";
                                    print "The requested superweapon could not be found in the database. <br/><br/>";
                                    // Explode the search term by spaces
                                    $exploded_superweapons = explode(" ", $_GET["superweapon"]);
                                    
                                    // Run a linear search with the first word of the search term
                                    $linear_results = linear_augment_search($superweapons_raw_data, $exploded_superweapons[0]);
                                    $linear_results_count = count($linear_results);
                                    
                                    if($linear_results_count != 0)
                                    {
                                        print "<br/><br/>";
                                        
                                        print "Did you mean...<br/><br/>";
                                        
                                        print "<ul>";
                                        for($i = 0; $i < $linear_results_count; $i++)
                                        {
                                            // Replace spaces with +'s for url link
                                            print "<li><a href =\"superweapon_list.php?superweapon=" . preg_replace('/\s+/', '+', $linear_results[$i]) . "\">" . $linear_results[$i] . "</a></li>";
                                        }
                                        print "</ul></div>";
                                    }
                                    
                                    die();
                                }
                                
                                // Put all the gear's data in its own array
                                $superweapons_data = array();
                                for($i = 0; $i < 14; $i++) // We have 14 rows
                                {
                                    $superweapons_data[$i] = $superweapons_raw_data[$i][$search_result];
                                }
                                
                                // Search succeeded, time to get the rest of the data about the augment
                                $bestiary_data = get_superweapon_bestiary_data($con, $superweapons_raw_data[9][$search_result], $superweapons_raw_data[10][$search_result], 
                                                                              $superweapons_raw_data[11][$search_result], $superweapons_raw_data[12][$search_result]);
                                $frontiernav_data = get_frontiernav_data($con, $superweapons_data[13]);
                                
                                print 
                                "<div class=\"box\">
                                    <p>
                                        <center><h3>Results for " .  $superweapons_data[0] . "</h3></center>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Weapon Name</b>
                                                <td/>
                                                <td>
                                                    <b>Slot</b>
                                                <td/>
                                                <td>
                                                    <b>Lv</b>
                                                <td/>
                                                <td>
                                                    <b>Force</b>
                                                <td/>
                                                <td>
                                                    <b>Ammo</b>
                                                <td/>
                                                <td>
                                                    <b>Hits</b>
                                                <td/>
                                                <td>
                                                    <b>Fuel</b>
                                                <td/>
                                                <td>
                                                    <b>Attribute</b>
                                                <td/>
                                                <td>
                                                    <b>Battle Traits</b>
                                                <td/>
                                                <td>
                                                    <b>Material 1</b>
                                                <td/>
                                                <td>
                                                    <b>Material 2</b>
                                                <td/>
                                                <td>
                                                    <b>Material 3</b>
                                                <td/>
                                                <td>
                                                    <b>Material 4</b>
                                                <td/>
                                                <td>
                                                    <b>Rare Resource</b>
                                                <td/>
                                            </tr>";
                                        print print_superweapons_result($superweapons_data);
                                        print "
                                        </table>
                                        
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $superweapons_data[9]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $superweapons_data[9])) . "</a></h2>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table_head();
                                        print print_bestiary_table($bestiary_data, 0);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $superweapons_data[10]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $superweapons_data[10])) . "</a></h2>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table_head();
                                        print print_bestiary_table($bestiary_data, 1);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $superweapons_data[11]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $superweapons_data[11])) . "</a></h2>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table_head();
                                        print print_bestiary_table($bestiary_data, 2);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $superweapons_data[12]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $superweapons_data[12])) . "</a></h2>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table_head();
                                        print print_bestiary_table($bestiary_data, 3);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $superweapons_data[13])) . "</h2>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                                <td>
                                                    <p></p>
                                                <td/>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>FN Site: </b>
                                                <td/>
                                                <td>
                                                    <b>Mining: </b>
                                                <td/>
                                                <td>
                                                    <b>Research: </b>
                                                <td/>
                                                <td>
                                                    <b>Battle: </b>
                                                <td/>
                                                <td>
                                                    <b>Tourist Spots: </b>
                                                <td/>
                                                <td>
                                                    <b>Rare Resources: </b>
                                                <td/>
                                                <td>
                                                    <b>Connections: </b>
                                                <td/>
                                            </tr>";
                                        print print_frontiernav_table($frontiernav_data);
                                        print "</table>";
                            }
                            ?>
                                
                            </p>
                        </div>

                    </p>

                </p>
			
			
			</article>
			
			<div class="paddingBottom">
			</div>
			
			<div id="counter">
                            <img src="http://simplehitcounter.com/hit.php?uid=1998481&f=16777215&b=0" border="0" height="0" width="0" alt="web counter"></a>
                        </div>			

			
			<!-- <footer>
				2016 birdonwheels5.
			</footer> -->
		</div>
	</body>
	
</html>
