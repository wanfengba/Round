<?php

/**
 * 友链
 * 
 * @package custom 
 * 
 * @time 23/3/25
 * 
 **/

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>    
</head>
<?php if(Helper::options()->Aimage): ?>
<body style="--bgimg: url(<?php $this->options->Aimage() ?>);">
<?php else: ?>
<body class="wrapper page">
<?php endif; ?>
    <div class="article_page-top">
        <div class="article_page-top-img" style="--img: url(<?php $this->fields->thumb(); ?>)"></div>
    </div>
    <?php $this->need('public/header.php'); ?>  
    <div class="part mt-3 article_post" Round_article>
        <div class="post_m" Round_article>
            <div class="page-friends" Round_friends>
                <div class="left flex al_center" Round_friends>
                    <div class="flex column al_center">
                        <?php if(Helper::options()->AThumbnail): ?>
                        <img src="<?php $this->options->Aimg() ?>" width="44px" height="44px" class="img_style h-border" Round_friends>
                        <?php else: ?>
                            <img src="https://q1.qlogo.cn/g?b=qq&amp;nk=160860446@qq.com&amp;s=100&amp;" width="44px" height="44px" class="img_style h-border" Round_friends>
                        <?php endif; ?>
                        <?php if(Helper::options()->Aside_Author): ?>
                            <b Round_friends><?php $this->options->Aside_Author() ?></b>
                        <?php else: ?>
                        <b Round_friends>尘落</b>
                        <?php endif; ?>
                    </div>
                    <div class="text" Round_friends>
                        <span>申请友联请确保你的网站长期处于可以被访问且活跃状态，网站类型不限，期待和你互换友联！</span>
                    </div>
                </div>
                <div class="right flex al_center row-reverse" Round_friends>
                    <div class="flex column al_center">
                        <?php if(Helper::options()->AThumbnail): ?>
                        <img src="<?php $this->options->Aimg() ?>" width="44px" height="44px" class="img_style h-border" Round_friends>
                        <?php else: ?>
                            <img src="https://q1.qlogo.cn/g?b=qq&amp;nk=160860446@qq.com&amp;s=100&amp;" width="44px" height="44px" class="img_style h-border" Round_friends>
                        <?php endif; ?>
                        <?php if(Helper::options()->Aside_Author): ?>
                            <b Round_friends><?php $this->options->Aside_Author() ?></b>
                        <?php else: ?>
                        <b Round_friends>尘落</b>
                        <?php endif; ?>
                    </div>
                    <div class="text" Round_friends>
                        <span>
                        <p>网站名称 ：<?php $this->options->title() ?> </p>
                        <p>网站简介 ：<?php $this->options->description() ?></p>
                        <p>网站地址 ：<?php $this->options->siteUrl(); ?> </p>
                        <?php if(Helper::options()->Alogo): ?>
                            <p>LOGO ：<?php $this->options->Alogo() ?></p>
                        <?php else: ?>
                            <p>LOGO ：<?php $this->options->themeUrl('assets/images/za/1.png'); ?></p>
                        <?php endif; ?>
                        </span>
                    </div>
                </div>
                <div class="mian grid gap-4 grid-cols-3" Round_friends>
                <?php
                    $mypattern = <<<eof
                    
                    <div class="card" Round_friends>
                        <a href="{url}" Round_friends><img class="ava" src="https://s0.wp.com/mshots/v1/{url}?w=720&h=360" Round_friends></a>
                        <div class="card-header" Round_friends>
                            <a href="{url}" Round_friends>{name}</a>
                            <div class="info ell" Round_friends>{description}</div>
                       </div>
                    </div>
eof;
                Links_Plugin::output($mypattern, 0, "");?>
                </div>
            </div>
        </div>
    </div>
    <div class="part mt-3 article_comment">
        <?php $this->need('comment.php'); ?>
    </div>
    <?php $this->need('footer.php'); ?>  