<?php

    function print_grid($arr, $n) {
        $len = strlen((string)($n * $n - 1));
        $y = 0;
        $c = count($arr);
        $str = "";
        if ($GLOBALS["visu"] == 1 && $GLOBALS["clear"] == 1){
            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
        }
        echo "\n\n";
        while ($y < $c) {
            echo "\t";
            $x = 0;
            while ($x < $c) {
                $tmplen = strlen($arr[$y][$x]);
                if ($arr[$y][$x] == 0) {
                    echo disp_color($str, 2);
                    $str = "";
                    $tmpZ = $arr[$y][$x];
                    $tmpZ .= " ";
                    while ($tmplen < $len) {
                        $tmpZ .= " ";
                        $tmplen++;
                    }
                    if ($arr[$y][$x] != $GLOBALS["gridGoal"][$y][$x]) {
                        echo disp_color($tmpZ, 1);
                    } else {
                        echo disp_color($tmpZ, 3);
                    }
                }
                else {
                    if ($arr[$y][$x] == $GLOBALS["gridGoal"][$y][$x]) {
                        echo disp_color($str, 2);
                        $str = "";
                        $tmpZ = $arr[$y][$x];
                        $tmpZ .= " ";
                        while ($tmplen < $len) {
                            $tmpZ .= " ";
                            $tmplen++;
                        }
                        echo disp_color($tmpZ, 3);
                    }
                    else {
                        $tmpStr = $arr[$y][$x] . " ";
                        while ($tmplen < $len) {
                            $tmpStr .= " ";
                            $tmplen++;
                        }
                        $str .= $tmpStr;
                    }       
                }
                $x++;
            }
            $y++;
            echo disp_color($str, 2);
            echo  "\n";
            $str = "";
        }
    }

    function find_zero($grid) {
        $y = 0;
        while ($y < $GLOBALS["nbN"]) {
            $x = 0;
            while ($x < $GLOBALS["nbN"]) {
                if ($grid[$y][$x] == 0) {
                    return array("x0" => $x, "y0" => $y);
                }
                $x++;
            }
            $y++;
        }
        return 0;
    }

    function grid_to_str($grid) {
        $y = 0;
        $tmp = "";
        $c = count($grid);
        while ($y < $c) {
            $x = 0;
            while ($x < $c) {
                $tmp .= $grid[$y][$x];
                $x++;
            }
            $y++;
        }
        return $tmp;
    }

    function goal_grid($n) {
        $nb = 1;
        $snail = 0;
        $x = 0;
        $y = 0;
        $nbmax = $n * $n;
        while ($nb < $nbmax) {
            while ($x < ($n - $snail)) {
                $ret[$y][$x] = $nb;
                $x++;
                $nb++;
            }
            $x--;
            $y++;
            while ($y < ($n - $snail)) {
                $ret[$y][$x] = $nb;
                $y++;
                $nb++;
            }
            $y--;
            $x--;
            if ($nb == $nbmax) {
                $ret[$y][$x] = 0;
                break;
            }
            while ($x >= (0 + $snail)) {
                $ret[$y][$x] = $nb;
                $x--;
                $nb++;
            }
            $x++;
            $y--;
            $snail++;
            while ($y >= (0 + $snail)) {
                $ret[$y][$x] = $nb;
                $y--;
                $nb++;
            }
            $y++;
            $x++;
            if ($nb == $nbmax) {
                $ret[$y][$x] = 0;
            }
        }
        $GLOBALS["strGoal"] = grid_to_str($ret);
        $GLOBALS["gridGoal"] = $ret;
    }

?>