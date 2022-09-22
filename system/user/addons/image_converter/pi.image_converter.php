<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Image Automizer Plugin
 *
 * @category   Plugins
 * @package    ExpressionEngine
 * @subpackage Addons
 * @author     0to9 Digital - Robin Treur
 * @link       https://0to9.nl
 */

class Image_converter
{
    public $return_data = '';

    public function __construct()
    {
        $file = ee()->TMPL->fetch_param('file');
        $quality = ee()->TMPL->fetch_param('quality');
        $width = ee()->TMPL->fetch_param('width');
        $height = ee()->TMPL->fetch_param('height');

        $this->return_data = $this->generate_webp_image($file, $quality, $width, $height);
    }

    public function generate_webp_image($file, $compression_quality, $new_width = '', $new_height = '') {
        $new_file_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/image_converter/';
        $file_parts = pathinfo($file);
        $file_name = $file_parts['basename'];

        if(!file_exists($file)) {
            $new_file = $new_file_path . $file_name;
            copy($file, $new_file);
        } else {
            $new_file = $file;
        }

        // If output file already exists return path
        $output_file = $new_file_path . $file_name . '_h_' . $new_height . 'w_' . $new_width . '.webp';
        if (file_exists($output_file)) {
            return $output_file;
        }

        $file_type = strtolower(pathinfo($new_file)['extension']);

        if (function_exists('imagewebp')) {
            switch ($file_type) {
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($new_file);

                    break;
                case 'png':
                    $image = imagecreatefrompng($new_file);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;
                default:
                    return $file;
            }

            if($new_width && $new_height) {
                list($width, $height) = getimagesize($new_file);
                $resize_width = $new_width > $new_height ? $new_width : ($new_height / $height) * $width;
                $resize_height = $new_height > $new_width ? $new_height : ($new_width / $width) * $height;
                $resized = imagecreatetruecolor($resize_width, $resize_height);
                $cropped = imagecreatetruecolor($new_width, $new_height);
                imagecopyresized($resized, $image, 0, 0, 0, 0, $resize_width, $resize_height, $width, $height);
                imagecopy($cropped, $resized, 0, 0, ($resize_width) / 2 - ($new_width / 2), ($resize_height / 2) - ($new_height / 2), $new_width, $new_height);
            } else {
                $cropped = $image;
            }

            // Save image
            $result = imagewebp($cropped, $output_file, $compression_quality);
            if (false === $result) {
                return $file;
            }

            // Free up memory
            imagedestroy($image);

            return $output_file;
        } else {
            return $file;
        }
    }
}

/* End of file pi.image_converter.php */
