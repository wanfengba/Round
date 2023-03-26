    <script>
    function checkDebugger(){var d=new Date();debugger;var dur=Date.now()-d;if(dur<5){return false}else{return true}}function breakDebugger(){if(checkDebugger()){breakDebugger()}};breakDebugger();
    </script>
    <script src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/main.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/short.min.js'); ?>">"></script>
    <script src="<?php $this->options->themeUrl('assets/js/view-image.min.js'); ?>">"></script>
    <script>
        window.ViewImage && ViewImage.init('.post img');
    </script>
    <?php
    $fontUrl = $this->options->ACustomFont;
    if (strpos($fontUrl, 'woff2') !== false) $fontFormat = 'woff2';
    elseif (strpos($fontUrl, 'woff') !== false) $fontFormat = 'woff';
    elseif (strpos($fontUrl, 'ttf') !== false) $fontFormat = 'truetype';
    elseif (strpos($fontUrl, 'eot') !== false) $fontFormat = 'embedded-opentype';
    elseif (strpos($fontUrl, 'svg') !== false) $fontFormat = 'svg';
    ?>
    
    <style type="text/css">
    @import url("<?php _getAssets('assets/css/min.css'); ?>");
    @import url("<?php _getAssets('assets/owo/owo.min.css'); ?>");
    @import url("//at.alicdn.com/t/c/font_3927872_0lum7d0bmqkg.css");
    <?php $this->options->ACustomCSS() ?>
    <?php if(Helper::options()->ACustomFont): ?>
        @font-face {
            font-family: 'wodeziti-1';
            font-weight: 400;
            font-style: normal;
            font-display: swap;
            src: url('<?php echo $fontUrl ?>');
            <?php if ($fontFormat) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
            <?php endif; ?>
        }
    <?php else: ?>
        @font-face {
            font-family:"wodeziti-1";
            src:url('<?php $this->options->themeUrl('assets/font/SanJiWenYuanJianTi-2.ttf'); ?>');
            font-display:swap;
        }
    <?php endif; ?>
    </style>
    