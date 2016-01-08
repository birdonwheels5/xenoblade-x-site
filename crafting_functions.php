<?php
    
    function get_ground_gear_data($database_connection)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Ground_Gear` ORDER BY `Ground_Gear`.`Name` ASC ;");
        
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
        $gear_slot = array();
        $maker = array();
        $level = array();
        $defense = array();
        $battle_traits = array();
        $upgrades = array();
        $resistances = array();
        $mat0 = array();
        $mat1 = array();
        $mat2 = array();
        $mat3 = array();
        $mat4 = array();
        $mat5 = array();
        $mat6 = array();
        
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $name[$i] = $rows[$i]["Name"];
            $gear_slot[$i] = $rows[$i]["Gear Slot"];
            $maker[$i] = $rows[$i]["Maker"];
            $level[$i] = $rows[$i]["Lv"];
            $defense[$i] = $rows[$i]["Defense"];
            $battle_traits[$i] = $rows[$i]["Battle Traits"];
            $upgrades[$i] = $rows[$i]["Upgrades"];
            $resistances[$i] = $rows[$i]["Resistances"];
            $mat0[$i] = $rows[$i]["Mat0"];
            $mat1[$i] = $rows[$i]["Mat1"];
            $mat2[$i] = $rows[$i]["Mat2"];
            $mat3[$i] = $rows[$i]["Mat3"];
            $mat4[$i] = $rows[$i]["Mat4"];
            $mat5[$i] = $rows[$i]["Mat5"];
            $mat6[$i] = $rows[$i]["Mat6"];
            
        }
                
        $data = array();
        
        $data[0] = $name;
        $data[1] = $gear_slot;
        $data[2] = $maker;
        $data[3] = $level;
        $data[4] = $defense;
        $data[5] = $battle_traits;
        $data[6] = $upgrades;
        $data[7] = $resistances;
        $data[8] = $mat0;
        $data[9] = $mat1;
        $data[10] = $mat2;
        $data[11] = $mat3;
        $data[12] = $mat4;
        $data[13] = $mat5;
        $data[14] = $mat6;
        
        return $data;
    }
    
    // Used for the ground gear index
    function print_ground_gear($ground_gear_array)
    {
        $count = count($ground_gear_array[0]);
        
        for($i = 0; $i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"ground_gear_list.php?gear=" . preg_replace('/\s+/', '+', $ground_gear_array[0][$i]) . "\">" . $ground_gear_array[0][$i] . "</a>\n<td/>\n";
            
            print "\n<td>\n". $ground_gear_array[1][$i] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[2][$i] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[3][$i] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[4][$i] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[5][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Used for specific pieces of ground gear
    function print_ground_gear_result($ground_gear_array)
    {
        $count = count($ground_gear_array[0]);
        
        for($i = 0; $i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"ground_gear_list.php?gear=" . preg_replace('/\s+/', '+', $ground_gear_array[0]) . "\">" . $ground_gear_array[0] . "</a>\n<td/>\n";
            
            for($i = 1; $i < 15; $i++) // We have 15 rows total
            {
                print "\n<td>\n". $ground_gear_array[$i] . " \n<td/>\n";
            }
            
            print "</tr>\n";
        }
    }
    
    // Returns multidimensional array of data that matches ground gear requirements
    function get_gear_bestiary_data($database_connection, $mat0, $mat1, $mat2, $mat3, $mat4, $mat5)
    {
        $mat0 = trim(preg_replace('/[0-9]+/', '', $mat0));
        $mat1 = trim(preg_replace('/[0-9]+/', '', $mat1));
        $mat2 = trim(preg_replace('/[0-9]+/', '', $mat2));
        $mat3 = trim(preg_replace('/[0-9]+/', '', $mat3));
        $mat4 = trim(preg_replace('/[0-9]+/', '', $mat4));
        $mat5 = trim(preg_replace('/[0-9]+/', '', $mat5));
        
        $mat0_data = array();
        $mat0_data = get_enemy_material($database_connection, $mat0);
        
        $mat1_data = array();
        $mat1_data = get_enemy_material($database_connection, $mat1);
        
        $mat2_data = array();
        $mat2_data = get_enemy_material($database_connection, $mat2);
        
        $mat3_data = array();
        $mat3_data = get_enemy_material($database_connection, $mat3);
        
        $mat4_data = array();
        $mat4_data = get_enemy_material($database_connection, $mat4);
        
        $mat5_data = array();
        $mat5_data = get_enemy_material($database_connection, $mat5);
        
        // 3D array?!
        $results = array();
        $results[0] = $mat0_data;
        $results[1] = $mat1_data;
        $results[2] = $mat2_data;
        $results[3] = $mat3_data;
        $results[4] = $mat4_data;
        $results[5] = $mat5_data;
        
        return $results;
    }
    
    function get_superweapons_data($database_connection)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Skell_Superweapons` ORDER BY `Skell_Superweapons`.`Name` ASC ;");
        
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
        $slot = array();
        $level = array();
        $force = array();
        $ammo = array();
        $hits = array();
        $fuel = array();
        $attribute = array();
        $battle_traits = array();
        $mat0 = array();
        $mat1 = array();
        $mat2 = array();
        $mat3 = array();
        $mat4 = array();
        
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $name[$i] = $rows[$i]["Name"];
            $slot[$i] = $rows[$i]["Weapon Slot"];
            $level[$i] = $rows[$i]["Frame Level"];
            $force[$i] = $rows[$i]["Force"];
            $ammo[$i] = $rows[$i]["Ammo"];
            $hits[$i] = $rows[$i]["Hits"];
            $fuel[$i] = $rows[$i]["Fuel"];
            $attribute[$i] = $rows[$i]["Attribute"];
            $battle_traits[$i] = $rows[$i]["Battle Traits"];
            $mat0[$i] = $rows[$i]["Mat0"];
            $mat1[$i] = $rows[$i]["Mat1"];
            $mat2[$i] = $rows[$i]["Mat2"];
            $mat3[$i] = $rows[$i]["Mat3"];
            $mat4[$i] = $rows[$i]["Mat4"];
            
        }
                
        $data = array();
        
        $data[0] = $name;
        $data[1] = $slot;
        $data[2] = $level;
        $data[3] = $force;
        $data[4] = $ammo;
        $data[5] = $hits;
        $data[6] = $fuel;
        $data[7] = $attribute;
        $data[8] = $battle_traits;
        $data[9] = $mat0;
        $data[10] = $mat1;
        $data[11] = $mat2;
        $data[12] = $mat3;
        $data[13] = $mat4;
        
        return $data;
    }
    
    // Used for the superweapon index
    function print_superweapons($superweapons_array)
    {
        $count = count($superweapons_array[0]);
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"superweapon_list.php?superweapon=" . preg_replace('/\s+/', '+', $superweapons_array[0][$i]) . "\">" . $superweapons_array[0][$i] . "</a>\n<td/>\n";
            print "\n<td>\n". $superweapons_array[1][$i] . " \n<td/>\n";
            print "\n<td>\n". $superweapons_array[2][$i] . " \n<td/>\n";
            print "\n<td>\n". $superweapons_array[3][$i] . " \n<td/>\n";
            print "\n<td>\n". $superweapons_array[7][$i] . " \n<td/>\n";
            print "\n<td>\n". $superweapons_array[8][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Used for specific superweapons
    function print_superweapons_result($superweapons_array)
    {
        $count = count($superweapons_array[0]);
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            for($k = 0; $k < 14; $k++) // We have 14 rows total
            {
                print "\n<td>\n". $superweapons_array[$k] . " \n<td/>\n";
            }
            
            print "</tr>\n";
        }
    }
    
    // Returns multidimensional array of data that matches superweapon requirements
    function get_superweapon_bestiary_data($database_connection, $mat0, $mat1, $mat2, $mat3)
    {
        $mat0 = trim(preg_replace('/[0-9]+/', '', $mat0));
        $mat1 = trim(preg_replace('/[0-9]+/', '', $mat1));
        $mat2 = trim(preg_replace('/[0-9]+/', '', $mat2));
        $mat3 = trim(preg_replace('/[0-9]+/', '', $mat3));
        
        $mat0_data = array();
        $mat0_data = get_enemy_material($database_connection, $mat0);
        
        $mat1_data = array();
        $mat1_data = get_enemy_material($database_connection, $mat1);
        
        $mat2_data = array();
        $mat2_data = get_enemy_material($database_connection, $mat2);
        
        $mat3_data = array();
        $mat3_data = get_enemy_material($database_connection, $mat3);
        
        // 3D array?!
        $results = array();
        $results[0] = $mat0_data;
        $results[1] = $mat1_data;
        $results[2] = $mat2_data;
        $results[3] = $mat3_data;
        
        return $results;
    }
    
    function get_skell_frame_data($database_connection)
    {
        $result = mysqli_query($database_connection, "SELECT * FROM `Skell_Frames` ORDER BY `Skell_Frames`.`Name` ASC ;");
        
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
        $type = array();
        $miranium = array();
        $hp = array();
        $lv = array();
        $armor = array();
        $racc = array();
        $rpow = array();
        $eva = array();
        $gp = array();
        $insurance = array();
        $fuel = array();
        $macc = array();
        $mpow = array();
        $pot = array();
        $res = array();
        $armor_traits = array();
        $mat0 = array();
        $mat1 = array();
        $mat2 = array();
        $mat3 = array();
        $mat4 = array();
        $mat5 = array();
        $mat6 = array();
        
        
        // Fill the arrays with the data from the database
        for($i = 0; $i < $num_rows; $i++)
        {
            $name[$i] = $rows[$i]["Name"];
            $type[$i] = $rows[$i]["Frame Type"];
            $miranium[$i] = $rows[$i]["Required Miranium"];
            $hp[$i] = $rows[$i]["HP"];
            $lv[$i] = $rows[$i]["Lv"];
            $armor[$i] = $rows[$i]["Armor"];
            $racc[$i] = $rows[$i]["R.Acc"];
            $rpow[$i] = $rows[$i]["R.Pow"];
            $eva[$i] = $rows[$i]["Eva"];
            $gp[$i] = $rows[$i]["GP"];
            $insurance[$i] = $rows[$i]["Insurance"];
            $fuel[$i] = $rows[$i]["Fuel"];
            $macc[$i] = $rows[$i]["M.Acc"];
            $mpow[$i] = $rows[$i]["M.Pow"];
            $pot[$i] = $rows[$i]["Pot."];
            $res[$i] = $rows[$i]["Res"];
            $armor_traits[$i] = $rows[$i]["Armor Battle Traits"];
            $mat0[$i] = $rows[$i]["Mat0"];
            $mat1[$i] = $rows[$i]["Mat1"];
            $mat2[$i] = $rows[$i]["Mat2"];
            $mat3[$i] = $rows[$i]["Mat3"];
            $mat4[$i] = $rows[$i]["Mat4"];
            $mat5[$i] = $rows[$i]["Mat5"];
            $mat6[$i] = $rows[$i]["Mat6"];
            
        }
                
        $data = array();
        
        $data[0] = $name;
        $data[1] = $type;
        $data[2] = $miranium;
        $data[3] = $hp;
        $data[4] = $lv;
        $data[5] = $armor;
        $data[6] = $racc;
        $data[7] = $rpow;
        $data[8] = $eva;
        $data[9] = $gp;
        $data[10] = $insurance;
        $data[11] = $fuel;
        $data[12] = $macc;
        $data[13] = $mpow;
        $data[14] = $pot;
        $data[15] = $res;
        $data[16] = $armor_traits;
        $data[17] = $mat0;
        $data[18] = $mat1;
        $data[19] = $mat2;
        $data[20] = $mat3;
        $data[21] = $mat4;
        $data[22] = $mat5;
        $data[23] = $mat6;
        
        return $data;
    }
    
    // Used for the skell frame index
    function print_skell_frame($skell_frame_array)
    {
        $count = count($skell_frame_array[0]);
        
        for($i = 0; $i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"frame_list.php?frame=" . preg_replace('/\s+/', '+', $skell_frame_array[0][$i]) . "\">" . $skell_frame_array[0][$i] . "</a>\n<td/>\n";
            print "\n<td>\n". $skell_frame_array[1][$i] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Used for specific skell frames
    function print_skell_frame_result($skell_frame_array)
    {
        $count = count($skell_frame_array[0]);
        
        for($i = 0; $i < $count; $i++)
        {
            print "<tr>\n";
                        
            print "\n<td>\n". $skell_frame_array[0] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[1] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[2] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[16] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[17] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[18] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[19] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[20] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[21] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[22] . " \n<td/>\n";
            print "\n<td>\n". $skell_frame_array[23] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // This is here because we can't fit everything in one table (goes off the page)
    function print_skell_frame_stats($skell_frame_array)
    {
        $count = count($skell_frame_array[0]);
        
        for($i = 0; $i < $count; $i++)
        {
            print "\n<table class=\"resultsTable\">\n";
            print  "
            <tr>
            <td><b>HP</b></td>
            <td>" . $skell_frame_array[3] . "</td>
            <td><b>GP</b><br></td>
            <td>" . $skell_frame_array[9] . "</td></tr><tr>
            <td><b>Frame Lv</b><br></td>
            <td>" . $skell_frame_array[4] . "</td>
            <td><b>Insurance</b><br></td>
            <td>" . $skell_frame_array[10] . "</td></tr><tr>
            <td><b>Armor</b></td>
            <td>" . $skell_frame_array[5] . "</td>
            <td><b>Fuel</b></td>
            <td>" . $skell_frame_array[11] . "</td></tr><tr>
            <td><b>Ranged Accuracy</b><br></td>
            <td>" . $skell_frame_array[6] . "</td>
            <td><b>Melee Accuracy</b><br></td>
            <td>" . $skell_frame_array[12] . "</td></tr><tr>
            <td><b>Ranged Attack</b><br></td>
            <td>" . $skell_frame_array[7] . "</td>
            <td><b>Melee Attack</b><br></td>
            <td>" . $skell_frame_array[13] . "</td></tr><tr>
            <td><b>Evasion</b></td>
            <td>" . $skell_frame_array[8] . "</td>
            <td><b>Potential</b></td>
            <td>" . $skell_frame_array[14] . "</td>
            </tr></table>";
            print "\n<br/>\n";
            print "Resistances: " . $skell_frame_array[15] . "\n";
        }
    }
    
    // Returns multidimensional array of data that matches skell frame requirements
    function get_skell_frame_bestiary_data($database_connection, $mat0, $mat1, $mat2, $mat3, $mat4, $mat5)
    {
        $mat0 = trim(preg_replace('/[0-9]+/', '', $mat0));
        $mat1 = trim(preg_replace('/[0-9]+/', '', $mat1));
        $mat2 = trim(preg_replace('/[0-9]+/', '', $mat2));
        $mat3 = trim(preg_replace('/[0-9]+/', '', $mat3));
        $mat4 = trim(preg_replace('/[0-9]+/', '', $mat4));
        $mat5 = trim(preg_replace('/[0-9]+/', '', $mat5));
        
        $mat0_data = array();
        $mat0_data = get_enemy_material($database_connection, $mat0);
        
        $mat1_data = array();
        $mat1_data = get_enemy_material($database_connection, $mat1);
        
        $mat2_data = array();
        $mat2_data = get_enemy_material($database_connection, $mat2);
        
        $mat3_data = array();
        $mat3_data = get_enemy_material($database_connection, $mat3);
        
        $mat4_data = array();
        $mat4_data = get_enemy_material($database_connection, $mat4);
        
        $mat5_data = array();
        $mat5_data = get_enemy_material($database_connection, $mat5);
        
        // 3D array?!
        $results = array();
        $results[0] = $mat0_data;
        $results[1] = $mat1_data;
        $results[2] = $mat2_data;
        $results[3] = $mat3_data;
        $results[4] = $mat4_data;
        $results[5] = $mat5_data;
        
        return $results;
    }
    
?>
