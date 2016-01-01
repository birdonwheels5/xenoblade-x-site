<!DOCTYPE html>

<html>
    
    <?php
        include "augment_functions.php"; 
        include "general_functions.php";
        include "material_functions.php";
        
        $material_name = "";
        
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
        $bestiary_raw_data = get_raw_bestiary_data($con);
        
        // $augment_raw_data[2,3,4] contains materials
        $augment_search_result = linear_material_augment_search($augment_raw_data, $_GET["search_term"]);
        
        // Bestiary search result
        $search_result = linear_material_bestiary_search($bestiary_raw_data, $_GET["search_term"]);
    ?>
	<head>
		<meta charset="ISO-8859-1">
		<title>
            <?php
                // Print out the searched material as the page title.
                if ($_SERVER["REQUEST_METHOD"] == "GET") 
                {
                    if(empty($_GET["search_term"]))
                    {
                        print "Material Search";
                    }
                    else if(stristr($search_result[6][0], $_GET["search_term"]) == false and stristr($search_result[7][0], $_GET["search_term"]) == false and
                            stristr($search_result[8][0], $_GET["search_term"]) == false and stristr($search_result[9][0], $_GET["search_term"]) == false and
                            stristr($search_result[10][0], $_GET["search_term"]) == false and stristr($search_result[11][0], $_GET["search_term"]) == false and
                            stristr($search_result[12][0], $_GET["search_term"]) == false)
                    {
                        print "Material Search";
                    }
                    else
                    {
                        // Check each drops column in database for material name. Starts at 6 and ends with 12 because those positions in the array hold drops
                        for($i = 6; $i < 13; $i++)
                        {
                            if(stristr($search_result[$i][0], $_GET["search_term"]) != false)
                            {
                                $material_name = $search_result[$i][0];
                                print $material_name;
                                break;
                            }
                        }
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
					<center><h1>Xenoblade Chronicles X Material Search</h1></center>
					<hr/>
					<p>
						
						<div class="box">
							<p>
								<center><h3>Material Search</h3></center>
								
								Type in the material you would like enemy locations and augments for below. Type it exactly as you see it in-game (else it might not show up). Search is case insensitive. The results will include enemy locations and all augments that can be crafted with the desired material.
                                <br/><br/>
                                Notes: <br/>
                                <ul>
                                    <li>You can search the entire database by typing a word in the search box, but it will return the first material that it hits. It is much better to type the full name, or most of it.</li>
                                    <li><b>Some materials will return a blank enemy table!</b> This is because the material is mis-translated in the enemy database. I try to fix as many of these errors as I can.</li>
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
                                
                                if(stristr($search_result[6][0], $_GET["search_term"]) == false and stristr($search_result[7][0], $_GET["search_term"]) == false and
                                   stristr($search_result[8][0], $_GET["search_term"]) == false and stristr($search_result[9][0], $_GET["search_term"]) == false and
                                   stristr($search_result[10][0], $_GET["search_term"]) == false and stristr($search_result[11][0], $_GET["search_term"]) == false and
                                   stristr($search_result[12][0], $_GET["search_term"]) == false)
                                {
                                    // TODO Give material suggestions (Might not get around to this... It's going to be harder than the augment suggestions because 
                                    // we don't know where the materials will be in the results array)
                                    
                                    print "<div class=\"box\">";
                                    print "The requested material could not be found in the database. Please check the name and try again. <br/><br/>";
                                    print "</div>";
  
                                    die();
                                }
                                
                                print "
                                    <div class=\"box\">
                                        <p>
                                            <center><h3>Enemy Location Results for " .  $material_name . "</h3></center>
                                            <br/>
                                    <table class=\"resultsTable\">
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
                                    print print_enemy_materials($search_result);
                                    print "
                                    </table>";
                                
                                    print 
                                    "<br/><br/><center><h3>Augment Results for " .  $material_name . "</h3></center>
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
                                        </tr>";
                                        print print_augments($augment_search_result);
                                        
                                        print "
                                    </table>";
                                        
                                    }
                            ?>
                                
                            </p>
                        </div>

                    </p>

                </p>
			
			
			</article>
			
			<div class="paddingBottom">
			</div>
			
			<!-- <footer>
				2016 birdonwheels5.
			</footer> -->
		</div>
	</body>
	
</html>
