<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets\graph\config;

use app\widgets\graph\contract\Config;
use backend\traits\ClearArray;
use backend\traits\Create;

class Title implements Config {

    use Create;
    use ClearArray;


    private $_display;
    private $_fontSize;
    private $_position;
    private $_fontFamily;
    private $_fontColor;
    private $_fontStyle;
    private $_padding;
    private $_lineHeight;
    private $_text;

    public function getConfiguration($labels, $datasets) {

        $axeConfig = [
            'display' => $this->_display,
            'position' => $this->_position,
            'fontSize' => $this->_fontSize,
            'fontFamily' => $this->_fontFamily,
            'fontColor' => $this->_fontColor,
            'fontStyle' => $this->_fontStyle,
            'padding' => $this->_padding,
            'lineHeight' => $this->_lineHeight,
            'text' => $this->_text,
        ];
        return  $this->_clearArray($axeConfig);

    }

    /**
     * @return $this
     */
    public function show() {
        $this->_display = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function hide() {
        $this->_display = false;
        return $this;
    }
    /**
     * @return $this
     * @param mixed $fontSize
     */
    public function setFontSize($fontSize) {
        $this->_fontSize = $fontSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $position
     */
    public function setPosition($position) {
        $this->_position = $position;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $fontFamily
     */
    public function setFontFamily($fontFamily) {
        $this->_fontFamily = $fontFamily;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $fontColor
     */
    public function setFontColor($fontColor) {
        $this->_fontColor = $fontColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $fontStyle
     */
    public function setFontStyle($fontStyle) {
        $this->_fontStyle = $fontStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $padding
     */
    public function setPadding($padding) {
        $this->_padding = $padding;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $lineHeight
     */
    public function setLineHeight($lineHeight) {
        $this->_lineHeight = $lineHeight;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $text
     */
    public function setText($text) {
        $this->_text = $text;
        return $this;
    }

}