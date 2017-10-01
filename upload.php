<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 18-Dec-16
 * Time: 20:01
 */

require "vendor/autoload.php";

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

ini_set('max_execution_time', 300);

if(isset($_FILES)&&!empty($_FILES))
{
    $sourcePath = $_FILES['img']['tmp_name'];
    $targetDir = "uploaded/imgCnv".$_FILES['img']['name'];
    if(move_uploaded_file($sourcePath,$targetDir))
    {
        if(isset($_POST['filter'])&&!empty($_POST['filter']))
        {
            $filter=$_POST['filter'];
            if($filter=="none")
            {
                echo $targetDir;
            }
            if($filter=="sepia")
            {
                $im = imagecreatefromjpeg($targetDir);
                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 1; $x < $imgWidth-1; $x++) {
                    for ($y = 1; $y < $imgHeight - 1; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;

                        $new_r = intval($r * 0.393 + $g * 0.769 + $b * 0.189);
                        $new_g = intval($r * 0.349 + $g * 0.686 + $b * 0.168);
                        $new_b = intval($r * 0.272 + $g * 0.534 + $b * 0.131);

                        if($new_r > 255)
                        {
                            $new_r = 255;
                        }

                        if($new_g > 255)
                        {
                            $new_g = 255;
                        }

                        if($new_b > 255)
                        {
                            $new_b = 255;
                        }

                        $new_color  = imagecolorallocate($final,$new_r,$new_g,$new_b);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Sepia");

                echo $targetDir."Sepia";
            }
            if($filter=="blur")
            {
                $im = imagecreatefromjpeg($targetDir);
                imagefilter($im,IMG_FILTER_GAUSSIAN_BLUR);
                imagejpeg($im, $targetDir."Blur");

                echo $targetDir."Blur";


            }
            if($filter=="brighten")
            {
                $im = imagecreatefromjpeg($targetDir);
                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;

                        $factor = 40;

                        $r = $r + $factor;
                        $g = $g + $factor;
                        $b = $b + $factor;

                        if($r > 255)
                        {
                            $r = 255;
                        }

                        if($g > 255)
                        {
                            $g = 255;
                        }

                        if($b > 255)
                        {
                            $b = 255;
                        }

                        $new_color  = imagecolorallocate($final,$r,$g,$b);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Brighten");


                echo $targetDir."Brighten";
            }
            if($filter=="grayscale")
            {
                $im = imagecreatefromjpeg($targetDir);
                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;

                        $gray = ($r*0.3 + $g*0.59 + $b*0.11);

                        if($gray > 255)
                        {
                            $gray = 255;
                        }
                        if($gray < 0)
                        {
                            $gray = 0;
                        }

                        $new_gray  = imagecolorallocate($final,$gray,$gray,$gray);

                        imagesetpixel($final,$x,$y,$new_gray);
                    }
                }


                imagejpeg($final,$targetDir."Grayscale");

                echo $targetDir."Grayscale";
            }
            if($filter=="negative")
            {
                $im = imagecreatefromjpeg($targetDir);

                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;

                        $new_r = 255 - $r;
                        $new_g = 255 - $g;
                        $new_b = 255 - $b;

                        $new_color  = imagecolorallocate($final,$new_r,$new_g,$new_b);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Negative");

                echo $targetDir."Negative";
            }
            if($filter=="edges")
            {
                $im = imagecreatefromjpeg($targetDir);

                $im_data = getimagesize($targetDir);
                $final = imagecreatetruecolor($im_data[0],$im_data[1]);

                //funkcija za dobivanje na sivite nijansi
                function get_gray_shade($pixel){
                    $r = $pixel >> 16;
                    $g = $pixel >> 8 & 255;
                    $b = $pixel & 255;

                    return $r*0.30 + $g*0.59 + $b*0.11;

                }

                for($x = 1; $x < $im_data[0]-1; $x++){
                    for($y = 1; $y < $im_data[1]-1; $y++){
                        // Zemanje na okolnite pixeli
                        $pixel_up = get_gray_shade(imagecolorat($im,$x,$y-1));
                        $pixel_down = get_gray_shade(imagecolorat($im,$x,$y+1));
                        $pixel_left = get_gray_shade(imagecolorat($im,$x-1,$y));
                        $pixel_right = get_gray_shade(imagecolorat($im,$x+1,$y));
                        $pixel_up_left = get_gray_shade(imagecolorat($im,$x-1,$y-1));
                        $pixel_up_right = get_gray_shade(imagecolorat($im,$x+1,$y-1));
                        $pixel_down_left = get_gray_shade(imagecolorat($im,$x-1,$y+1));
                        $pixel_down_right = get_gray_shade(imagecolorat($im,$x+1,$y+1));

                        // Presmetka na dvete konvoluciski maski
                        $conv_x = ($pixel_up_right+($pixel_right*2)+$pixel_down_right)-($pixel_up_left+($pixel_left*2)+$pixel_down_left);
                        $conv_y = ($pixel_down_left+($pixel_down*2)+$pixel_down_right)-($pixel_up_left+($pixel_up*2)+$pixel_up_right);

                        // Menhatanova distanca
                        $gray = abs($conv_x)+abs($conv_y);

                        //invertiranje na distancata da ne se dobie Negative slika
                        $gray = 255-$gray;

                        // Doveduvanje na vrednostite vo opseg [0,255]
                        if($gray > 255){
                            $gray = 255;
                        }
                        if($gray < 0){
                            $gray = 0;
                        }

                        $new_gray  = imagecolorallocate($final,$gray,$gray,$gray);

                        imagesetpixel($final,$x,$y,$new_gray);
                    }
                }

                imagejpeg($final,$targetDir."edges");


                echo $targetDir."edges";
            }

            if($filter=="colorExt")
            {
                $palette = Palette::fromFilename($targetDir);
                $counter=0;
                $topFiveArray=array();
                // $palette e iterator na boi sortiram po broj na pixeli
                array_push($topFiveArray,$targetDir);
                foreach($palette as $color => $count) {
                    // boite se reprezentiraat vo integer
                    Color::fromIntToHex($color);
                }

                $topFive = $palette->getMostUsedColors(5);

                // $extractor se gradi od paletata
                $extractor = new ColorExtractor($palette);

                // ova e metod koj gi vraka najzastapenite x boi
                $colors = $extractor->extract(12);

                foreach ($colors as $clr)
                {
                    array_push($topFiveArray,Color::fromIntToHex($clr));
                }

                echo json_encode($topFiveArray);
            }
            if($filter=="red")
            {
                $im = imagecreatefromjpeg($targetDir);

                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;


                        $new_color  = imagecolorallocate($final,$r,$r,$r);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Red");



                echo $targetDir."Red";
            }
            if($filter=="green")
            {
                $im = imagecreatefromjpeg($targetDir);

                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;


                        $new_color  = imagecolorallocate($final,$g,$g,$g);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Green");



                echo $targetDir."Green";
            }
            if($filter=="blue")
            {
                $im = imagecreatefromjpeg($targetDir);

                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;


                        $new_color  = imagecolorallocate($final,$b,$b,$b);

                        imagesetpixel($final,$x,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Blue");



                echo $targetDir."Blue";
            }
            if($filter == "mirror")
            {
                $im = imagecreatefromjpeg($targetDir);

                $imgSize = getimagesize($targetDir);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];

                $final = imagecreatetruecolor($imgWidth,$imgHeight);

                for($x = 0; $x < $imgWidth; $x++) {
                    for ($y = 0; $y < $imgHeight; $y++) {
                        $pixel = imagecolorat($im,$x,$y);

                        $r = $pixel >> 16;
                        $g = $pixel >> 8 & 255;
                        $b = $pixel & 255;


                        $new_color  = imagecolorallocate($final,$r,$g,$b);

                        imagesetpixel($final,$imgWidth - $x - 1,$y,$new_color);
                    }
                }


                imagejpeg($final,$targetDir."Mirror");



                echo $targetDir."Mirror";
            }
        }
    }
}
else
{
    echo "Upload failed";
}

if(isset($_POST['src'])&&!empty($_POST['src']))
{
    $source=$_POST['src'];

    header('Content-type: image/*');

    header('Content-Disposition: attachment; filename="'.$source.'"');

    readfile($source);

}

?>