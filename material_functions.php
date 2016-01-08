<?php
    // Returns multidimensional array of raw database data
    function get_raw_bestiary_data($database_connection)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Bestiary`;");
        
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
    
    // Returns enemies that drop specified material, and info related to them
    function get_enemy_material($database_connection, $material)
    {
        // Just in case a material has an apostraphe in it
        $material = mysqli_real_escape_string($database_connection, $material);
        
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
    function linear_material_augment_search($augments_raw_data, $material)
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
    
    // Returns array of all enemies that contain the material search term
    // This is probably very inefficient (possibly looping through 1200 entries 7 times) but it will have to suffice for now
    function linear_material_bestiary_search($bestiary_raw_data, $material)
    {
        $count = count($bestiary_raw_data[0]);
        
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
        
        // Try first material
        for($i = 0; $i < $count; $i++)
        {
            if(stristr($bestiary_raw_data[6][$i], $material))
            {
                $name[$i] = $bestiary_raw_data[0][$i];
                $genus[$i] = $bestiary_raw_data[1][$i];
                $type[$i] = $bestiary_raw_data[2][$i];
                $continent[$i] = $bestiary_raw_data[3][$i];
                $location[$i] = $bestiary_raw_data[4][$i];
                $lv[$i] = $bestiary_raw_data[5][$i];
                $drops0[$i] = $bestiary_raw_data[6][$i];
                $drops1[$i] = $bestiary_raw_data[7][$i];
                $drops2[$i] = $bestiary_raw_data[8][$i];
                $drops3[$i] = $bestiary_raw_data[9][$i];
                $drops4[$i] = $bestiary_raw_data[10][$i];
                $drops5[$i] = $bestiary_raw_data[11][$i];
                $drops6[$i] = $bestiary_raw_data[12][$i];
            }
        }
        
        // Try second material if results are empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[7][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        // Try third material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[8][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        // Try fourth material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[9][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        // Try fifth material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[10][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        // Try sixth material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[11][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        // Try seventh material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($bestiary_raw_data[12][$i], $material))
                {
                    $name[$i] = $bestiary_raw_data[0][$i];
                    $genus[$i] = $bestiary_raw_data[1][$i];
                    $type[$i] = $bestiary_raw_data[2][$i];
                    $continent[$i] = $bestiary_raw_data[3][$i];
                    $location[$i] = $bestiary_raw_data[4][$i];
                    $lv[$i] = $bestiary_raw_data[5][$i];
                    $drops0[$i] = $bestiary_raw_data[6][$i];
                    $drops1[$i] = $bestiary_raw_data[7][$i];
                    $drops2[$i] = $bestiary_raw_data[8][$i];
                    $drops3[$i] = $bestiary_raw_data[9][$i];
                    $drops4[$i] = $bestiary_raw_data[10][$i];
                    $drops5[$i] = $bestiary_raw_data[11][$i];
                    $drops6[$i] = $bestiary_raw_data[12][$i];
                }
            }
        }
        
        $name = array_values($name);
        $genus = array_values($genus);
        $type = array_values($type);
        $continent = array_values($continent);
        $location = array_values($location);
        $lv = array_values($lv);
        $drops0 = array_values($drops0);
        $drops1 = array_values($drops1);
        $drops2 = array_values($drops2);
        $drops3 = array_values($drops3);
        $drops4 = array_values($drops4);
        $drops5 = array_values($drops5);
        $drops6 = array_values($drops6);
        
        
        $results[0] = $name;
        $results[1] = $genus;
        $results[2] = $type;
        $results[3] = $continent;
        $results[4] = $location;
        $results[5] = $lv;
        $results[6] = $drops0;
        $results[7] = $drops1;
        $results[8] = $drops2;
        $results[9] = $drops3;
        $results[10] = $drops4;
        $results[11] = $drops5;
        $results[12] = $drops6;
        
        return $results;
    }
    
    // Returns array of all ground gear that contain the material search term
    // Code is messy just like the linear_material_bestiary_search
    // TODO This is broken. Bunnybod does not show up for fleecy fur search when it should
    function linear_material_ground_gear_search($ground_gear_raw_data, $material)
    {
        $count = count($ground_gear_raw_data[0]);
        
        // Fields that we need
        $name = array();
        $gear_slot = array();
        $maker = array();
        $level = array();
        $defense = array();
        $battle_traits = array();
        
        // Try first material
        for($i = 0; $i < $count; $i++)
        {
            if(stristr($ground_gear_raw_data[8][$i], $material))
            {
                $name[$i] = $ground_gear_raw_data[0][$i];
                $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                $maker[$i] = $ground_gear_raw_data[2][$i];
                $level[$i] = $ground_gear_raw_data[3][$i];
                $defense[$i] = $ground_gear_raw_data[4][$i];
                $battle_traits[$i] = $ground_gear_raw_data[6][$i];
            }
        }
        
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($ground_gear_raw_data[9][$i], $material))
                {
                    $name[$i] = $ground_gear_raw_data[0][$i];
                    $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                    $maker[$i] = $ground_gear_raw_data[2][$i];
                    $level[$i] = $ground_gear_raw_data[3][$i];
                    $defense[$i] = $ground_gear_raw_data[4][$i];
                    $battle_traits[$i] = $ground_gear_raw_data[6][$i];
                }
            }
            
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($ground_gear_raw_data[10][$i], $material))
                {
                    $name[$i] = $ground_gear_raw_data[0][$i];
                    $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                    $maker[$i] = $ground_gear_raw_data[2][$i];
                    $level[$i] = $ground_gear_raw_data[3][$i];
                    $defense[$i] = $ground_gear_raw_data[4][$i];
                    $battle_traits[$i] = $ground_gear_raw_data[6][$i];
                }
            }
        
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($ground_gear_raw_data[11][$i], $material))
                {
                    $name[$i] = $ground_gear_raw_data[0][$i];
                    $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                    $maker[$i] = $ground_gear_raw_data[2][$i];
                    $level[$i] = $ground_gear_raw_data[3][$i];
                    $defense[$i] = $ground_gear_raw_data[4][$i];
                    $battle_traits[$i] = $ground_gear_raw_data[6][$i];
                }
            }
        
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($ground_gear_raw_data[12][$i], $material))
                {
                    $name[$i] = $ground_gear_raw_data[0][$i];
                    $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                    $maker[$i] = $ground_gear_raw_data[2][$i];
                    $level[$i] = $ground_gear_raw_data[3][$i];
                    $defense[$i] = $ground_gear_raw_data[4][$i];
                    $battle_traits[$i] = $ground_gear_raw_data[6][$i];
                }
            }
        
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($ground_gear_raw_data[13][$i], $material))
                {
                    $name[$i] = $ground_gear_raw_data[0][$i];
                    $gear_slot[$i] = $ground_gear_raw_data[1][$i];
                    $maker[$i] = $ground_gear_raw_data[2][$i];
                    $level[$i] = $ground_gear_raw_data[3][$i];
                    $defense[$i] = $ground_gear_raw_data[4][$i];
                    $battle_traits[$i] = $ground_gear_raw_data[6][$i];
                }
            }
        
        $name = array_values($name);
        $gear_slot = array_values($gear_slot);
        $maker = array_values($maker);
        $level = array_values($level);
        $defense = array_values($defense);
        $battle_traits = array_values($battle_traits);
        
        
        $results[0] = $name;
        $results[1] = $gear_slot;
        $results[2] = $maker;
        $results[3] = $level;
        $results[4] = $defense;
        $results[5] = $battle_traits;
        
        return $results;
    }
    // Returns array of all superweapons that contain the material search term
    // Code is messy just like the linear_material_bestiary_search
    function linear_material_superweapon_search($superweapons_raw_data, $material)
    {
        $count = count($superweapons_raw_data[0]);
        
        // Fields that we need
        $name = array();
        $slot = array();
        $level = array();
        $force = array();
        $ammo = array();
        $hits = array();
        $fuel = array();
        $attribute = array();
        $battle_traits = array();
        
        // Try first material
        for($i = 0; $i < $count; $i++)
        {
            if(stristr($superweapons_raw_data[9][$i], $material))
            {
                $name[$i] = $superweapons_raw_data[0][$i];
                $slot[$i] = $superweapons_raw_data[1][$i];
                $level[$i] = $superweapons_raw_data[2][$i];
                $force[$i] = $superweapons_raw_data[3][$i];
                $ammo[$i] = $superweapons_raw_data[4][$i];
                $hits[$i] = $superweapons_raw_data[5][$i];
                $fuel[$i] = $superweapons_raw_data[6][$i];
                $attribute[$i] = $superweapons_raw_data[7][$i];
                $battle_traits[$i] = $superweapons_raw_data[8][$i];
            }
        }
        
        // Try second material if results are empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($superweapons_raw_data[10][$i], $material))
                {
                    $name[$i] = $superweapons_raw_data[0][$i];
                    $slot[$i] = $superweapons_raw_data[1][$i];
                    $level[$i] = $superweapons_raw_data[2][$i];
                    $force[$i] = $superweapons_raw_data[3][$i];
                    $ammo[$i] = $superweapons_raw_data[4][$i];
                    $hits[$i] = $superweapons_raw_data[5][$i];
                    $fuel[$i] = $superweapons_raw_data[6][$i];
                    $attribute[$i] = $superweapons_raw_data[7][$i];
                    $battle_traits[$i] = $superweapons_raw_data[8][$i];
                }
            }
        }
        
        // Try third material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($superweapons_raw_data[11][$i], $material))
                {
                    $name[$i] = $superweapons_raw_data[0][$i];
                    $slot[$i] = $superweapons_raw_data[1][$i];
                    $level[$i] = $superweapons_raw_data[2][$i];
                    $force[$i] = $superweapons_raw_data[3][$i];
                    $ammo[$i] = $superweapons_raw_data[4][$i];
                    $hits[$i] = $superweapons_raw_data[5][$i];
                    $fuel[$i] = $superweapons_raw_data[6][$i];
                    $attribute[$i] = $superweapons_raw_data[7][$i];
                    $battle_traits[$i] = $superweapons_raw_data[8][$i];
                }
            }
        }
        
        // Try fourth material if results are still empty
        if(empty($name))
        {
            for($i = 0; $i < $count; $i++)
            {
                if(stristr($superweapons_raw_data[12][$i], $material))
                {
                    $name[$i] = $superweapons_raw_data[0][$i];
                    $slot[$i] = $superweapons_raw_data[1][$i];
                    $level[$i] = $superweapons_raw_data[2][$i];
                    $force[$i] = $superweapons_raw_data[3][$i];
                    $ammo[$i] = $superweapons_raw_data[4][$i];
                    $hits[$i] = $superweapons_raw_data[5][$i];
                    $fuel[$i] = $superweapons_raw_data[6][$i];
                    $attribute[$i] = $superweapons_raw_data[7][$i];
                    $battle_traits[$i] = $superweapons_raw_data[8][$i];
                }
            }
        }
        
        $name = array_values($name);
        $slot = array_values($slot);
        $level = array_values($level);
        $force = array_values($force);
        $ammo = array_values($ammo);
        $hits = array_values($hits);
        $fuel = array_values($fuel);
        $attribute = array_values($attribute);
        $battle_traits = array_values($battle_traits);
        
        
        $results[0] = $name;
        $results[1] = $slot;
        $results[2] = $level;
        $results[3] = $force;
        $results[4] = $ammo;
        $results[5] = $hits;
        $results[6] = $fuel;
        $results[7] = $attribute;
        $results[8] = $battle_traits;
        
        return $results;
    }
?>
