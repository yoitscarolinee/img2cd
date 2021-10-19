<?php
// Load source and mask
$image = imagecreatefrompng('exemplo.png');
$source = imagescale($image , 500, 500);


$mask = imagecreatefrompng( '2.png' );
// Apply mask to source
imagealphamask( $source, $mask );
// Output
imagepng($source, "recorte.png");

$image_1 = imagecreatefrompng('disco500.png');
$image_2 = imagecreatefrompng('recorte.png');
imagealphablending($image_1, true);
imagesavealpha($image_1, true);
imagecopy($image_1, $image_2, 0, 0, 0, 0, 500, 500);
imagepng($image_1, 'resultado.png');



















function imagealphamask( &$picture, $mask ) {
    // Get sizes and set up new picture
    $xSize = imagesx( $picture );
    $ySize = imagesy( $picture );
    $newPicture = imagecreatetruecolor( $xSize, $ySize );
    imagesavealpha( $newPicture, true );
    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

    // Resize mask if necessary
    if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
        $tempPic = imagecreatetruecolor( $xSize, $ySize );
        imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
        imagedestroy( $mask );
        $mask = $tempPic;
    }

    // Perform pixel-based alpha map application
    for( $x = 0; $x < $xSize; $x++ ) {
        for( $y = 0; $y < $ySize; $y++ ) {
            $alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
            $alpha = 127 - floor( $alpha[ 'red' ] / 2 );
            $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
            imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
        }
    }

    // Copy back to original picture
    imagedestroy( $picture );
    $picture = $newPicture;
}

?>