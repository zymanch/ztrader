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
use yii\web\JsExpression;

class Tooltip implements Config {

    use Create;
    use ClearArray;

    protected $_isEnabled;
    protected $_mode;
    protected $_isIntersect;
    protected $_position;
    protected $_onItemSort;
    protected $_onFilter;
    protected $_backgroundColor;
    protected $_titleFontFamily;
    protected $_titleFontSize;
    protected $_titleFontStyle;
    protected $_titleFontColor;
    protected $_titleSpacing;
    protected $_titleMarginBottom;
    protected $_bodyFontFamily;
    protected $_bodyFontSize;
    protected $_bodyFontStyle;
    protected $_bodyFontColor;
    protected $_bodySpacing;
    protected $_footerFontFamily;
    protected $_footerFontSize;
    protected $_footerFontStyle;
    protected $_footerFontColor;
    protected $_footerSpacing;
    protected $_footerMarginTop;
    protected $_xPadding;
    protected $_yPadding;
    protected $_caretPadding;
    protected $_caretSize;
    protected $_cornerRadius;
    protected $_multiKeyBackground;
    protected $_isDisplayColors;
    protected $_borderColor;
    protected $_borderWidth;
    protected $_onBeforeTitle;
    protected $_onTitle;
    protected $_onAfterTitle;
    protected $_onBeforeBody;
    protected $_onBeforeLabel;
    protected $_onLabel;
    protected $_onLabelColor;
    protected $_onLabelTextColor;
    protected $_onAfterLabel;
    protected $_onAfterBody;
    protected $_onBeforeFooter;
    protected $_onFooter;
    protected $_onAfterFooter;
    protected $_onCustom;

    public function getConfiguration($labels, $datasets) {

        $axeConfig = [
            'enabled' => $this->_isEnabled,
            'custom' => $this->_onCustom,
            'mode' => $this->_mode,
            'intersect' => $this->_isIntersect,
            'position' => $this->_position,
            'callbacks' => [
                'beforeTitle' => $this->_onBeforeTitle,
                'title' => $this->_onTitle,
                'afterTitle' => $this->_onAfterTitle,
                'beforeBody' => $this->_onBeforeBody,
                'beforeLabel' => $this->_onBeforeLabel,
                'label' => $this->_onLabel,
                'labelColor' => $this->_onLabelColor,
                'labelTextColor' => $this->_onLabelTextColor,
                'afterLabel' => $this->_onAfterLabel,
                'afterBody' => $this->_onAfterBody,
                'beforeFooter' => $this->_onBeforeFooter,
                'footer' => $this->_onFooter,
                'afterFooter' => $this->_onAfterFooter,
            ],
            'itemSort' => $this->_onItemSort,
            'filter' => $this->_onFilter,
            'backgroundColor' => $this->_backgroundColor,
            'titleFontFamily' => $this->_titleFontFamily,
            'titleFontSize' => $this->_titleFontSize,
            'titleFontStyle' => $this->_titleFontStyle,
            'titleFontColor' => $this->_titleFontColor,
            'titleSpacing' => $this->_titleSpacing,
            'titleMarginBottom' => $this->_titleMarginBottom,
            'bodyFontFamily' => $this->_bodyFontFamily,
            'bodyFontSize' => $this->_bodyFontSize,
            'bodyFontStyle' => $this->_bodyFontStyle,
            'bodyFontColor' => $this->_bodyFontColor,
            'bodySpacing' => $this->_bodySpacing,
            'footerFontFamily' => $this->_footerFontFamily,
            'footerFontSize' => $this->_footerFontSize,
            'footerFontStyle' => $this->_footerFontStyle,
            'footerFontColor' => $this->_footerFontColor,
            'footerSpacing' => $this->_footerSpacing,
            'footerMarginTop' => $this->_footerMarginTop,
            'xPadding' => $this->_xPadding,
            'yPadding' => $this->_yPadding,
            'caretPadding' => $this->_caretPadding,
            'caretSize' => $this->_caretSize,
            'cornerRadius' => $this->_cornerRadius,
            'multiKeyBackground' => $this->_multiKeyBackground,
            'displayColors' => $this->_isDisplayColors,
            'borderColor' => $this->_borderColor,
            'borderWidth' => $this->_borderWidth,
        ];
        return  ['tooltips' => $this->_clearArray($axeConfig)];

    }

    /**
     * @return $this
     */
    public function enable() {
        $this->_isEnabled = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disable() {
        $this->_isEnabled = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $mode
     */
    public function setMode($mode) {
        $this->_mode = $mode;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableIntersect() {
        $this->_isIntersect = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableIntersect() {
        $this->_isIntersect = false;
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
     * @param mixed $onItemSort
     */
    public function onItemSort($onItemSort) {
        if ($onItemSort) {
            $this->_onItemSort = new JsExpression($onItemSort);
        } else {
            $this->_onItemSort = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onFilter
     */
    public function onFilter($onFilter) {
        if ($onFilter) {
            $this->_onFilter = new JsExpression($onFilter);
        } else {
            $this->_onFilter = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $backgroundColor
     */
    public function setBackgroundColor($backgroundColor) {
        $this->_backgroundColor = $backgroundColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleFontFamily
     */
    public function setTitleFontFamily($titleFontFamily) {
        $this->_titleFontFamily = $titleFontFamily;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleFontSize
     */
    public function setTitleFontSize($titleFontSize) {
        $this->_titleFontSize = $titleFontSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleFontStyle
     */
    public function setTitleFontStyle($titleFontStyle) {
        $this->_titleFontStyle = $titleFontStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleFontColor
     */
    public function setTitleFontColor($titleFontColor) {
        $this->_titleFontColor = $titleFontColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleSpacing
     */
    public function setTitleSpacing($titleSpacing) {
        $this->_titleSpacing = $titleSpacing;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $titleMarginBottom
     */
    public function setTitleMarginBottom($titleMarginBottom) {
        $this->_titleMarginBottom = $titleMarginBottom;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $bodyFontFamily
     */
    public function setBodyFontFamily($bodyFontFamily) {
        $this->_bodyFontFamily = $bodyFontFamily;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $bodyFontSize
     */
    public function setBodyFontSize($bodyFontSize) {
        $this->_bodyFontSize = $bodyFontSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $bodyFontStyle
     */
    public function setBodyFontStyle($bodyFontStyle) {
        $this->_bodyFontStyle = $bodyFontStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $bodyFontColor
     */
    public function setBodyFontColor($bodyFontColor) {
        $this->_bodyFontColor = $bodyFontColor;
        return $this;
    }


    /**
     * @return $this
     * @param mixed $bodySpacing
     */
    public function setBodySpacing($bodySpacing) {
        $this->_bodySpacing = $bodySpacing;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerFontFamily
     */
    public function setFooterFontFamily($footerFontFamily) {
        $this->_footerFontFamily = $footerFontFamily;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerFontSize
     */
    public function setFooterFontSize($footerFontSize) {
        $this->_footerFontSize = $footerFontSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerFontStyle
     */
    public function setFooterFontStyle($footerFontStyle) {
        $this->_footerFontStyle = $footerFontStyle;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerFontColor
     */
    public function setFooterFontColor($footerFontColor) {
        $this->_footerFontColor = $footerFontColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerSpacing
     */
    public function setFooterSpacing($footerSpacing) {
        $this->_footerSpacing = $footerSpacing;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $footerMarginTop
     */
    public function setFooterMarginTop($footerMarginTop) {
        $this->_footerMarginTop = $footerMarginTop;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $xPadding
     */
    public function setXPadding($xPadding) {
        $this->_xPadding = $xPadding;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $yPadding
     */
    public function setYPadding($yPadding) {
        $this->_yPadding = $yPadding;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $caretPadding
     */
    public function setCaretPadding($caretPadding) {
        $this->_caretPadding = $caretPadding;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $caretSize
     */
    public function setCaretSize($caretSize) {
        $this->_caretSize = $caretSize;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $cornerRadius
     */
    public function setCornerRadius($cornerRadius) {
        $this->_cornerRadius = $cornerRadius;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $multiKeyBackground
     */
    public function setMultiKeyBackground($multiKeyBackground) {
        $this->_multiKeyBackground = $multiKeyBackground;
        return $this;
    }

    /**
     * @return $this
     */
    public function showColors() {
        $this->_isDisplayColors = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function hideColors() {
        $this->_isDisplayColors = false;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $borderColor
     */
    public function setBorderColor($borderColor) {
        $this->_borderColor = $borderColor;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $borderWidth
     */
    public function setBorderWidth($borderWidth) {
        $this->_borderWidth = $borderWidth;
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onBeforeTitle
     */
    public function onBeforeTitle($onBeforeTitle) {
        if ($onBeforeTitle) {
            $this->_onBeforeTitle = new JsExpression($onBeforeTitle);
        } else {
            $this->_onBeforeTitle = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onTitle
     */
    public function onTitle($onTitle) {
        if ($onTitle) {
            $this->_onTitle = new JsExpression($onTitle);
        } else {
            $this->_onTitle = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onAfterTitle
     */
    public function onAfterTitle($onAfterTitle) {
        if ($onAfterTitle) {
            $this->_onAfterTitle = new JsExpression($onAfterTitle);
        } else {
            $this->_onAfterTitle =  null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onBeforeBody
     */
    public function onBeforeBody($onBeforeBody) {
        if ($onBeforeBody) {
            $this->_onBeforeBody = new JsExpression($onBeforeBody);
        } else {
            $this->_onBeforeBody = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onBeforeLabel
     */
    public function onBeforeLabel($onBeforeLabel) {
        if ($onBeforeLabel) {
            $this->_onBeforeLabel = new JsExpression($onBeforeLabel);
        } else {
            $this->_onBeforeLabel = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onLabel
     */
    public function onLabel($onLabel) {
        if ($onLabel) {
            $this->_onLabel = new JsExpression($onLabel);
        } else {
            $this->_onLabel = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onLabelColor
     */
    public function onLabelColor($onLabelColor) {
        if ($onLabelColor) {
            $this->_onLabelColor = new JsExpression($onLabelColor);
        } else {
            $this->_onLabelColor = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onLabelTextColor
     */
    public function onLabelTextColor($onLabelTextColor) {
        if ($onLabelTextColor) {
            $this->_onLabelTextColor = new JsExpression($onLabelTextColor);
        } else {
            $this->_onLabelTextColor = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onAfterLabel
     */
    public function onAfterLabel($onAfterLabel) {
        if ($onAfterLabel) {
            $this->_onAfterLabel = new JsExpression($onAfterLabel);
        } else {
            $this->_onAfterLabel = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onAfterBody
     */
    public function onAfterBody($onAfterBody) {
        if ($onAfterBody) {
            $this->_onAfterBody = new JsExpression($onAfterBody);
        } else {
            $this->_onAfterBody = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onBeforeFooter
     */
    public function onBeforeFooter($onBeforeFooter) {
        if ($onBeforeFooter) {
            $this->_onBeforeFooter = new JsExpression($onBeforeFooter);
        } else {
            $this->_onBeforeFooter = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onFooter
     */
    public function onFooter($onFooter) {
        if ($onFooter) {
            $this->_onFooter = new JsExpression($onFooter);
        } else {
            $this->_onFooter = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onAfterFooter
     */
    public function onAfterFooter($onAfterFooter) {
        if ($onAfterFooter) {
            $this->_onAfterFooter = new JsExpression($onAfterFooter);
        } else {
            $this->_onAfterFooter = null;
        }
        return $this;
    }

    /**
     * @return $this
     * @param mixed $onCustom
     */
    public function onCustom($onCustom) {
        if ($onCustom) {
            $this->_onCustom = new JsExpression($onCustom);
        } else {
            $this->_onCustom = null;
        }
        return $this;
    }

    public function enabledPredefinedTooltip($showDayInsteadName = false) {
        $callback = 'function(tooltipItem, data){
            var result = "",
                tooltipFormat = data.datasets[tooltipItem.datasetIndex][\'tooltipFormat\'],
                tooltipCallback = data.datasets[tooltipItem.datasetIndex][\'tooltipCallback\'],
                dataset = data.datasets[tooltipItem.datasetIndex],
                tooltip = dataset[\'tooltip\'][tooltipItem.index],
                name = typeof tooltipCallback !== "undefined" ?
                    tooltipCallback(tooltip[0]) : 
                    '.($showDayInsteadName ? 'tooltip[0]':'dataset["label"]').',
                value = tooltip[1];
            if (typeof tooltipFormat === "undefined") {
                tooltipFormat = "{name}: {value}";
            }    
            result = tooltipFormat.split("{name}").join(name).split("{value}").join(value);
            if (tooltip.length >=3) {
                result+=" ("+tooltip[2]+")";
            }
            return result;    
        }';
        $this->_onLabel = new JsExpression($callback);
        if ($showDayInsteadName) {
            $this->_onTitle = new JsExpression('function(tooltipModel){
                return "";
            }');
        }
        return $this;
    }

    public function disablePredefinedTooltip() {
        $this->_onLabel = null;
        return $this;
    }

    public function enableOneBigTooltip() {
        //$options['hover']['mode'] = 'nearest';
        //$options['hover']['intersect'] = true;

        $this->_mode = 'index';
        $this->_isIntersect = false;
        return $this;
    }
}