<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrapXL.css',
        'css/animate.css',
        'css/footable/footable.bootstrap.min.css',
        'css/iCheck/custom.css',
        'css/toastr/toastr.min.css',
        'font-awesome/css/font-awesome.css',
        'css/datepicker/datepicker3.css',
        'css/summernote/summernote.css',
        'css/summernote/summernote-bs3.css',
        'css/inspinia.css',
        'css/site.css',
        'css/admin.css',
        'css/responsive.css',
        'css/jquery.mCustomScrollbar.css',
        'css/select2/select2.min.css'
    ];
    public $js = [
        'js/plugins/fullcalendar/moment.min.js',
        'js/plugins/daterangepicker/daterangepicker.js',
        'js/admin/filter.js',
        'js/plugins/toastr/toastr.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}