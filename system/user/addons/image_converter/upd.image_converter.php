<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Image Automizer Update File
 *
 * @category   Module
 * @package    ExpressionEngine
 * @subpackage Addons
 * @author     0to9 Digital - Robin Treur
 * @link       https://0to9.nl
 */

class Image_converter_upd
{

    var $version = '1.0.0';
    var $module_name = "Image_converter";

    /**
     * @var Devkit_code_completion
     */
    public $EE;

    function __construct($switch = TRUE)
    {
        // Make a local reference to the ExpressionEngine super object
        $this->EE = get_instance();
    }

    /**
     * Installer for the Seo_lite module
     */
    function install()
    {
        $data = array(
            'module_name'       => $this->module_name,
            'module_version'    => $this->version,
            'has_cp_backend'    => 'n',
            'has_publish_fields' => 'n'
        );

        $this->EE->db->insert('modules', $data);

        return TRUE;
    }


    /**
     * Uninstall the Seo_lite module
     */
    function uninstall()
    {
        // NOTHING TO DELETE YET
        return TRUE;
    }

    /**
     * Update the Image_converter module
     *
     * @param $current current version number
     * @return boolean indicating whether or not the module was updated
     */
    function update($current = '')
    {
        if ($current == $this->version) {
            return FALSE;
        }

        // NOTHING TO UPDATE YET
        return TRUE;
    }
}

/* End of file upd.image_converter.php */
