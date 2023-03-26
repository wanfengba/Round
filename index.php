<?php
/**
 * 
 * 没有一生都一帆风顺
 * 路途起薄雾实属正常
 * 度过薄雾将迎来黎明
 *
 * @package Round
 * @author 尘落（林一周）
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
        <?php while($this->next()): ?>
        <div class="post_m" Round_article>
            <div class="flex al_center">
                <?php if(Helper::options()->AThumbnail): ?>
                    <img src="<?php $this->options->Aimg() ?>" width="44px" height="44px" class="img_style h-border" Round_header>
                <?php else: ?>
                    <img src="https://q1.qlogo.cn/g?b=qq&amp;nk=160860446@qq.com&amp;s=100&amp;" width="44px" height="44px" class="img_style h-border" Round_header>
                <?php endif; ?>
                <div>
                    <b Round_header><?php $this->author(); ?></b><span Round_article>作者:</span>
                    <p Round_article><?php echo formatTime($this->created); ?></p>
                </div>
            </div>
            <div class="post pl-9" Round_article>
                <a href="<?php $this->permalink() ?>">
                    <div class="cm-container cm-preview-content joe_detail__article" Round_article-post>
                        <p><?php echo $this->fields->abstract ? $this->fields->abstract : _parseContent($this, $this->user->hasLogin()); ?></p>
                    </div>
                </a>
            </div>
            <div class="footer" Round_article>
                <div class="flex footer_meta space-between" Round_article>
                    <div class="left" Round_article>
                        <span><i class="iconfont icon-a-15"></i> <?php get_post_view($this);?></span>
                        <span><i class="iconfont icon-a-17"></i> <?php $this->commentsNum('%d'); ?></span>
                    </div>
                    <div class="right" Round_footer>
                        <span class="category" Round_footer><?php $this->category(','); ?></span>
                    </div>
                </div>
                <div class="post_comment" Round_footer>
                    <?php if ($this->commentsNum) : ?>
                    <div class="comment-latest">
                        <?php foreach (Comments::get_post_comment($this) as $item): ?>
                            <div class="post_comment_box flex space-between" Round_footer>
                                <div class="left" Round_footer>
                                    <span class="author"><?= $item['author'] ?>：</span>
                                    <span class="text">
                                        <?= $result = preg_replace("/\[secret\](.*?)\[\/secret\]/sm", "<div class=\"secret\">此条为悄悄话，首页不可见</div>", Comments::parseBiaoQing($item['text'])); ?>
                                    </span>
                                </div>
                                <div class="right" Round_footer>
                                    <span class="created"><?= date('n月j日', $item['created']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <br />
    </div>
    <div class="article_footer" Round_footer>
        <center><?php $this->pageLink('点击查看更多','next'); ?></center>
    </div>
<?php $this->need('footer.php'); ?>    