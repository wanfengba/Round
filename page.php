<?php

/**
 * 普通
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
            <div class="flex al_center">
                <img src="https://q1.qlogo.cn/g?b=qq&amp;nk=160860446@qq.com&amp;s=100&amp;" width="44px" height="44px" class="img_style h-border" Round_header>
                <div>
                    <b Round_header><?php $this->author(); ?></b>
                    <p Round_article><?php echo formatTime($this->created); ?></p>
                </div>
            </div>
            <div class="post pl-9" Round_article>
                <div class="cm-container cm-preview-content joe_detail__article" Round_article-post>
                    <p><?php _parseContent($this, $this->user->hasLogin()) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="part mt-3 article_comment">
        <?php $this->need('comment.php'); ?>
    </div>
    <?php $this->need('footer.php'); ?>  