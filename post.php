<?php
/**
 * 
 * @author 尘落（林一周）
 * time 2023/3/23
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>    
</head>
<?php if(Helper::options()->Aimage): ?>
<body style="--bgimg: url(<?php $this->options->Aimage() ?>);">
<?php else: ?>
<body class="wrapper">
<?php endif; ?>
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