<?php
if (!function_exists('vn_to_str')) {
   
    function vn_to_str($str){
        // Lower case everything
        $str = mb_strtolower(trim($str));
        $str = str_replace(' ','-',$str);
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '-'=>'!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_',
            '-'=>'-+-', 
            '-'=>'\-+|\-+$',
        );
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

        return $str;
    }
}
if (!function_exists('thumbnail_url')) {
    function thumbnail_url($src, $slug, $width, $height){
        if($width == 55 && $height = 85){
            $src = '/storage/thumbnail/55x85/'.$slug;
        }elseif($width == 215 && $height = 320){
            $src = '/storage/thumbnail/215x320/'.$slug;
        }elseif($width == 180 && $height = 260){
            $src = '/storage/thumbnail/215x320/'.$slug;
        }else
        {
            // Lower case everything
            if(strrpos($src, 'poster')){
                $src = '/storage/thumbnail/poster/'.$slug;
            } elseif(strrpos($src, 'thumb')){
                $src = '/storage/thumbnail/thumb/'.$slug;
            }else{
                $src = '/storage/thumbnail/poster/'.$slug;
            }
        }
        
        return $src;
    }
}