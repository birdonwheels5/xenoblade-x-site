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
        
        $ground_gear_raw_data = get_ground_gear_data($con);
        
        // $ground_gear_raw_data[0] contains all augment names
        $search_result = binary_search($ground_gear_raw_data[0], $_GET["gear"]);
    ?>
	<head>
		<meta charset="ISO-8859-1">
		<title>
            <?php
                // Print out the current augment as the page title.
                if ($_SERVER["REQUEST_METHOD"] == "GET") 
                {
                    if(empty($_GET["gear"]))
                    {
                        print "Ground Armor List";
                    }
                    else if(strcasecmp($ground_gear_raw_data[0][$search_result], $_GET["gear"]) != 0)
                    {
                        print "Ground Armor List ";
                    }
                    else
                    {
                        print $ground_gear_raw_data[0][$search_result];
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
					<center><h1>Xenoblade Chronicles X Craftable Ground Armor</h1></center>
					<hr/>
					<p>
						
						<div class="box">
							<p>
								<center><h3>Craftable Ground Armor</h3></center>
								
								Click on the piece of ground gear you would like to find more details for.
                                <br/><br/>
                                Notes: <br/>
                                <ul>
                                    <li>Miranium costs for all pieces are 1000, except Bunnybod and Bunnycuffs which are 7777.</li>
                                    <li>I may add craftable weapons to this list in the future, if someone can convince me that they aren't all useless...</li>
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
                                if(empty($_GET["gear"]))
                                {
                                    // Temporary solution for the quick index.
                                    // When the database is finished, this will be retrieved from a static file or something
                                    
                                    print "<div class=\"box\">\n";
                                    print "
                                    <center><h3>Ground Gear Index</h3>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Gear Name</b>
                                                <td/>
                                                <td>
                                                    <b>Gear Slot</b>
                                                <td/>
                                                <td>
                                                    <b>Maker</b>
                                                <td/>
                                                <td>
                                                    <b>Level</b>
                                                <td/>
                                                <td>
                                                    <b>Defense</b>
                                                <td/>
                                                <td>
                                                    <b>Battle Traits</b>
                                                <td/>
                                            </tr>";
                                    print print_ground_gear($ground_gear_raw_data);
                                    print "</center></div>\n";
                                    
                                    die();
                                }
                                
                                if(strcasecmp($ground_gear_raw_data[0][$search_result], $_GET["gear"]) != 0)
                                {
                                    print "<div class=\"box\">";
                                    print "The requested augment could not be found in the database. Please check the name and try again. <br/><br/>";
                                    
                                    
                                    // Explode the search term by spaces
                                    $exploded_gear = explode(" ", $_GET["gear"]);
                                    
                                    // Run a linear search with the first word of the search term
                                    $linear_results = linear_augment_search($ground_gear_raw_data, $exploded_gear[0]);
                                    $linear_results_count = count($linear_results);
                                    
                                    if($linear_results_count != 0)
                                    {
                                        print "<br/><br/>";
                                        
                                        print "Did you mean...<br/><br/>";
                                        
                                        print "<ul>";
                                        for($i = 0; $i < $linear_results_count; $i++)
                                        {
                                            // Replace spaces with +'s for url link
                                            print "<li><a href =\"ground_gear_list.php?gear=" . preg_replace('/\s+/', '+', $linear_results[$i]) . "\">" . $linear_results[$i] . "</a></li>";
                                        }
                                        print "</ul></div>";
                                    }
                                    
                                    
                                    die();
                                }
                                
                                // Put all the gear's data in its own array
                                $ground_gear_data = array();
                                $ground_gear_data[0] = $ground_gear_raw_data[0][$search_result];
                                $ground_gear_data[1] = $ground_gear_raw_data[1][$search_result];
                                $ground_gear_data[2] = $ground_gear_raw_data[2][$search_result];
                                $ground_gear_data[3] = $ground_gear_raw_data[3][$search_result];
                                $ground_gear_data[4] = $ground_gear_raw_data[4][$search_result];
                                $ground_gear_data[5] = $ground_gear_raw_data[5][$search_result];
                                $ground_gear_data[6] = $ground_gear_raw_data[6][$search_result];
                                $ground_gear_data[7] = $ground_gear_raw_data[7][$search_result];
                                $ground_gear_data[8] = $ground_gear_raw_data[8][$search_result];
                                $ground_gear_data[9] = $ground_gear_raw_data[9][$search_result];
                                $ground_gear_data[10] = $ground_gear_raw_data[10][$search_result];
                                $ground_gear_data[11] = $ground_gear_raw_data[11][$search_result];
                                $ground_gear_data[12] = $ground_gear_raw_data[12][$search_result];
                                $ground_gear_data[13] = $ground_gear_raw_data[13][$search_result];
                                $ground_gear_data[14] = $ground_gear_raw_data[14][$search_result];
                                
                                // Search succeeded, time to get the rest of the data about the augment
                                $bestiary_data = get_gear_bestiary_data($con, $ground_gear_raw_data[8][$search_result], $ground_gear_raw_data[9][$search_result], 
                                                                              $ground_gear_raw_data[10][$search_result], $ground_gear_raw_data[11][$search_result], 
                                                                              $ground_gear_raw_data[12][$search_result], $ground_gear_raw_data[13][$search_result]);
                                $frontiernav_data = get_frontiernav_data($con, $ground_gear_data[14]);
                                
                                print 
                                "<div class=\"box\">
                                    <p>
                                        <center><h3>Results for " .  $ground_gear_data[0] . "</h3></center>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Gear Name</b>
                                                <td/>
                                                <td>
                                                    <b>Gear Slot</b>
                                                <td/>
                                                <td>
                                                    <b>Maker</b>
                                                <td/>
                                                <td>
                                                    <b>Level</b>
                                                <td/>
                                                <td>
                                                    <b>Defense</b>
                                                <td/>
                                                <td>
                                                    <b>Battle Traits</b>
                                                <td/>
                                                <td>
                                                    <b>Upgrades</b>
                                                <td/>
                                                <td>
                                                    <b>Resistances</b>
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
                                                    <b>Material 5</b>
                                                <td/>
                                                <td>
                                                    <b>Material 6</b>
                                                <td/>
                                                <td>
                                                    <b>Material 7</b>
                                                <td/>
                                            </tr>";
                                        print print_ground_gear_result($ground_gear_data);
                                        print "
                                        </table>
                                        
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[8])) . "</h2>
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
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[9])) . "</h2>
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
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[10])) . "</h2>
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
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[11])) . "</h2>
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
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[12])) . "</h2>
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
                                        print print_bestiary_table($bestiary_data, 4);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[13])) . "</h2>
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
                                        print print_bestiary_table($bestiary_data, 5);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $ground_gear_data[14])) . "</h2>
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
