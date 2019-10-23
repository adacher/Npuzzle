<?php

    function createNode($grid, $strParent, $g, $m) {
        $node["grid"] = $grid;
        $node["h"] = find_heuristic($grid);     
        $node["pos0"] = find_zero($grid);
        $node["parent"] = $strParent;
        $node["g"] =  $g + 1;
        if ($GLOBALS["search"] == 1) {
            $node["f"] =  $node["g"] + $node["h"];
        }
        else {
            $node["f"] =  $node["h"];
        }
        $node["move"] = $m;
        return $node;
    }

    function create_children($node) {
        $key = grid_to_str($node["grid"]);
        $x0 = $node["pos0"]["x0"];
        $y0 = $node["pos0"]["y0"];
        $g = $node["g"];
        $children = array();         
        if ($node["pos0"]["x0"] > 0 && $node["move"] != 'l') {
            $tmp = $node["grid"][$y0][$x0 - 1];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0][$x0 - 1] = 0;        
            $children[] = createNode($tmpGrid, $key, $g, 'r');
            unset($tmpGrid);
        }
        if ($node["pos0"]["x0"] < ($GLOBALS["nbN"] - 1) && $node["move"] != 'r') {
            $tmp = $node["grid"][$y0][$x0 + 1];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0][$x0 + 1] = 0;            
            $children[] = createNode($tmpGrid, $key, $g, 'l');
            unset($tmpGrid);
        }
        if ($node["pos0"]["y0"] > 0 && $node["move"] != 't') {
            $tmp = $node["grid"][$y0 - 1][$x0];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0 - 1][$x0] = 0;            
            $children[] = createNode($tmpGrid, $key, $g, 'b');
            unset($tmpGrid);
        }
        if ($node["pos0"]["y0"] < ($GLOBALS["nbN"] - 1) && $node["move"] != 'b') {
            $tmp = $node["grid"][$y0 + 1][$x0];
            $tmpGrid = $node["grid"];
            $tmpGrid[$y0][$x0] = $tmp;
            $tmpGrid[$y0 + 1][$x0] = 0;            
            $children[] = createNode($tmpGrid, $key, $g, 't');
            unset($tmpGrid);
        }
        return $children;
}
?>