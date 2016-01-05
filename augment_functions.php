<?php
    // Returns multidimensional array of raw database data
    function get_augment_data($database_connection)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Augments`;");
        
        // Obtain the number of rows from the result of the query
        $num_rows = mysqli_num_rows($result);
        
        // Will be storing all the rows in here
        // Multidimensional array of form rows[table][row]
        $rows = array();
        
        // Get all the rows
        for($i = 0; $i < $num_rows; $i++)
        {
            $rows[$i] = mysqli_fetch_array($result);
        }
        
        // Fields that we need
        $augment_name = array();
        $effect = array();
        $mat1 = array();
        $mat2 = array();
        $mat3 = array();
        $rare_resource = array();
        
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $augment_name[$i] = $rows[$i]["Augment Name"];
            $effect[$i] = $rows[$i]["Effect"];
            $mat1[$i] = $rows[$i]["Material 1"];
            $mat2[$i] = $rows[$i]["Material 2"];
            $mat3[$i] = $rows[$i]["Material 3"];
            $rare_resource[$i] = $rows[$i]["Rare Resource"];
        }
        
        $data = array();
        
        $data[0] = $augment_name;
        $data[1] = $effect;
        $data[2] = $mat1;
        $data[3] = $mat2;
        $data[4] = $mat3;
        $data[5] = $rare_resource;
        
        return $data;
    }
    
    // Returns multidimensional array of data that matches augment requirements
    function get_bestiary_data($database_connection, $mat0, $mat1, $mat2)
    {
        $mat0 = trim(preg_replace('/[0-9]+/', '', $mat0));
        $mat1 = trim(preg_replace('/[0-9]+/', '', $mat1));
        $mat2 = trim(preg_replace('/[0-9]+/', '', $mat2));
        
        /* This returns all the enemies in one lump, but we want to sort them by materials
         * So, we use the get_enemy_materials function and supply materials one by one
        
        $result = mysqli_query($database_connection, "SELECT * FROM `Bestiary` WHERE `Bestiary`.`Drops0` ='" . $mat0 . "' OR `Bestiary`.`Drops0` ='" . $mat1 . "'OR `Bestiary`.`Drops0` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops1` ='" . $mat0 . "' OR `Bestiary`.`Drops1` ='" . $mat1 . "'OR `Bestiary`.`Drops1` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops2` ='" . $mat0 . "' OR `Bestiary`.`Drops2` ='" . $mat1 . "'OR `Bestiary`.`Drops2` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops3` ='" . $mat0 . "' OR `Bestiary`.`Drops3` ='" . $mat1 . "'OR `Bestiary`.`Drops3` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops4` ='" . $mat0 . "' OR `Bestiary`.`Drops4` ='" . $mat1 . "'OR `Bestiary`.`Drops4` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops5` ='" . $mat0 . "' OR `Bestiary`.`Drops5` ='" . $mat1 . "'OR `Bestiary`.`Drops5` ='" . $mat2 . "'
                                                                           OR `Bestiary`.`Drops6` ='" . $mat0 . "' OR `Bestiary`.`Drops6` ='" . $mat1 . "'OR `Bestiary`.`Drops6` ='" . $mat2 . "';");
        */
        
        $mat0_data = array();
        $mat0_data = get_enemy_material($database_connection, $mat0);
        
        $mat1_data = array();
        $mat1_data = get_enemy_material($database_connection, $mat1);
        
        $mat2_data = array();
        $mat2_data = get_enemy_material($database_connection, $mat2);
        
        // 3D array?!
        $results = array();
        $results[0] = $mat0_data;
        $results[1] = $mat1_data;
        $results[2] = $mat2_data;
        
        return $results;
    }
    
    // Prints the first row of the bestiary table.
    function print_bestiary_table_head()
    {
        print "
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
    }
    
    // Function for printing the html table output for the materials. Uses the 3D array we created in get_bestiary_data as the input.
    // $material_number is an integer, which decides which material to print out (can be 0, 1 or 2)
    function print_bestiary_table($bestiary_3d_array, $material_number)
    {
        for($i = 0;$i < count($bestiary_3d_array[$material_number][0]); $i++)
        {
            print "<tr>\n";
            for($k = 0; $k < 6; $k++) // $k = 6 because we have 6 arrays
            {
                print "\n<td>\n". $bestiary_3d_array[$material_number][$k][$i] . " \n<td/>\n";
            }
            print "</tr>\n";
        }
    }
    
    // Returns multidimensional array of data that matches augment requirements
    function get_frontiernav_data($database_connection, $rare_resource)
    {
        $rare_resource = trim(preg_replace('/[0-9]+/', '', $rare_resource));
        
        $result = mysqli_query($database_connection, "SELECT * FROM `FrontierNav`;");
        
        // Obtain the number of rows from the result of the query
        $num_rows = mysqli_num_rows($result);
        
        // Will be storing all the rows in here
        // Multidimensional array of form rows[table][row]
        $rows = array();
        
        // Get all the rows
        for($i = 0; $i < $num_rows; $i++)
        {
            $rows[$i] = mysqli_fetch_array($result);
        }
        
        // Fields that we need
        $fn_site = array();
        $m = array();
        $g = array();
        $b = array();
        $toursit_spots = array();
        $rare_resources = array();
        $connections = array();
        
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $fn_site[$i] = $rows[$i]["FN Site"];
            $m[$i] = $rows[$i]["M"];
            $g[$i] = $rows[$i]["G"];
            $b[$i] = $rows[$i]["B"];
            $tourist_spots[$i] = $rows[$i]["Tourist Spots"];
            $rare_resources[$i] = $rows[$i]["Rare Resources"];
            $connections[$i] = $rows[$i]["Connections"];
        }
        
        $raw_data = array();
        
        $raw_data[0] = $fn_site;
        $raw_data[1] = $m;
        $raw_data[2] = $g;
        $raw_data[3] = $b;
        $raw_data[4] = $tourist_spots;
        $raw_data[5] = $rare_resources;
        $raw_data[6] = $connections;
        
        $data = search_frontiernav_data($raw_data, $rare_resource);
        
        return $data;
    }
    
    // Search the array produced by get_frontiernav_data() for a specified rare resource
    // Returns a similiar array, but with just the FN Sites that satisfy the search condition.
    function search_frontiernav_data($frontiernav_data, $rare_resource)
    {
        $data_count = count($frontiernav_data[3]);
        
        // Components to reconstruct the multidimensional array
        $fn_site = array();
        $m = array();
        $g = array();
        $b = array();
        $tourist_spots = array();
        $rare_resources = array();
        $connections = array();
        
        $result = array();
        
        $result[0] = $fn_site;
        $result[1] = $m;
        $result[2] = $g;
        $result[3] = $b;
        $result[4] = $tourist_spots;
        $result[5] = $rare_resources;
        $result[6] = $connections;
        
        for($i = 0; $i < $data_count; $i++)
        {
            if(stristr($frontiernav_data[5][$i], $rare_resource) != false)
            {
                for($k = 0; $k < 7; $k++) // $k = 7 because we have 7 arrays
                {
                    $result[$k][$i] = $frontiernav_data[$k][$i];
                }
            }
        }
        
        // We use the array_values function to reset the index of the resulting arrays (ie. start at 0)
        for($k = 0; $k < 7; $k++)
        {
            $result[$k] = array_values($result[$k]);
        }
        
        return $result;
    }
    
    // Function for printing the html table output for the rare resources. Uses the array we created in the get_bestiary_data as the input.
    function print_frontiernav_table($searched_frontiernav_array)
    {
        for($i = 0;$i < count($searched_frontiernav_array[0]); $i++)
        {
            print "<tr>\n";
            for($k = 0; $k < 7; $k++) // $k = 7 because we have 7 arrays
            {
                print "\n<td>\n". $searched_frontiernav_array[$k][$i] . " \n<td/>\n";
            }
            
            print "</tr>\n";
        }
    }
    
    // Returns array of all result augment names. It is a regular array.
    // Returns quick index augments if search term is empty. It is a multidimensional array.
    function linear_augment_search($augments_raw_data, $search_term)
    {
        $list_length = count($augments_raw_data[0]);
        $results = array();
        
        // Perform the search with the search term
        if(!empty($search_term))
        {
            for($i = 0; $i < $list_length; $i++)
            {
                if(stristr($augments_raw_data[0][$i], $search_term))
                {
                    $results[$i] = $augments_raw_data[0][$i];
                }
            }
        }
        else // Search term is empty, get results for the quick index
        {
            // Going to store augment name and effect
            $name = array();
            $effect = array();
            
            for($i = 0; $i < $list_length; $i++)
            {
                // We filter out every augment that is not XX or a special augment
                if(substr($augments_raw_data[0][$i], -1) != "I" and substr($augments_raw_data[0][$i], -1) != "V" and
                   substr($augments_raw_data[0][$i], -1) != "X" or substr($augments_raw_data[0][$i], -2) == "XX")
                {
                    $name[$i] = $augments_raw_data[0][$i];
                    $effect[$i] = $augments_raw_data[1][$i];
                }
            }
            
            $name = array_values($name);
            $effect = array_values($effect);
            
            $results[0] = $name;
            $results[1] = $effect;
            
            return $results;
        }
        
        $results = array_values($results);
        
        return $results;
    }
    
    // Prints the augment index to the webpage.
    // Takes a multidimensional array with augment names and effects, obtained from a search with linear_augment_search with an empty search term
    function print_augment_index($augment_index)
    {
        $count = count($augment_index[0]);
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"augment_search.php?search_term=" . preg_replace('/\s+/', '+', $augment_index[0][$i]) . "\">" . $augment_index[0][$i] . "</a>\n<td/>\n";
            print "\n<td>\n". $augment_index[1][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }

?>
