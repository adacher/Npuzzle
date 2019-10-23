<?php

    function solvable($grid) {
        $invCount = inversion_count($grid, $GLOBALS["gridGoal"]);
        $tmp = manhattan_state($grid);           
        if ($tmp % 2 == 0 && $invCount % 2 == 0 || $tmp % 2 != 0 && $invCount % 2 != 0) {
            return 0;
        }
        echo "Error: puzzle is not solvable\n";
        return 1;
    }

    
    function inversion_count($grid, $goalGrid) {
        $n = $GLOBALS["nbN"];
        $y = 0;
        $inv = 0;
        while ($y < $n) {
            $x = 0;
            while ($x < $n) {
                $ybis = $y;
                $tmp = 0;
                while ($ybis < $n) {
                    if ($tmp != 0) {
                        $xbis = 0;
                    } else {
                        $xbis = $x + 1;
                        $tmp = 1;
                    }
                    while ($xbis < $n) {
                        $goalT = findInGoal($grid[$y][$x]);
                        $goalTbis = findInGoal($grid[$ybis][$xbis]);                      
                        $u1 = $goalT['x'] + $n * $goalT['y'];
                        $u2 = $goalTbis['x'] + $n * $goalTbis['y'];
                        if ($u1 > $u2) {
                            $inv++;
                        }
                        $xbis++;
                    }
                    $ybis++;
                }
                $x++;
            }
            $y++;
        }
        return $inv;
    }
    
    function depileSnail($grid) {
        $str = "";
        $n = $GLOBALS["nbN"];
        $nbmax = $n * $n;
        $snail = 0;
        $x = 0;
        $y = 0;
        $nb = 1;
        while ($nb < $nbmax) {
            while ($x < ($n - $snail)) {
                $str .= $grid[$y][$x];
                $x++;
                $nb++;
            }
            $x--;
            $y++;
            while ($y < ($n - $snail)) {
                $str .= $grid[$y][$x];
                $y++;
                $nb++;
            }
            $y--;
            $x--;
            if ($nb == $nbmax) {
                $str .= $grid[$y][$x];
                break;
            }
            while ($x >= (0 + $snail)) {
                $str .= $grid[$y][$x];
                $x--;
                $nb++;
            }
            $x++;
            $y--;
            $snail++;
            while ($y >= (0 + $snail)) {
                $str .= $grid[$y][$x];
                $y--;
                $nb++;
            }
            $y++;
            $x++;
            if ($nb == $nbmax) {
                $str .= $grid[$y][$x];
            }
        }
        return $str;
    }

?>