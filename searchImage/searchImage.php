<?php

    class searchImage{

        public function search($str){    
            global $flickr;
            if($flickr){
                return "ok";
            }
                return "ng";
        }
    }

?>