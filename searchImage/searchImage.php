<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'per_page'=>1,
                'extra'=>'url_q'
            ];
            $res = $flickr->photos_search($option);
            $json = json_encode($res);            
        }
    }

?>