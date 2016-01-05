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
        
        for($i = 0;$i < $count; $i++)
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
        
        for($i = 0;$i < $count; $i++)
        {
            print "<tr>\n";
            
            print "\n<td>\n<a href =\"ground_gear_list.php?gear=" . preg_replace('/\s+/', '+', $ground_gear_array[0]) . "\">" . $ground_gear_array[0] . "</a>\n<td/>\n";
            print "\n<td>\n". $ground_gear_array[1] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[2] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[3] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[4] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[5] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[6] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[7] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[8] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[9] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[10] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[11] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[12] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[13] . " \n<td/>\n";
            print "\n<td>\n". $ground_gear_array[14] . " \n<td/>\n";
            
            print "</tr>\n";
        }
    }
    
    // Returns multidimensional array of data that matches augment requirements
    function get_gear_bestiary_data($database_connection, $mat0, $mat1, $mat2, $mat3, $mat4, $mat5)
    {
        $mat0 = trim(preg_replace('/[0-9]+/', '', $mat0));
        $mat1 = trim(preg_replace('/[0-9]+/', '', $mat1));
        $mat2 = trim(preg_replace('/[0-9]+/', '', $mat2));
        $mat3 = trim(preg_replace('/[0-9]+/', '', $mat3));
        $mat4 = trim(preg_replace('/[0-9]+/', '', $mat4));
        $mat5 = trim(preg_replace('/[0-9]+/', '', $mat5));
        
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
