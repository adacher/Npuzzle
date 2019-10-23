<?php
    function find_heuristic($grid) {
        $y = 0;
        $total = 0;
        $conflict = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] != 0) {
                    $tmp = findInGoal($grid[$y][$x]);
                    if ($GLOBALS["chose"] == 1){ 
                        $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                    }
                    if ($GLOBALS["chose"] == 2) {
                        $total += euclidean($tmp['x'], $tmp['y'], $x, $y);
                    }
                    if ($GLOBALS["chose"] == 3) {
                        if ($grid[$y][$x] != $GLOBALS["gridGoal"][$y][$x]) {
                            $total += 1;
                        }                        
                    }
                    if ($GLOBALS["chose"] == 4) {
                        $total += manhattan($tmp['x'], $tmp['y'], $x, $y);
                        $conflict += conflicts($grid, $y, $x, $tmp);
                    }
                }
                $x++;
            }
            $y++;
        }
        if ($GLOBALS["chose"] == 4) {
            return $total + $conflict;
        } else {
            return $total;
        }
    }

    function manhattan_state($grid) {
        $y = 0;
        $total = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] != 0) {
                    $tmp = findInGoal($grid[$y][$x]);                    
                    $total += manhattan($tmp['x'], $tmp['y'], $x, $y);                                                           
                }
                $x++;
            }
            $y++;
        }
        return($total);
    }

    function conflicts($grid, $yT, $xT, $cGoal) {       
        $conf = 0;
        $x = 0;
        while ($x < $GLOBALS["nbN"]) {
            if ($x != $xT) {
                $tmpC = findInGoal($grid[$yT][$x]);                
                if ($tmpC["y"] == $cGoal["y"]) {                    
                    if ($xT < $x && $cGoal['x'] > $tmpC['x'] || $xT > $x && $cGoal['x'] < $tmpC['x']) {
                        $conf++;
                    }
                }
            }
            $x++;
        }
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            if ($y != $yT) {
                $tmpC = findInGoal($grid[$y][$xT]);
                if ($tmpC["x"] == $cGoal["x"]) {
                    if ($yT < $y && $cGoal['y'] > $tmpC['y'] || $yT > $y && $cGoal['y'] < $tmpC['y']) {
                        $conf++;
                    }
                }
            }
            $y++;
        }
        return $conf;

    }

    function euclidean($xGoal, $yGoal, $xActual, $yActual) {
        return sqrt(pow($xActual - $xGoal, 2) + pow($yActual - $yGoal, 2));
    }

    function manhattan($xGoal, $yGoal, $xActual, $yActual) {
        return abs($xGoal - $xActual) + abs($yGoal - $yActual);
    }

    function findInGoal($num) {
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($GLOBALS["gridGoal"][$y][$x] == $num) {
                    return array("x" => $x, "y" => $y);
                }
                $x++;
            }
            $y++;
        }
        return 0;
    }
?>