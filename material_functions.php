<?php
    
    // Returns enemies that drop specified material, and info related to them
    function get_enemy_material($database_connection, $material)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Bestiary` WHERE `Bestiary`.`Drops0` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops1` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops2` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops3` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops4` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops5` ='" . $material . "' 
                                                                                  OR `Bestiary`.`Drops6` ='" . $material . "';");
        
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
        $name = array();
        $genus = array();
        $type = array();
        $continent = array();
        $location = array();
        $lv = array();
        $drops0 = array();
        $drops1 = array();
        $drops2 = array();
        $drops3 = array();
        $drops4 = array();
        $drops5 = array();
        $drops6 = array();
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $name[$i] = $rows[$i]["Name"];
            $genus[$i] = $rows[$i]["Genus"];
            $type[$i] = $rows[$i]["Type"];
            $continent[$i] = $rows[$i]["Continent"];
            $location[$i] = $rows[$i]["Location"];
            $lv[$i] = $rows[$i]["Lv"];
            $drops0[$i] = $rows[$i]["Drops0"];
            $drops1[$i] = $rows[$i]["Drops1"];
            $drops2[$i] = $rows[$i]["Drops2"];
            $drops3[$i] = $rows[$i]["Drops3"];
            $drops4[$i] = $rows[$i]["Drops4"];
            $drops5[$i] = $rows[$i]["Drops5"];
            $drops6[$i] = $rows[$i]["Drops6"];
        }
        
        $data = array();
        
        $data[0] = $name;
        $data[1] = $genus;
        $data[2] = $type;
        $data[3] = $continent;
        $data[4] = $location;
        $data[5] = $lv;
        $data[6] = $drops0;
        $data[7] = $drops1;
        $data[8] = $drops2;
        $data[9] = $drops3;
        $data[10] = $drops4;
        $data[11] = $drops5;
        $data[12] = $drops6;
        
        return $data;
    }
    
    function print_enemy_materials($bestiary_material_data)
    {
        $count = count($bestiary_material_data[0]);
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n". $bestiary_material_data[0][$i] . " \n<td/>\n";
            print "\n<td>\n". $bestiary_material_data[1][$i] . " \n<td/>\n";
            print "\n<td>\n". $bestiary_material_data[2][$i] . " \n<td/>\n";
            print "\n<td>\n". $bestiary_material_data[3][$i] . " \n<td/>\n";
            print "\n<td>\n". $bestiary_material_data[4][$i] . " \n<td/>\n";
            print "\n<td>\n". $bestiary_material_data[5][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Uses result array of material search to print out the augments that match the material
    function print_augments($search_result)
    {
        $count = count($search_result[0]);
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"augment_search.php?search_term=" . preg_replace('/\s+/', '+', $search_result[0][$i]) . "\">" . $search_result[0][$i] . "</a>\n<td/>\n";
            print "\n<td>\n". $search_result[1][$i] . " \n<td/>\n";
            print "\n<td>\n". $search_result[2][$i] . " \n<td/>\n";
            print "\n<td>\n". $search_result[3][$i] . " \n<td/>\n";
            print "\n<td>\n". $search_result[4][$i] . " \n<td/>\n";
            print "\n<td>\n". $search_result[5][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Returns array of all augments that contain the material search term
    function linear_material_search($augments_raw_data, $material)
    {
        $count = count($augments_raw_data[0]);
        
        // Fields to store augment match data
        $name = array();
        $effect = array();
        $mat0 = array();
        $mat1 = array();
        $mat2 = array();
        $rare_resource = array();
        
        // Try first material
        for($i = 0; $i < $count; $i++)
        {
            if(stristr($augments_raw_data[2][$i], $material))
            {
                $name[$i] = $augments_raw_data[0][$i];
                $effect[$i] = $augments_raw_data[1][$i];
                $mat0[$i] = $augments_raw_data[2][$i];
                $mat1[$i] = $augments_raw_data[3][$i];
                $mat2[$i] = $augments_raw_data[4][$i];
                $rare_resource[$i] = $augments_raw_data[5][$i];
            }
        }
        
        // Try second material if results are empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($augments_raw_data[3][$i], $material))
                {
                    $name[$i] = $augments_raw_data[0][$i];
                    $effect[$i] = $augments_raw_data[1][$i];
                    $mat0[$i] = $augments_raw_data[2][$i];
                    $mat1[$i] = $augments_raw_data[3][$i];
                    $mat2[$i] = $augments_raw_data[4][$i];
                    $rare_resource[$i] = $augments_raw_data[5][$i];
                }
            }
        }
        
        // Try third material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($augments_raw_data[4][$i], $material))
                {
                    $name[$i] = $augments_raw_data[0][$i];
                    $effect[$i] = $augments_raw_data[1][$i];
                    $mat0[$i] = $augments_raw_data[2][$i];
                    $mat1[$i] = $augments_raw_data[3][$i];
                    $mat2[$i] = $augments_raw_data[4][$i];
                    $rare_resource[$i] = $augments_raw_data[5][$i];
                }
            }
        }
        
        $name = array_values($name);
        $effect = array_values($effect);
        $mat0 = array_values($mat0);
        $mat1 = array_values($mat1);
        $mat2 = array_values($mat2);
        $rare_resource = array_values($rare_resource);
        
        $results[0] = $name;
        $results[1] = $effect;
        $results[2] = $mat0;
        $results[3] = $mat1;
        $results[4] = $mat2;
        $results[5] = $rare_resource;
        
        return $results;
    }
    
?>
