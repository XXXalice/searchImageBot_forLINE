<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'media'=>'photos',
                'per_page'=>1,
                'extras'=>'url_q,url_o'
            ];
            $img = [];
            $obj = json_decode(json_encode($flickr->photos_search($option)));
            foreach($obj->photo as $photo){
                $img[$photo->url_q] = $photo->url_o;
            }
            return $img;            
        }  
    }

?>