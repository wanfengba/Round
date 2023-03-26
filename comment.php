<link rel="stylesheet" href="<?php _getAssets('assets/css/comment.css'); ?>" />
<script src="<?php $this->options->themeUrl('assets/owo/OwO.js'); ?>"></script>
<?php $this->comments()->to($comments); ?>

<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
 $GLOBALS['isLogin'] = $this->user->hasLogin();
 $GLOBALS['rememberEmail'] = $this->remember('mail',true);
 $GLOBALS['convertip'] = $this->options->convertip;
 Comments::commentReply($this);
?>
    <?php function threadedComments($comments, $options) {
        $commentClass = '';$group = '';
            if ($comments->authorId) {
                if ($comments->authorId == $comments->ownerId) {
                    $group = '博主';
                        $commentClass .= 'By-authors';  //如果是文章作者的评论添加 .comment-by-author 样式
                    } else {
                        $group = '游客';
                        $commentClass .= 'By-user';  //如果是评论作者的添加 .comment-by-user 样式
                    }
                } 
        $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
        $depth = $comments->levels +1;
        if ($comments->url) {
            $author = '<a href="' . $comments->url . '"' . '" target="_blank"' . ' rel="external nofollow"  style="font-size: 16px;">' . $comments->author . '</a>';
        } else {
            $author = $comments->author;
        }
    ?>
        <li class="m-comments-list <?php 
            if ($comments->levels > 0) {
                echo 'comment-child';
                $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
            } else {
                echo 'comment-parent';
            }
            $comments->alt(' comment-odd', ' comment-even');
            ?> depth-<?php echo $depth ?>" id="li-<?php $comments->theId(); ?>">
                <!--class  -->
                <div class="Comments-item Comments-by-user ">
                    <div class="Comments-item-left">
                        <div class="Comments-item-avatar">
                            <img src="<?php _getAvatarByMail($comments->mail);?>" aria-hidden="true" height="50" width="50">
                            <a rel='nofollow' href="#回复给<?php $comments->author(false); ?>" class="comment-reply-link preview" id="createReply" onclick="createReply('<?php $comments->coid();?>','<?php $comments->author(false); ?>') " title="回复给<?php $comments->author(false); ?>">@</a>
                            <span class="commentGroup"></span>
                        </div>
                    </div>
                    <div class="Comments-item-right">
                        <div class="Comments-item-info">
                            <b class="Comments-item-name"><?php echo $author ?><?php echo Comments::getPermalinkFromCoid($comments->parent);?>
                            </b>
                            <span class="Comments-item-time"><i class="iconfont icon-wait"></i> <?php $comments->dateWord(); ?>  · <?php _getAgentOS($comments->agent); ?> · <?php _getAgentBrowser($comments->agent); ?></span>
                        </div>
                        <div class="Comments-item-body">
                            <div class="Comments-item-content cross_photos">
                                <?php 
                                        echo preg_replace('/\<img src="(.*?)"(.*?)">/i','
                                            <dl class="image-thumb">
                                                <dt  data-src="$1" class="img_thumb-item-dt" >
                                                    <img data-src="$1" class="cross-img lazy view-image" data-fancybox="gallery" src="$1"  title="点击放大图片">
                                                </dt>
                                            </dl>
                                        ', Comments::postCommentContent($comments->content,$GLOBALS['isLogin'],$GLOBALS['rememberEmail'],$comments->mail,$parentMail)); ?>
                                    <?php if ('waiting' == $comments->status) : ?>
                                    <span style="color:orange;">您的评论正在等待审核……</span>
                                    <?php endif; ?>                              
                            </div>
                                                                        
                            </div>
                        </div>
                    </div>
                <!--class  -->
                <?php if ($comments->children) { ?>
                    <div class="comment-children">
                        <?php $comments->threadedComments($options); ?>
                    </div>
                <?php } ?>
        </li>
    <?php } ?>

    <section class="Comments-warpper box sm:box p-3 mb-3" id="comments">
        <?php $this->comments()->to($comments); ?>
        <div class="flex ai-center justify-between pb-3">
            <div class="inline-flex ai-center">
            <span class="mr-1 inline-flex ai-center">
                <iconpark-icon class="iconpark" name="comments" size="20px"></iconpark-icon>
            </span>
            </div>
            <div class="inline-flex ai-center">
            <a class="inline-flex ai-center" href="#comments">
                <iconpark-icon class="iconpark" name="hand-down" size="18px"></iconpark-icon>
            </a>
            </div>
        </div>
        <!--  -->
        <?php if($this->allow('comment')): ?>
			<div id="<?php $this->respondId(); ?>" class="comment-respond">
                <div class="vcomment">
                    <!--form-->

                    <form id="comment-form" action="<?php $this->commentUrl() ?>" method="post" role="form" class="comment-form relative">
                        <div class="border-b border-color">
                            <div class="mt-1">
                                <div class="form-group field-editor required ">

                                    <div class="wysibb">
                                        <div class="wysibb-text">
                                            <textarea id="textarea" class="block w-full mt-1 form-textarea wysibb-texarea textarea OwO-textarea" name="text" rows="6" placeholder=" 来都来了，说点什么呗~" aria-required="true" onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};"></textarea>
                                        </div>
                                        
                                        <div class="wysibb-toolbar" style="max-height: 105px;">
                                            <div class="wysibb-toolbar-container">
                                                <?php if ($this->user->hasLogin()): ?>
                                                    <div class="wysibb-toolbar-btn">
                                                        <a href="/admin" target="_blank" class="btn-inner">
                                                            <img width="26" height="26" class="avatar lazyload" src="<?php _getAvatarByMail($comments->mail); ?>" alt="头像" />
                                                        </a>
                                                        <span class="btn-tooltip">后台管理</span>
                                                    </div>
                                                    <?php else: ?>
                                                        <div class="wysibb-toolbar-btn wbb-info">
                                                                <span class="btn-inner">
                                                                    <?php $MD5email= md5(Typecho_Cookie::get('__typecho_remember_mail')); echo '<img draggable="false" src="https://cravatar.cn/avatar/'.$MD5email.'?d=mm" alt="user" class="rounded-full" width="26" height="26">'; ?>
                                                                </span>
                                                                <span class="btn-tooltip">编辑评论信息</span>
                                                            </div>
                                                    <?php endif; ?>
                                                        <div class="wysibb-toolbar-btn wbb-smilebox static">
                                                            <span class="btn-inner OwO OwO-up">OωO</span>
                                                        </div>
                                                        <div class="wysibb-toolbar-btn wbb-img">
                                                            <span class="btn-inner" onclick="document.getElementById('textarea').value+='![图片描述](图片地址)' ">
                                                                <i class="iconfont icon-a-110" Mist-comment></i>
                                                            </span>
                                                            <span class="btn-tooltip">插入图片</span>
                                                        </div>
                                                        <div class="wysibb-toolbar-btn wbb-link">
                                                            <span class="btn-inner" onclick="document.getElementById('textarea').value+='[](https://)' ">
                                                                <i class="iconfont icon-a-11" Mist-comment></i>
                                                            </span>
                                                            <span class="btn-tooltip">链接</span>
                                                        </div>
                                                    </div>
                                                    <div id="cancelReply" onclick="cancelReply();" title="点击取消回复" style="display: none;">取消</div>
                                                    
                                        </div>
                                        <?php if ($this->user->hasLogin()): ?>
                                        <?php else: ?>
                                            <div class="wbb-info-body bottom-10 w-full comment_right" style="display:none">
                                                <div class="md:flex">
                                                    <div class="comment_xin_box"> 
                                                        <div class="comment_xin">
                                                            <input type="text" id="qqinfo" class="form-input w-full m-2" name="qqinfo" placeholder=" QQ号可获取头像和昵称" onblur="fn_qqinfo()">
                                                        </div> 
                                                        <div class="comment_xin">
                                                            <input type="text" id="author" class="form-input w-full m-2" name="author" placeholder=" * 怎么称呼" autocomplete="on" value="<?php $this->remember('author'); ?>" required="required">
                                                        </div> 
                                                    </div>
                                                    
                                                    <div class="comment_xin_box"> 
                                                        <div class="comment_xin">
                                                            <input type="email" id="mail" class="form-input w-full m-2" name="mail" placeholder="<?php if ($this->options->commentsRequireMail): ?> *<?php endif; ?>邮箱(放心~会保密~.~)" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?> autocomplete="on"  required="required"<?php endif; ?>  onblur="fn_email_info()" lay-verify="email">
                                                        </div> 
                                                        <div class="comment_xin">
                                                            <input type="url" id="url" class="form-input w-full m-2" name="url" placeholder="<?php if ($this->options->commentsRequireURL): ?>* <?php endif; ?><?php _e(' http://您的主页'); ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?> autocomplete="on" required="required"<?php endif; ?> lay-verify="url">
                                                        </div> 
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                    
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex al_center space-between">
                            <div class="form-group field-userinfo-email_close">
                                <div class="flex ai-center">
                                    <input type="checkbox" id="secret-button" name="secret" value="1">
                                    <label class="ui-switch2 ai-center" for="secret-button" title="开启该功能，您的评论仅作者和评论双方可见"></label>
                                </div>
                            </div>
                            <button id="submitComment" type="submit" class="btn btn-default inline-flex ai-center create_comment">
                                <span>提交</span>
                            </button>
                        </div>
                    </form>

                    
                </div>
            </div>

        <?php else : ?>
            <h3 class="vcount" style="text-align: center;"> 评论已关闭 &gt;_&lt; </h3>
		<?php endif; ?>

        <div class="v-comment" >
            <div class="Comments-lists">
                <?php if ($comments->have()): ?>
                <?php $comments->listComments(); ?>
                <?php $comments->pageNav('<', '>', 1, ''); ?>
                <?php else: ?>
                <center class="body_comment"  Mist-comment>快来抢沙发吧😊😊😊😊</center>
                <?php endif; ?> 
                    
            </div>
        </div>

	</section>


    <script>
    var OwO_demo = new OwO({
        logo: '<i class="iconfont icon-a-111" Mist-comment></i>',
        container: document.getElementsByClassName('OwO')[0],
        target: document.getElementsByClassName('OwO-textarea')[0],
        api: '<?php  $this->options->themeUrl('assets/owo/OwO.json'); ?>',
        position: 'down',
        width: '100%',
        maxHeight: '250px'
    });
        function fn_qqinfo() {
            //获取QQ信息
            var qq = $("#qqinfo").val();
            if (qq) {
                if (!isNaN(qq)) {
                    $.ajax({
                        url: "https://api.rzv.cc/api/qq?qq=" + qq,
                        method: "get",
                        success: function (data) {
                            if (data == null) {
                                $("#author").val('过路人');
                            }else {
                                $("#author").val(data.data.name);
                                $("#mail").val(qq + '@qq.com');
                                $('.wbb-info img').attr('src',data.data.avatar);
                            }
                            console.log(data);
                        },
                        error: function () {
                            $("#author").val('过路人');
                        }
                    })
                } else {            
                    $("#mail").val('你输入的好像不是QQ号码');
                }
            } else {
                $("#qqinfo").val('请输入您的QQ号');        
            }
        }
        function fn_email_info() {
            var _email = $("input#mail").val();
            if (_email != '') {
                $.ajax({
                type: 'get',
                data: {
                    action: 'ajax_avatar_get',  
                    form: '<?php $this->options->siteUrl(); ?>', // 修改为你的Ajax路径
                    email: _email
                },
                success: function(data) {
                    console.log(data);
                    $('.wbb-info img').attr('src', data); // 修改为你自己的头像标签
                }
                }); // end ajax
            }
        }
    </script>

    