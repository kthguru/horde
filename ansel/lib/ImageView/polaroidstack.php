<?php
/**
 * ImageView to create the gallery polaroid stacks.
 *
 * @author Michael J. Rubinsky <mrubinsk@horde.org>
 * @package Ansel
 */
class Ansel_ImageView_polaroidstack extends Ansel_ImageView {

    var $need = array('PhotoStack');

    function _create()
    {
        $imgobjs = array();
        $images = $this->_getStackImages();
        $style = $this->_params['style'];
        foreach ($images as $image) {
            $result = $image->load('screen');
            if (is_a($result, 'PEAR_Error')) {
                return $result;
            }
            $imgobjs[] = $image->_image;
        }

        $params = array('width' => 100,
                        'height' => 100,
                        'background' => $style['background']);

        $baseImg = Ansel::getImageObject($params);
        $result = $baseImg->addEffect(
            'PhotoStack',
            array('images' => $imgobjs,
                  'resize_height' => $GLOBALS['conf']['thumbnail']['height'],
                  'padding' => 10,
                  'background' => $style['background'],
                  'type' => 'polaroid'));

        $baseImg->applyEffects();
        if (is_a($result, 'PEAR_Error')) {
            return $result;
        }

        $baseImg->resize($GLOBALS['conf']['thumbnail']['width'],
                         $GLOBALS['conf']['thumbnail']['height']);

        return $baseImg;

    }

}
