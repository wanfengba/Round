    <ul class="flex clearfix" id="nav_menu">
        <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
            <?php $this->widget('Widget_Contents_Page_List')
               ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
        <?php if ($this->options->menu_list) : ?>
            <li class="nav-list-wrapper" Mist-left>
                <a href="<?php echo explode("||", $this->options->menu_list)[1]; ?>" ><?php echo explode("||", $this->options->menu_list)[0]; ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    
    <footer class="footer-wrapper part mt-3" Round-footer>
        <div class="powered_by">
            <p>typecho - <?php echo _themes(); ?> - <?php echo date('Y'); ?> </p>
                <!--加载时间-->
            <p>本页加载耗时： <?php echo timer_stop();?>；</p>
            <?php if ($this->options->Atongji) : ?><p>本站统计表： <?php $this->options->Atongji() ?>；</p><?php endif; ?>
            <?php if ($this->options->ABirthDay) : ?>
            <div class="item run">
                <span>本站已运行：<strong class="Alley_run__day">00</strong> 天 <strong class="Alley_run__hour">00</strong> 时 <strong class="Alley_run__minute">00</strong> 分 <strong class="Alley_run__second">00</strong> 秒</span>；
            </div>
            <?php endif; ?>
            <p>Copyright © &Developed by <?php $this->options->title() ?> <?php echo date('Y'); ?></p>
        </div>
        
    </footer>
    
    <script>
    <?php $this->options->ACustomScript() ?>
    </script>
    <?php $this->options->ACustomBodyEnd() ?>
    <?php $this->footer(); ?>
    </body>
</html>