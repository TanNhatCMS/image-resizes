<?php

namespace Tannhatcms\ImageResize\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use Ophim\Core\Models\Movie;

class ImageResizesController 
{
    //

    public function thumbnails($size, $id)
    {
      $ext = substr($id, strrpos($id, '.') + 1);
      $filename = substr($id, 0 , (strrpos($id, ".")));
      $config = config('theme8anime.sizes');
      $movie = Movie::fromCache()->find($filename);
      $savedPath =  'thumbnail/'.$size . '/' . $filename;
      $savedFile =  $savedPath.'/'.$id;
     // $currentMovie->poster_url
      if (is_null($movie))   abort(404);
        $img = null;
      if($size=='poster'){
        $img =$movie->poster_url;
      }else{
        $img =$movie->thumb_url;
      }
      if (is_null($img))    abort(404);
      try {
            $imageFullPath = public_path(urldecode($img));
            if (!file_exists($imageFullPath)|| !isset($config[$size])) {
              abort(404);
            }            
            $savedDir = dirname($savedPath);
            Storage::disk('public')->put( $savedFile, null);
            list($width, $height) = $config[$size];
            if($width==0 && $height==0){
              list($width, $height) = getimagesize($imageFullPath);
            }
            $image = Image::make($imageFullPath)->encode($ext, 100)->fit($width, $height)->save(storage_path("app/public/" . $savedFile),100);
            header('HTTP/1.0 200 OK', 200);
           // header('Content-Type:'.mime_content_type($savedFile));
           // header('Content-Length: ' . filesize($savedFile));
            return $image->response();
        } catch (\Exception $e) {
            Log::error($e->getMessage()." for id".$id);
            return $e->getMessage();
        }
    }
    public function link($size, $id)
    {
      $ext = substr($id, strrpos($id, '.') + 1);
      $filename = substr($id, 0 , (strrpos($id, ".")));
      $config = config('theme8anime.sizes');
      $movie = Movie::fromCache()->find($filename);
      $savedPath =  'thumbnail-link/'.$size . '/' . $filename;
      $savedFile =  $savedPath.'/'.$id;
     // $currentMovie->poster_url
      if (is_null($movie))   abort(404);
        $img = null;
      if($size=='poster'){
        $img =$movie->poster_url;
      }else{
        $img =$movie->thumb_url;
      }
      if (is_null($img))    abort(404);
      try {
            $imageFullPath = public_path(urldecode($img));
            if (!file_exists($imageFullPath)|| !isset($config[$size])) {
              abort(404);
            }            
            $savedDir = dirname($savedPath);
            Storage::disk('public')->put( $savedFile, null);
            list($width, $height) = $config[$size];
            if($width==0 && $height==0){
              list($width, $height) = getimagesize($imageFullPath);
            }
            $image = Image::make($imageFullPath)->encode($ext, 100)->fit($width, $height)->save(storage_path("app/public/" . $savedFile),100);
            header('HTTP/1.0 200 OK', 200);
           // header('Content-Type:'.mime_content_type($savedFile));
           // header('Content-Length: ' . filesize($savedFile));
            return $image->response();
        } catch (\Exception $e) {
            Log::error($e->getMessage()." for id".$id);
            return $e->getMessage();
        }
    }
    public function flyResize($size, $imagePath)
    {
        try {
            $imageFullPath = public_path($imagePath);
            $sizes = config('theme8anime.sizes');
            if (!file_exists($imageFullPath)|| !isset($sizes[$size])) {
                abort(404);
            }
            $filename = substr($imagePath, strrpos($imagePath, '/') + 1);
            $path = substr($filename, 0 , (strrpos($filename, ".")));
            $savedPath = 'resizes/' . $size . '/' . $path.'/'.$filename;
            Storage::disk('public')->put($savedPath, null);
            list($width, $height) = $sizes[$size];
            $image = Image::make($imageFullPath)->resize($width, $height)->save(storage_path("app/public/" . $savedPath),100);
             header('Content-Type:'.mime_content_type(storage_path("app/public/" . $savedPath)));
            return $image->response();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }
    public function webpflyResize($size, $imagePath)
    {
        try {
            $imageFullPath = public_path($imagePath);
            $sizes = config('theme8anime.sizes');
            if (!file_exists($imageFullPath)|| !isset($sizes[$size])) {
                abort(404);
             
            }
            $filename = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',substr($imagePath, strrpos($imagePath, '/') + 1));
            $path = substr($filename, 0 , (strrpos($filename, ".")));
            $savedPath = 'resizes/' . $size . '/' . $path.'/'.$filename;
            $filesave = storage_path("app/public/" . $savedPath);
            if (Storage::disk('public')->exists($savedPath)) {
                //$content = file_get_contents($filesave);
               // header('Content-Type:'.mime_content_type($filesave));
                header('HTTP/1.0 200 OK'); 
                header('content-type: image/webp');
                //header('Content-Disposition: attachment; filename='.basename($savedPath));
                //header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($filesave));
                readfile($filesave);
                
                //echo $content;
                return;
            }
            Storage::disk('public')->put($savedPath, null);
            list($width, $height) = $sizes[$size];
            $image = Image::make($imageFullPath)->encode('webp', 100)->resize($width, $height)->save(storage_path("app/public/" . $savedPath),100);
            return $image->response();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }
function smartReadFile($location, $filename, $mimeType='application/octet-stream')
{ if(!file_exists($location))
  { header ("HTTP/1.0 404 Not Found");
    return;
  }
 
  $size=filesize($location);
  $time=date('r',filemtime($location));
 
  $fm=@fopen($location,'rb');
  if(!$fm)
  { header ("HTTP/1.0 505 Internal server error");
    return;
  }
 
  $begin=0;
  $end=$size;
 
  if(isset($_SERVER['HTTP_RANGE']))
  { if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
    { $begin=intval($matches[0]);
      if(!empty($matches[1]))
        $end=intval($matches[1]);
    }
  }
 
  if($begin>0||$end<$size)
    header('HTTP/1.0 206 Partial Content');
  else
    header('HTTP/1.0 200 OK'); 
 
  header("Content-Type: $mimeType");
  header('Cache-Control: public, must-revalidate, max-age=0');
  header('Pragma: no-cache'); 
  header('Accept-Ranges: bytes');
  header('Content-Length:'.($end-$begin));
  header("Content-Range: bytes $begin-$end/$size");
  header("Content-Disposition: inline; filename=$filename");
  header("Content-Transfer-Encoding: binary\n");
  header("Last-Modified: $time");
  header('Connection: close'); 
 
  $cur=$begin;
  fseek($fm,$begin,0);

  while(!feof($fm)&&$cur<$end&&(connection_status()==0))
  { print fread($fm,min(1024*16,$end-$cur));
    $cur+=1024*16;
  }
}
}
