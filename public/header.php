    <div class="nav" Round_header>
        <div class="header-banner" Round_header>
            <div class="flex al_center space-between">
                <div class="flex al_center">
                    <a href="/" class="pc-logo" Round_header>
                        <div class="logo flex al_center" Round_header>
                            <?php if(Helper::options()->Alogo): ?>
                            <img width="56" src="<?php $this->options->Alogo() ?>" Round_header>
                            <?php else: ?>
                            <img width="56" src="<?php $this->options->themeUrl('assets/images/za/1.png'); ?>" Round_header>
                            <?php endif; ?>
                            <?php if(Helper::options()->Alogotext): ?>
                            <div class="title" Round_header><?php $this->options->Alogotext() ?></div>
                            <?php else: ?>
                            <div class="title" Round_header>尘落</div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="mobile-logo">
                        <i class="iconfont icon-menu-fold"></i>
                    </div>
                    <ul class="flex clearfix">
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
                </div>
                
                <div class="flex al_center">
                    <div class="submit" Round_header>
                        <form method="post" action="">
                            <input type="text" name="s" class="text submit" size="32" placeholder="搜索" /> <button class="submit" />搜索</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div id="percentageCounter"></div>
    <header class="wrapper_header part hidden">
        <?php if(Helper::options()->AThumbnail): ?>
            <div  class="top_style" style="--image: url(<?php $this->options->AThumbnail() ?>)" Round_header>
        <?php else: ?>
            <div  class="top_style" style="--image: url(<?php $this->options->themeUrl('assets/images/za/2.jpg'); ?>)" Round_header>
        <?php endif; ?>
            <div class="description_style" Round_header>
                <?php if(Helper::options()->Aside_Author_Round): ?>
                    <h1><?php $this->options->Aside_Author_Round() ?></h1>
                <?php else: ?>
                    <h1>相见即使缘</h1>
                <?php endif; ?>
                
            </div>
        </div>
        
        <div class="flex row-reverse al_center mt-1">
            <?php if(Helper::options()->AThumbnail): ?>
            <img src="<?php $this->options->Aimg() ?>" width="64px" height="64px" class="img_style h-border" Round_header>
            <?php else: ?>
            <img src="https://q1.qlogo.cn/g?b=qq&amp;nk=160860446@qq.com&amp;s=100&amp;" width="64px" height="64px" class="img_style h-border" Round_header>
            <?php endif; ?>
            <?php if(Helper::options()->Aside_Author): ?>
                <b Round_header><?php $this->options->Aside_Author() ?></b>
            <?php else: ?>
            <b Round_header>尘落</b>
            <?php endif; ?>
        </div>
        
    </header>
    