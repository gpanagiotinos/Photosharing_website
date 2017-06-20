<?php

class Image {
   
   private $image;
   private $image_type;
   private $thumbImage;
 
   public function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info['mime'];

      if( $this->image_type == 'image/jpeg' ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == 'image/png' ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   public function save($filename, $image_type='image/jpeg', $compression=COMPRESSION) {
      if( $image_type == 'image/jpeg' ) {
         return imagejpeg($this->image, $filename, $compression);
      } elseif( $image_type == 'image/png' ) {
         return imagepng($this->image, $filename);
      }   
   }
   public function saveThumb($filename, $image_type='image/jpeg', $compression=COMPRESSION) {
      if( $image_type == 'image/jpeg' ) {
         return imagejpeg($this->thumbImage, $filename, $compression);
      } elseif( $image_type == 'image/png' ) {
         return imagepng($this->thumbImage, $filename);
      }   
   }

   public function setPermissions($permissions = null)
   {
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   public function getSize($filename)
   {
      return filesize($filename);
   }
   public function output($image_type = 'image/jpeg') {
      if( $image_type == 'image/jpeg' ) {
         imagejpeg($this->thumbImage, null, COMPRESSION);
      } elseif( $image_type == 'image/png' ) {
         imagepng($this->thumbImage);
      }   
   }
   public function getWidth() {
      return imagesx($this->image);
   }
   public function getHeight() {
      return imagesy($this->image);
   }
   public function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   public function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getHeight() * $ratio;
      $this->resize($width,$height);
   }
   public function crop($thumb_size = 250, $crop_percent = .5, $image_type = 'image/jpeg')
   {
      //get the image dimensions
      $width = $this->getWidth();
      $height = $this->getHeight();
      //set the biggest dimension
      if($width > $height)
      {
         $biggest = $width;
      }else{
         $biggest = $height;
      }
      //init the crop dimension based on crop_percent
      $cropSize = $biggest * $crop_percent;
      //get the crop cordinates
      $x = ($width - $cropSize) / 2;
      $y = ($height - $cropSize) / 2;

      //create the final thumnail
      $this->thumbImage = imagecreatetruecolor($thumb_size, $thumb_size);
      //fill background with white
      $bgc = imagecolorallocate($this->thumbImage, 255, 255, 255);
      imagefilledrectangle($this->thumbImage, 0, 0, $thumb_size, $thumb_size, $bgc);
      
      imagecopyresampled($this->thumbImage, $this->image, 0, 0, $x, $y, $thumb_size, $thumb_size, $cropSize, $cropSize );
   }

   public function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   public function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }  
   public function destroy()
   {
      imagedestroy($this->image);
   }    
}