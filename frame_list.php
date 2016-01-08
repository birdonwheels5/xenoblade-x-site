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
        
        $skell_frame_raw_data = get_skell_frame_data($con);
        
        // $skell_frame_raw_data[0] contains all augment names
        $search_result = binary_search($skell_frame_raw_data[0], $_GET["frame"]);
    ?>
	<head>
		<meta charset="ISO-8859-1">
		<title>
            <?php
                // Print out the current augment as the page title.
                if ($_SERVER["REQUEST_METHOD"] == "GET") 
                {
                    if(empty($_GET["frame"]))
                    {
                        print "Skell Frame List";
                    }
                    else if(strcasecmp($skell_frame_raw_data[0][$search_result], $_GET["frame"]) != 0)
                    {
                        print "Skell Frame List ";
                    }
                    else
                    {
                        print $skell_frame_raw_data[0][$search_result];
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
					<center><h1>Xenoblade Chronicles X Craftable Skell Frames</h1></center>
					<hr/>
					<p>
						
						<div class="box">
							<p>
								<center><h3>Craftable Skell Frames</h3></center>
								
								Click on the skell frame you would like to find more details for.
                                <br/><br/>
                                Notes: <br/>
                                <ul>
                                    <li><a href ="https://docs.google.com/spreadsheets/d/1g0YR4M8RAHiRhCbAvV4tjXXHLEhRMrARzZMYAUGmyZ4/pub#" target="_blank">Full spreadsheet that was used</a>, created by Gessenkou, and modified by myself and others.</li>
                                    <li>This webpage was created by birdonwheels5.</li>
                                    <li><a href="https://github.com/birdonwheels5/xenoblade-x-site/" target="_blank">Source code</a></li>
                                </ul>
								
							</p>
						</div>
                        
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET") 
                            {
                                if(empty($_GET["frame"]))
                                {
                                    
                                    print "<div class=\"box\">\n";
                                    print "
                                    <center><h3>Skell Frame Index</h3>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Frame Name</b>
                                                <td/>
                                                <td>
                                                    <b>Frame Type</b>
                                                <td/>
                                            </tr>";
                                    print print_skell_frame($skell_frame_raw_data);
                                    print "</center></div>\n";
                                    
                                    die();
                                }
                                
                                if(strcasecmp($skell_frame_raw_data[0][$search_result], $_GET["frame"]) != 0)
                                {
                                    print "<div class=\"box\">";
                                    print "The requested frame could not be found in the database. <br/><br/>";
                                    
                                    
                                    // Explode the search term by spaces
                                    $exploded_frame = explode(" ", $_GET["frame"]);
                                    
                                    // Run a linear search with the first word of the search term
                                    $linear_results = linear_augment_search($skell_frame_raw_data, $exploded_frame[0]);
                                    $linear_results_count = count($linear_results);
                                    
                                    if($linear_results_count != 0)
                                    {
                                        print "<br/><br/>";
                                        
                                        print "Did you mean...<br/><br/>";
                                        
                                        print "<ul>";
                                        for($i = 0; $i < $linear_results_count; $i++)
                                        {
                                            // Replace spaces with +'s for url link
                                            print "<li><a href =\"skell_frame_list.php?frame=" . preg_replace('/\s+/', '+', $linear_results[$i]) . "\">" . $linear_results[$i] . "</a></li>";
                                        }
                                        print "</ul></div>";
                                    }
                                    
                                    
                                    die();
                                }
                                
                                // Put all the frame's data in its own array
                                $skell_frame_data = array();
                                for($i = 0; $i < 24; $i++) // We have 24 rows
                                {
                                    $skell_frame_data[$i] = $skell_frame_raw_data[$i][$search_result];
                                }
                                
                                // Search succeeded, time to get the rest of the data about the augment
                                $bestiary_data = get_skell_frame_bestiary_data($con, $skell_frame_raw_data[17][$search_result], $skell_frame_raw_data[18][$search_result], 
                                                                              $skell_frame_raw_data[19][$search_result], $skell_frame_raw_data[20][$search_result], 
                                                                              $skell_frame_raw_data[21][$search_result], $skell_frame_raw_data[22][$search_result]);
                                $frontiernav_data = get_frontiernav_data($con, $skell_frame_data[23]);
                                
                                print 
                                "<div class=\"box\">
                                    <p>
                                        <center><h3>Results for " .  $skell_frame_data[0] . "</h3></center>
                                        <br/>
                                        <br/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <b>Frame Name</b>
                                                <td/>
                                                <td>
                                                    <b>Frame Type</b>
                                                <td/>
                                                <td>
                                                    <b>Required Miranium</b>
                                                <td/>
                                                <td>
                                                    <b>Armor Battle Traits</b>
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
                                                    <b>Rare Resource</b>
                                                <td/>
                                            </tr>";
                                        print print_skell_frame_result($skell_frame_data);
                                        print "
                                        </table>
                                        <hr/>";
                                        
                                        print "<h3>Stats</h3>";
                                        print print_skell_frame_stats($skell_frame_data);
                                        
                                        print "<hr/>
                                        <table class=\"resultsTable\">
                                            <tr>
                                                <td>
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[17]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[17])) . "</a></h2>
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
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[18]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[18])) . "</a></h2>
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
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[19]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[19])) . "</a></h2>
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
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[20]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[20])) . "</a></h2>
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
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[21]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[21])) . "</a></h2>
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
                                                    <h2><a href=\"material_search.php?search_term=" . preg_replace('/\s+/', '+', trim(preg_replace('/[0-9]+/', '', $skell_frame_data[22]))) . "\" target=\"_blank\">" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[22])) . "</a></h2>
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
                                                    <h2>" . trim(preg_replace('/[0-9]+/', '', $skell_frame_data[23])) . "</h2>
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
