<?php
$image = imagecreatefrompng('https://media.discordapp.net/attachments/842590159987408957/899861278925946951/Untitled-1.png?width=468&height=468');
$source = imagescale($image , 500, 500);
$mask = imagecreatefrompng( '2.png' );
imagealphamask( $source, $mask );
imagepng($source, "recorte.png");

$image_1 = imagecreatefrompng('disco500.png');
$image_2 = imagecreatefrompng('recorte.png');
imagealphablending($image_1, true);
imagesavealpha($image_1, true);
imagecopy($image_1, $image_2, 0, 0, 0, 0, 500, 500);
imagepng($image_1, 'resultado.png');
unlink('recorte.png');

function imagealphamask( &$picture, $mask ) {

    $xSize = imagesx( $picture );
    $ySize = imagesy( $picture );
    $newPicture = imagecreatetruecolor( $xSize, $ySize );
    imagesavealpha( $newPicture, true );
    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

    if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
        $tempPic = imagecreatetruecolor( $xSize, $ySize );
        imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
        imagedestroy( $mask );
        $mask = $tempPic;
    }

    for( $x = 0; $x < $xSize; $x++ ) {
        for( $y = 0; $y < $ySize; $y++ ) {
            $alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
            $alpha = 127 - floor( $alpha[ 'red' ] / 2 );
            $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
            imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
        }
    }

    imagedestroy( $picture );
    $picture = $newPicture;
}

?>