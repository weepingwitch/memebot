<?php


// for word wrapping
// stolen from http://stackoverflow.com/a/16149956
function wrap($fontSize, $fontFace, $string, $width) {
    $ret = "";
    $arr = explode(" ", $string);
    foreach ( $arr as $word ){
      $testboxWord = imagettfbbox($fontSize, 0, $fontFace, $word);
      $len = strlen($word);
      while ( $testboxWord[2] > $width && $len > 0) {
        $word = substr($word, 0, $len);
        $len--;
        $testboxWord = imagettfbbox($fontSize, 0, $fontFace, $word);
      }
      $teststring = $ret.' '.$word;
      $testboxString = imagettfbbox($fontSize, 0, $fontFace, $teststring);
      if ( $testboxString[2] > $width ){
        $ret.=($ret==""?"":"\n").$word;
       } else {
         $ret.=($ret==""?"":' ').$word;
      }
    }
  return $ret;
}

// for image resizing
// stolen from http://stackoverflow.com/a/14649689
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dst;
}


// set the overall meme size
$canvas_w = 350;
$canvas_h = 400;

// Create the image
$im = imagecreatetruecolor($canvas_w, $canvas_h);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);

// fill the image
imagefill($im, 0, 0, $white);

// load our sub image
$file = "img/" . rand(1,7) . ".jpg";
error_log($file);
$subimg = resize_image($file, 300,300);

// calculate some values
$img_w = imagesx($subimg);
$img_h = imagesy($subimg);
$xoffset = ($canvas_w - $img_w) / 2;
$yoffset = ($canvas_h - $img_h);
$yoffset = $yoffset - 50;

// draw an outline
imagefilledrectangle($im, $xoffset - 1, $yoffset - 1, $img_w +$xoffset, $img_h + $yoffset, $black);

imagecopy($im, $subimg, $xoffset, $yoffset, 0,0,$img_w, $img_h);


// set up the font
$font = '/var/www/html/tuftsmemebot/comicsans.ttf';

// The text to draw
$text = "hello world";
$text = wrap(20,$font, $text, 500);

// Add the text
imagettftext($im, 15, 0,10 ,30, $black, $font, $text);

// get the random image



// Set the content-type
header('Content-Type: image/png');

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?>
