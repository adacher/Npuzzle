<?php
    function parse_file($argv) {
        $i = 0;
        $coordinates = [];
        $nbvalues = 0;
        $fileArr = file($argv);
        delComms($fileArr);
        $total = $fileArr[0];
        if (!(preg_match('/^[0-9]*$/', $total))) {
            echo "Error: invalid puzzle size\n";
            return 1;
        }
        $GLOBALS["nbN"] = $total;
        goal_grid($GLOBALS["nbN"]);
        $total *= $total;
        unset($fileArr[0]);
        $fileArr = array_values($fileArr);
        for ($i = 0, $len = count($fileArr); $i < $len; $i++) {   
            $coordinates[] = preg_split('/\s/', $fileArr[$i], -1, PREG_SPLIT_NO_EMPTY);      
        }
        for ($i = 0, $len = count($coordinates); $i < $len; $i++) {
            for ($n = 0, $j = count($coordinates[$i]); $n < $j; $n++) {
                $nbvalues++;
            }
        }
        if (check_numbers($coordinates) != 0) {
            return 1;
        }
        if ($total != $nbvalues) {
            print("Error: number missing in puzzle\n");
            return 1;
        }
        else {
            return $coordinates;
        }
    }
    
    function check_numbers($coordinates) {
        $x = 0;
        $total = $GLOBALS["nbN"] * $GLOBALS["nbN"];
        while ($x < $GLOBALS["nbN"]){
            $y = 0;
            while ($y < $GLOBALS["nbN"]){
                if ($coordinates[$x][$y] >= $total || $coordinates[$x][$y] < 0)
                {
                    echo "Error: a number is not allowed in the puzzle.\n";
                    return 1;
                }
                if (!ctype_digit($coordinates[$x][$y]))
                {
                    echo "Error: invalid character in puzzle.\n";
                    return 1;
                }
                $y++;
            }
            $x++;
        }
        return 0;
    }

    function isFileEmpty($arr) {
        clearstatcache();
        if(filesize($arr)) {
            return 0;
        }
        return 1;
    }
    
    function delComms(&$arr) {
        $i = 0;
        $nbElem = count($arr);
        while ($i < $nbElem) {
            if ($arr[$i][0] == '#' || $arr[$i] == NULL) {
                unset($arr[$i]);
            }
            else if (($pos = strpos($arr[$i], '#')) !== FALSE) {
                $arr[$i] = substr($arr[$i], 0 , $pos);
            }
            $i++;
        }
        $arr = array_values($arr);
    }
?>