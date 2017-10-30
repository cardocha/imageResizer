<?php

require_once('php-image-magician/php_image_magician.php');
require_once('Image.php');

class ImageResizer
{
  private $image;

  public static $DEFAULT_RESOLUTION =  array(
   'landscape'=> array('width' => 800,'height'=>533),
    'portrait'=> array('width' => 600,'height'=>900),
    'mobile_landscape'=>array('width'=>600,'height'=>300),
    'mobile_portrait'=>array('width'=>300,'height'=>600)
  );
  function __construct($imagetoResize)
  {
    try {
      $this->image = new Image();
      list($width, $height) = getimagesize($imagetoResize);
      $is_landscape = $width > $height;
      $this->image->url = $imagetoResize;
      $this->image->height = $height;
      $this->image->width = $width;
      $this->image->extension = pathinfo($this->image->url, PATHINFO_EXTENSION);
      $this->image->orientation = $is_landscape ? "landscape" : "portrait";

    } catch (Exception $e) {
      throw new Exception("Image initializing error.", 1);
    }
  }
  public function resize($create_mobile_version)
  {
      if(!isset($create_mobile_version))
        $create_mobile_version= false;

      $magicianObj = new imageLib($this->image->url);
      $resolution  =  $this::$DEFAULT_RESOLUTION[$this->image->orientation] ;

      $magicianObj -> resizeImage($resolution['width'],$resolution['height'],'exact');
      $magicianObj -> saveImage($this->image->url);

      if($create_mobile_version){
        $resolution = $this::$DEFAULT_RESOLUTION['mobile_'.$this->image->orientation] ;
        $magicianObjMobile = new imageLib($this->image->url);
        $magicianObjMobile->resizeImage($resolution['width'],$resolution['height'],$this->image->orientation);
        $mobile_file_name = str_replace('.','',basename($this->image->url,$this->image->extension));
        $mobile_file_name = str_replace('-mobile','',$mobile_file_name);
        $mobile_file_name.= '-mobile.'.$this->image->extension;
        $this->image->url = str_replace(basename($this->image->url),$mobile_file_name,$this->image->url);
        $magicianObjMobile->saveImage($this->image->url);
        //chmod($this->image->url, 0775);
      }
   }
   public static function batch_resize($url)
   {
     $dir = new DirectoryIterator($url);
     foreach ($dir as $fileinfo) {

       $file_path = $fileinfo->getPathname();
       try {
          if(! $fileinfo->isDot())
           {
             $resizer = new ImageResizer($file_path);
             $create_mobile_version = true;
             $resizer->resize($create_mobile_version);
             echo '<span style="color:blue;font-family:monospace">Resize and generate mobile version -  '.$file_path.' Done.</span><br>';
           }

       } catch (Exception $e) {
         echo '<span style="color:red;font-family:arial">Resize and generate mobile version -  '.$file_path.' Fail.</span><br>';
       }
     }
   }
}
?>
