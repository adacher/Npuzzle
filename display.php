<?php
    function disp_color($var, $which) {
        if ($which == 1) {
            $test = "\033[1;37m\033[41m";
            $test .= $var . "\033[0m";
            return($test);
        }
        else if ($which == 2) {
            $test = "\033[0;30m\033[47m";
            $test .= $var . "\033[0m";
            return($test);
        }
        else {
            $test = "\033[0;30m\033[42m";
            $test .= $var . "\033[0m";
            return($test);
        }
    }

    function ask_user($i) {
        $clear = chr(27).chr(91).'H'.chr(27).chr(91).'J';
        if ($i == 1) {
            echo "\n\n\tEnter puzzle size (size must be greater than 2 and lower than 30)\n";
            $size = fgets(STDIN);
            echo $clear;
            if ($size < 3) {
                echo "Size must be 3 or above\n";
                return 1;
            }

            if ($size > 29) {
                echo "Error: unreasonable puzzle size.\n";
                return 1;
            }
            $GLOBALS["nbN"] = $size;
            goal_grid($size);            
            $GLOBALS["size"] = $size;           
            $GLOBALS["customgrid"] = generateGrid($size);

        }
        echo "\n\n\t\tChoose one of the following search method by typing it's associated number (1 or 2)\n\n";
        echo "\t\t[1] - Uniform cost\n";   
        echo "\t\t[2] - Greedy search\n\n\n";
        $search = fgets(STDIN);
        echo $clear;
        if ($search != 1 && $search != 2) {
            echo "Please provide a number, either 1 or 2 \n";
            return 1;
        }
        echo "\n\n\t\tChoose one of the following heurisitcs by typing it's associated number\n\n";
        echo "\t\t[1] - Manhattan\n";
        echo "\t\t[2] - Euclidean\n";
        echo "\t\t[3] - Hamming\n";
        echo "\t\t[4] - Linear conflict\n";
        $h = fgets(STDIN);
        echo $clear;
        if ($h != 1 && $h != 2 && $h != 3 && $h != 4) {
            echo "Please provide a number between 1 and 4.\n";
            return 1;
        }
        echo "\n\n\t\t Do you want to unable visualisation ?\n\n";
        echo"\t\t[1] - Yes\n";
        echo "\t\t[2] - No\n";
        $visu = fgets(STDIN);
        echo $clear;
        if ($visu != 1 && $visu != 2) {
            echo "Please provide a number, either 1 or 2.\n";
            return 1;
        }
        $GLOBALS["chose"] = $h;
        $GLOBALS["search"] = $search;
        $GLOBALS["visu"] = $visu;
        return 0;
    }

    function display_solving_steps($process, $closedList, $openlist_size) {
        $str = $process["parent"];
        $path = array();
        $i = 0;
        $time = count($closedList);
        $path[] = $process["grid"];
        while ($str != "start") {
            $path[] = json_decode($closedList[$str], TRUE)["grid"];
            $str = json_decode($closedList[$str], TRUE)["parent"];
            $i++;
        }
        if($i <= 50) {
            $timeSleep = 10000000 / (2 * $i);
        } else {
            $timeSleep = 10000000 / $i;
        }
        $pathbis = array_reverse($path);
        foreach ($pathbis as $elem) {
            echo print_grid($elem, $GLOBALS["nbN"]) . "\n";
            usleep((int)$timeSleep);
        }
        echo "Number of moves required : " . $i . "\n";
        echo "complexity in time : " . $time . "\n";   
        echo "complexity in size : " . ($time + $openlist_size) . "\n";
        return 0;
    }
?>
