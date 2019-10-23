<?php 
    class PQtest extends SplPriorityQueue 
    { 
        protected $serial = PHP_INT_MAX;
        public function insert($value, $priority) {
            parent::insert($value, array($priority, $this->serial--));
        }
        public function compare($priority1, $priority2) 
        {
        if ($priority1 === $priority2) return 0; 
            return $priority1 < $priority2 ? -1 : 1; 
        } 
    }

    function a_star_algorithm($startNode) {
        $openList = new PQtest();
        $openList->setExtractFlags(SplPriorityQueue::EXTR_DATA);
        $str_key = grid_to_str($startNode["grid"]);
        $openList->insert($str_key, -1 * $startNode['f']);
        $openListBis[$str_key] = json_encode($startNode);
        $closedList = [];
        while (!$openList->isEmpty()) {
            $mem_used = memory_get_usage(TRUE);           
            if ($mem_used > ($GLOBALS["mem_limit"] - 1048576 * 100)) {
               echo "Memory usage is about to go beyond memory limit.\n";
               $c = count($closedList) + count($openListBis);
               echo "Number of nodes in memory : " . $c . "\n";
               return;
            }
            $key = $openList->extract();
            while (!array_key_exists($key, $openListBis) && !$openList->isEmpty()) {
                $key = $openList->extract();
            }         
            if (!array_key_exists($key, $openListBis)) {
                break ;
            }
            $process = json_decode($openListBis[$key], TRUE);
            if ($process["h"] == 0) {              
                return(display_solving_steps($process, $closedList, count($openListBis)));
            }
            unset($openListBis[$key]);
            $closedList[$key] = json_encode($process);
            $children = create_children($process);
            foreach ($children as $child) {
                $tmpStr = grid_to_str($child["grid"]);
                if (!array_key_exists($tmpStr, $closedList)) {
                    if (!array_key_exists($tmpStr, $openListBis)) {                        
                        $openList->insert($tmpStr, -1 * $child['f']);
                        $openListBis[$tmpStr] =  json_encode($child);
                    } else {
                        $actualNode = json_decode($openListBis[$tmpStr], TRUE);
                        if ($child["g"] < $actualNode["g"]) {
                            $openList->insert($tmpStr, -1 * $child['f']);                            
                            $openListBis[$tmpStr] =  json_encode($child);
                        }
                    }
                }
            }
            unset($children);
        }
        echo "nb elem :" . count($closedList) . "\n";
        echo "Not possible to reach goal\n";
        return 1;
    }
?>