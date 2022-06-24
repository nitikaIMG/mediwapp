<?php

if(!function_exists('serializeID')){
    function serializeID($id){
        return base64_encode(serialize($id));
    }
}

if(!function_exists('unserializeID')){
    function unserializeID($id){
        return unserialize(base64_decode($id));
    }
}