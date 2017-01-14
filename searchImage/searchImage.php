<?php

    class searchImage{

        public function search($str,$count){    
            global $flickr;
            $option = [
                'text'=>$str,
                'per_page'=>$count,
                'extra'=>'url_q'
            ];
            $res = $flickr->photos_search($option);
            $json = json_encode($res);
            $obj = json_decode($json);
    }

?>