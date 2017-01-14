<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'per_page'=>1,
                'extra'=>'url_q'
            ];
            $imgList = [];
            $res = $flickr->photos_search($option);
            $json = json_encode($res);
            $obj = json_decode($json);
            foreach($obj->photo as $photo){
                static $i = 0;
                $imageUrl = $photo->url_q;
                $imgList[$i] = $imageUrl;
                $i++;
            }
            return $imgList;
        }
    }

?>