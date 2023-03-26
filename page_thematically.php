<?php

/**
 * 专题
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
            <div class="page-thematically grid gap-4 grid-cols-3" Round_thematically>
                <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                <?php while($category->next()): ?>
                <div class="page-thematically_card flex al_center" Round_thematically>
                    <img src="<?php $category->description(); ?>" width="64px" height="64px" class="page-thematically_img" Round_thematically="">
                    <a href="<?php $category->permalink(); ?>" title="<?php $category->name(); ?>"><?php $category->name(); ?>
                    </a>
                    <div class="page-thematically_cat_img" style="background-image:url(<?php $category->description(); ?>);"  Round_thematically=""></div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <div class="part mt-3 article_comment">
        <?php $this->need('comment.php'); ?>
    </div>
    <?php $this->need('footer.php'); ?>  