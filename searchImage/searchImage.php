<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'media'=>'photos',
                'per_page'=>1,
                'extras'=>'url_q,url_m',
                'sort'=>'interestingness-desc'
            ];
            $img = [];
            $obj = json_decode(json_encode($flickr->photos_search($option)));
            foreach($obj->photo as $photo){
                $img[0] = $photo->url_q;
                $img[1] = $photo->url_m;
            }
            return $img;            
        }  
    }

?>