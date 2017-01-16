<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'media'=>'photos',
                'per_page'=>5,
                'extras'=>'url_q,url_m',
                'sort'=>'interestingness-desc'
            ];
            $img = [];
            $obj = json_decode(json_encode($flickr->photos_search($option)));
            $photo = $obj->photo[mt_rand(0,4)]
                $img[0] = $photo->url_q;
                $img[1] = $photo->url_m;
            return $img;            
        }  
    }

?>