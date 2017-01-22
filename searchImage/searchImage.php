<?php

    class searchImage{

        //画像検索関数
        //返り値$img　[0]=>サムネURL
        //           [1]=>画像本体URL
        public function search($str){    
            global $flickr;
            $option = [
                'text'=>$str,
                'media'=>'photos',
                'per_page'=>20,
                'extras'=>'url_q,url_m',
                'sort'=>'interestingness-desc'
            ];
            $img = [];
            $obj = json_decode(json_encode($flickr->photos_search($option)));
            $photo = $obj->photo[mt_rand(0,count($obj->photo))];
            array_push($img,$photo->url_q,$photo->url_m);
            return $img;            
        } 

        //複数画像検索
        public function search_all($str,$num){
            global $flickr;
            $option = [
                'text'=>$str,
                'media'=>'photos',
                'per_page'=>20,
                'extras'=>'url_q,url_m',
                'sort'=>'interestingness-desc'
            ];
            $obj = json_decode(json_encode($flickr->photos_search($option)));
            for($i = 0;$i <= $num ;$i++){
                $photo = $obj->photo[mt_rand(0,count($obj->photo))];
                $img[] = [$photo->url_q,$photo->url_m];
            }
            return $img;
        }
    }

?>