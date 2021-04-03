<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
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
        'css/responsive.css',
        'css/jquery.mCustomScrollbar.css',
        'css/select2/select2.min.css'
    ];
    public $js = [
        'js/inspinia.js',
        'js/clickable-row.js',
        'js/plugins/pace/pace.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/iCheck/icheck.min.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/plugins/footable/footable.min.js',
        'js/plugins/summernote/summernote.min.js',
        'js/plugins/toastr/toastr.min.js',
        'js/tabs.js',
        'js/clear-form.js',
        'js/navbar-minimalize.js',
        'js/jquery.mCustomScrollbar.concat.min.js',
        'js/plugins/select2/select2.full.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}