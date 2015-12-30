<!DOCTYPE html>

<html>
    
    <?php
        include "augment_functions.php"; 
        include "general_functions.php";
        
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
        
        $augment_raw_data = get_augment_data($con);
        
        // $augment_raw_data[0] contains all augment names
        $search_result = binary_search($augment_raw_data[0], $_GET["search_term"]);
    ?>
	<head>
		<meta charset="ISO-8859-1">
		<title>
            <?php
                // Print out the current augment as the page title.
                if ($_SERVER["REQUEST_METHOD"] == "GET") 
                {
                    if(empty($_GET["search_term"]))
                    {
                        print "Augment Search";
                    }
                    else if(strcasecmp($augment_raw_data[0][$search_result], $_GET["search_term"]) != 0)
                    {
                        print "Augment Search";
                    }
                    else
                    {
                        print $augment_raw_data[0][$search_result];
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
					<center><h1>Xenoblade Chronicles X Augment Search</h1></center>
					<hr/>
					<p>
						
						<div class="box">
							<p>
								<center><h3>Augment Search</h3></center>
								
								Type in the augment you would like information for below. Type it exactly as you see it in-game (else it probably won't show up) unless otherwise noted; search is case insensitive. The results will show you everything you need to know about how to obtain the augment.
                                <br/><br/>
                                Notes: <br/>
                                <ul>
                                    <li>Miranium costs for I/V/X/XV/XX are 100/100/100/1500/2000, and unranked are just 100.</li>
                                    <li>Physical, accuracy, and resistance augments use "phys", "acc" and "res" in the augment names instead of the full length word. So, for "Physical Resistance Up XX" it would be "phys res up xx"</li>
                                    <li>You can search the entire database by typing a word in the search box.</li>
                                    <br/>
                                    <li><a href ="https://docs.google.com/spreadsheets/d/1g0YR4M8RAHiRhCbAvV4tjXXHLEhRMrARzZMYAUGmyZ4/pub#" target="_blank">Full spreadsheet that was used</a>, created by Gessenkou. I made many additions/corrections for this site's version, but there are still errors and missing entries in the database. If you encounter a material with an incorrect number next to it, please email me with the name of the augment, offending material, and correct value at birdonwheels5 4t gm41l d0t com.</li>
                                    <li>The strange enemy names are due to the fact that the entire database isn't translated yet. Also, some enemies are translated wrong (ie. "Canary Arenatect" which was supposed to be "Saffron Arenatect"). Help with these would be appreciated as well.</li>
                                    <li>This webpage was created by birdonwheels5.</li>
                                    <li><a href="https://github.com/birdonwheels5/xenoblade-x-site/" target="_blank">Source code</a></li>
                                </ul>
								<center><!-- Standard html form -->
								<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
								    Search: <input type="text" name="search_term" value="<?php //print $_GET["augment_searchterm"]; ?>" size="16">
								    
								    <center><input type="submit" name="submit" value="Submit"></center>
								</form>
								
							</p>
						</div>
                        
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET") 
                            {
                                if(empty($_GET["search_term"]))
                                {
                                    die();
                                }
                                
                                if(strcasecmp($augment_raw_data[0][$search_result], $_GET["search_term"]) != 0)
                                {
                                    print "<div class=\"box\">\n";
                                    print "The requested augment could not be found in the database. Please check again and try again. If that does not work, then try doing this if you haven't already: <br/><br/>" . 
                                            "Physical, accuracy, and resistance augments use \"<b>phys</b>\", \"<b>acc</b>\" and \"<b>res</b>\" in the augment names instead of the full length word. So, for \"Physical Resistance Up XX\" it would be \"phys res up xx\". <br/><br/>" . 
                                            "If that doesn't work, then the augment you requested may not be in the database.";
                                    print "<br/><br/>";
                                    
                                    // Explode the search term by spaces
                                    $exploded_search_term = explode(" ", $_GET["search_term"]);
                                    
                                    // Run a linear search with the first word of the search term
                                    $linear_results = linear_augment_search($augment_raw_data[0], $exploded_search_term[0]);
                                    $linear_results_count = count($linear_results);
                                    
                                    print "Did you mean...<br/>";
                                    
                                    print "<ul>";
                                    for($i = 0; $i < $linear_results_count; $i++)
                                    {
                                        // Replace spaces with +'s for url link
                                        print "<li><a href =\"augment_search.php?search_term=" . preg_replace('/\s+/', '+', $linear_results[$i]) . "\">" . $linear_results[$i] . "</a></li>";
                                    }
                                    print "</ul></div>";
                                    
                                    
                                    die();
                                }
                                
                                // Put all the augment's data in it's own array
                                $augment_data = array();
                                $augment_data[0] = $augment_raw_data[0][$search_result];
                                $augment_data[1] = $augment_raw_data[1][$search_result];
                                $augment_data[2] = $augment_raw_data[2][$search_result];
                                $augment_data[3] = $augment_raw_data[3][$search_result];
                                $augment_data[4] = $augment_raw_data[4][$search_result];
                                $augment_data[5] = $augment_raw_data[5][$search_result];
                                
                                // Search succeeded, time to get the rest of the data about the augment
                                $bestiary_data = get_bestiary_data($con, $augment_raw_data[2][$search_result], $augment_raw_data[3][$search_result], $augment_raw_data[4][$search_result]);
                                $frontiernav_data = get_frontiernav_data($con, $augment_data[5]);
                                
                                print 
                                "<div class=\"box\">
                                    <p>
                                        <center><h3>Results for " .  $augment_data[0] . "</h3></center>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Augment Name</b>
                                                <td/>
                                                <td>
                                                    <b>Effect</b>
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
                                                    <b>Precious Resource</b>
                                                <td/>
                                            </tr>
                                            
                                            <tr>
                                                <td>"
                                                    . $augment_data[0] . 
                                                "<td/>
                                                <td>"
                                                    . $augment_data[1] . 
                                                "<td/>
                                                <td>"
                                                    . $augment_data[2] . 
                                                "<td/>
                                                <td>"
                                                    . $augment_data[3] . 
                                                "<td/>
                                                <td>"
                                                    . $augment_data[4] . 
                                                "<td/>
                                                <td>"
                                                    . $augment_data[5] . 
                                                "<td/>
                                            </tr>
                                            
                                        </table>
                                        
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $augment_data[2])) . "</h2>
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
                                                    <b>Enemy Name: </b>
                                                <td/>
                                                <td>
                                                    <b>Genus: </b>
                                                <td/>
                                                <td>
                                                    <b>Type: </b>
                                                <td/>
                                                <td>
                                                    <b>Continent: </b>
                                                <td/>
                                                <td>
                                                    <b>Location: </b>
                                                <td/>
                                                <td>
                                                    <b>Level: </b>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table($bestiary_data, 0);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $augment_data[3])) . "</h2>
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
                                                    <b>Enemy Name: </b>
                                                <td/>
                                                <td>
                                                    <b>Genus: </b>
                                                <td/>
                                                <td>
                                                    <b>Type: </b>
                                                <td/>
                                                <td>
                                                    <b>Continent: </b>
                                                <td/>
                                                <td>
                                                    <b>Location: </b>
                                                <td/>
                                                <td>
                                                    <b>Level: </b>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table($bestiary_data, 1);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $augment_data[4])) . "</h2>
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
                                                    <b>Enemy Name: </b>
                                                <td/>
                                                <td>
                                                    <b>Genus: </b>
                                                <td/>
                                                <td>
                                                    <b>Type: </b>
                                                <td/>
                                                <td>
                                                    <b>Continent: </b>
                                                <td/>
                                                <td>
                                                    <b>Location: </b>
                                                <td/>
                                                <td>
                                                    <b>Level: </b>
                                                <td/>
                                            </tr>";
                                        print print_bestiary_table($bestiary_data, 2);
                                        print 
                                    "</p>
                                    
                                    <p>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $augment_data[5])) . "</h2>
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
