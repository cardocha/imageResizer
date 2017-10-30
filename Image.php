<?php
  class Image {
   public $url;
   public $height;
   public $width;
   public $orientation;
   public $extension;

   public function is_landscape()
   {
     return $this->orientation === "landscape";
   }

  }

 ?>
