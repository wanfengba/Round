<?php

class Comments
{
    public static function parseContent($text, $widget, $lastResult)
    {
        $text = empty($lastResult) ? $text : $lastResult;
        if ($widget instanceof Widget_Abstract_Comments) {
            $text = Comments::parseBiaoQing($text);
            $text = Comments::parseContentPublic($text);
        }
        return $text;
    }


        /**
     * 解析表情
     * 
     * @return string
     */
    public static function parseBiaoQing($content)
    {   $emo = false;
        global $emo;
        if(!$emo){
            $emo = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/src/owo/OwO.json'), true);
        }
        /* $options = Helper::options();
        $url = $options->siteUrl; */
        foreach ($emo as $v){
            if($v['type'] == 'image'){
                foreach ($v['container'] as $vv){
                    $content = str_replace($vv['data'], '<img width="35px" height="35px" class="biaoqing no-fabcybox" src="'.$vv['icon'] .'"  alt="'.$vv['text'] .'">', $content);
                }
            }
        }

        $reg='/\!\[(.*?)\]\((.*?)\)/';
        $rp='';
        $content=preg_replace($reg,$rp,$content);

        $content = preg_replace("/<a href=\"([^\"]*)\">/i", "<a href=\"\\1\" target=\"_blank\">", $content);

        return $content;
        
    }
    

    /**
     * 评论回复/取消回复按钮JS代码
     *
     * @param mixed $archive
     *
     * @return void
     */

    public static function commentReply($archive)
    {
        if ($archive->allow('comment')) {
            echo "
            <script type=\"text/javascript\">
                function createReply(coid, author) {
                    $('.comment-form').addClass('Comments_publisher'); 
                  var coid;
                  var author;
                  console.log('#coid-' + coid);
                  $('#comment-parent').remove();
                  $('#comment-form').append('<input type=\"hidden\" name=\"parent\" id=\"comment-parent\" value=\"' + coid + '\">');
                  $('#cancelReply').html(\"<span class='flex items-center justify-center'>取消回复：\"+ author +\"\").css('display', 'inline-flex');
                  $(\"html, body\").animate({
                    scrollTop: $('#comment-form').offset().top + -120 + \"px\"
                  }, {
                    duration: 250,
                    easing: \"linear\"
                  });
                  $('.comment-respond textarea').attr('placeholder', '正在回复：' + author)
                  $('#textarea').focus();
                  
                  $('.btn-success').on('click',function(){
                        $.message({
                            message:'正在回复：' + author,
                            type:'success'
                        });
                    })

                }
                function cancelReply() {
                  $('#comment-parent').remove();
                  $('#cancelReply').text('').css('display', 'none');
                  $('.comment-respond textarea').attr('placeholder', '来都来了，说点什么呗~')
                  $('#cancelReply').on('click',function(){
                        $.message({
                            message:'已取消回复',
                            type:'info'
                        });
                    })
                }
                </script>
            ";
        }
    }
    
    /**
     * 私密内容正则替换回调函数
     * @param $matches
     * @return bool|string
     */
    public static function secretContentParseCallback($matches)
    {
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        return '<div class="secret">' . $matches[5] . '</div>';
    }
    public static function parseContentPublic($content)
    {
        
        return $content;
    }
    
    /**
     * 解析文章页面的评论内容
     * @param $content
     * @param boolean $isLogin 是否登录
     * @param $rememberEmail
     * @param $currentEmail
     * @param $parentEmail
     * @param bool $isTime
     * @return mixed
     */
    public static function postCommentContent($content, $isLogin, $rememberEmail, $currentEmail, $parentEmail, $isTime = false)
    {
        $flag = true;
        if (strpos($content, '[secret]') !== false) {
            $pattern = self::get_shortcode_regex(array('secret'));
            $content = preg_replace_callback("/$pattern/", array('Comments', 'secretContentParseCallback'), $content);
            if ($isLogin || ($currentEmail == $rememberEmail && $currentEmail != "") || ($parentEmail == $rememberEmail && $rememberEmail != "")) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        if ($flag) {  
             if (strpos($content, '{lamp/}') !== false) {
                $content = strtr($content, array(
                    "{lamp/}" => '<span class="joe_lamp"></span>',
                ));
            }
            if (strpos($content, '{x}') !== false || strpos($content, '{ }') !== false) {
                $content = strtr($content, array(
                    "{x}" => '<input type="checkbox" class="joe_checkbox" checked disabled></input>',
                    "{ }" => '<input type="checkbox" class="joe_checkbox" disabled></input>'
                ));
            }
            if (strpos($content, '{music') !== false) {
                $content = preg_replace('/{music-list([^}]*)\/}/SU', '<joe-mlist $1></joe-mlist>', $content);
                $content = preg_replace('/{music([^}]*)\/}/SU', '<joe-music $1></joe-music>', $content);
            }
            if (strpos($content, '{mp3') !== false) {
                $content = preg_replace('/{mp3([^}]*)\/}/SU', '<joe-mp3 $1></joe-mp3>', $content);
            }
            if (strpos($content, '{bilibili') !== false) {
                $content = preg_replace('/{bilibili([^}]*)\/}/SU', '<joe-bilibili $1></joe-bilibili>', $content);
            }
            if (strpos($content, '{dplayer') !== false) {
                $player = Helper::options()->CustomPlayer ? Helper::options()->CustomPlayer : Helper::options()->themeUrl . '/libs/player.php?url=';
                $content = preg_replace('/{dplayer([^}]*)\/}/SU', '<joe-dplayer player="' . $player . '" $1></joe-dplayer>', $content);
            }
            if (strpos($content, '{mtitle') !== false) {
                $content = preg_replace('/{mtitle([^}]*)\/}/SU', '<joe-mtitle $1></joe-mtitle>', $content);
            }
            if (strpos($content, '{abtn') !== false) {
                $content = preg_replace('/{abtn([^}]*)\/}/SU', '<joe-abtn $1></joe-abtn>', $content);
            }
            if (strpos($content, '{cloud') !== false) {
                $content = preg_replace('/{cloud([^}]*)\/}/SU', '<joe-cloud $1></joe-cloud>', $content);
            }
            if (strpos($content, '{anote') !== false) {
                $content = preg_replace('/{anote([^}]*)\/}/SU', '<joe-anote $1></joe-anote>', $content);
            }
            if (strpos($content, '{dotted') !== false) {
                $content = preg_replace('/{dotted([^}]*)\/}/SU', '<joe-dotted $1></joe-dotted>', $content);
            }
            if (strpos($content, '{message') !== false) {
                $content = preg_replace('/{message([^}]*)\/}/SU', '<joe-message $1></joe-message>', $content);
            }
            if (strpos($content, '{progress') !== false) {
                $content = preg_replace('/{progress([^}]*)\/}/SU', '<joe-progress $1></joe-progress>', $content);
            }
            if (strpos($content, '{hide') !== false) {
                $db = Typecho_Db::get();
                $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
                if ($hasComment || $login) {
                    $content = strtr($content, array("{hide}" => "", "{/hide}" => ""));
                } else {
                    $content = preg_replace('/{hide[^}]*}([\s\S]*?){\/hide}/', '<joe-hide></joe-hide>', $content);
                }
            }
            if (strpos($content, '{card-default') !== false) {
                $content = preg_replace('/{card-default([^}]*)}([\s\S]*?){\/card-default}/', '<section style="margin-bottom: 15px"><joe-card-default $1><span class="_temp" style="display: none">$2</span></joe-card-default></section>', $content);
            }
            if (strpos($content, '{callout') !== false) {
                $content = preg_replace('/{callout([^}]*)}([\s\S]*?){\/callout}/', '<section style="margin-bottom: 15px"><joe-callout $1><span class="_temp" style="display: none">$2</span></joe-callout></section>', $content);
            }
            if (strpos($content, '{alert') !== false) {
                $content = preg_replace('/{alert([^}]*)}([\s\S]*?){\/alert}/', '<section style="margin-bottom: 15px"><joe-alert $1><span class="_temp" style="display: none">$2</span></joe-alert></section>', $content);
            }
            if (strpos($content, '{card-describe') !== false) {
                $content = preg_replace('/{card-describe([^}]*)}([\s\S]*?){\/card-describe}/', '<section style="margin-bottom: 15px"><joe-card-describe $1><span class="_temp" style="display: none">$2</span></joe-card-describe></section>', $content);
            }
            if (strpos($content, '{tabs') !== false) {
                $content = preg_replace('/{tabs}([\s\S]*?){\/tabs}/', '<section style="margin-bottom: 15px"><joe-tabs><span class="_temp" style="display: none">$1</span></joe-tabs></section>', $content);
            }
            if (strpos($content, '{card-list') !== false) {
                $content = preg_replace('/{card-list}([\s\S]*?){\/card-list}/', '<section style="margin-bottom: 15px"><joe-card-list><span class="_temp" style="display: none">$1</span></joe-card-list></section>', $content);
            }
            if (strpos($content, '{timeline') !== false) {
                $content = preg_replace('/{timeline}([\s\S]*?){\/timeline}/', '<section style="margin-bottom: 15px"><joe-timeline><span class="_temp" style="display: none">$1</span></joe-timeline></section>', $content);
            }
            if (strpos($content, '{collapse') !== false) {
                $content = preg_replace('/{collapse}([\s\S]*?){\/collapse}/', '<section style="margin-bottom: 15px"><joe-collapse><span class="_temp" style="display: none">$1</span></joe-collapse></section>', $content);
            }
            if (strpos($content, '{gird') !== false) {
                $content = preg_replace('/{gird([^}]*)}([\s\S]*?){\/gird}/', '<section style="margin-bottom: 15px"><joe-gird $1><span class="_temp" style="display: none">$2</span></joe-gird></section>', $content);
            }
            if (strpos($content, '{copy') !== false) {
                $content = preg_replace('/{copy([^}]*)\/}/SU', '<joe-copy $1></joe-copy>', $content);
            }
            if (strpos($content, '{copy') !== false) {
                $content = preg_replace('/{copy([^}]*)\/}/SU', '<joe-copy $1></joe-copy>', $content);
            }
            if (strpos($content, '[post') !== false) {
                $content = preg_replace('/\[post title="(.*?)" intro="(.*?)" url="(.*?)"(.*?)\]/sm', '
                <a target="_blank" href="${3}" class="LinkCard">
                    <span class="LinkCard-content">
                        <span class="LinkCard-text">
                            <span class="LinkCard-title">${1}</span>
                            <span class="LinkCard-excerpt text-ell">${2}</span>
                            <span class="LinkCard-meta">
                                <span style="display:inline-flex;">
                                <svg fill="currentColor" viewBox="0 0 24 24" width="17" height="17"><path d="M6.77 17.23c-.905-.904-.94-2.333-.08-3.193l3.059-3.06-1.192-1.19-3.059 3.058c-1.489 1.489-1.427 3.954.138 5.519s4.03 1.627 5.519.138l3.059-3.059-1.192-1.192-3.059 3.06c-.86.86-2.289.824-3.193-.08zm3.016-8.673l1.192 1.192 3.059-3.06c.86-.86 2.289-.824 3.193.08.905.905.94 2.334.08 3.194l-3.059 3.06 1.192 1.19 3.059-3.058c1.489-1.489 1.427-3.954-.138-5.519s-4.03-1.627-5.519-.138L9.786 8.557zm-1.023 6.68c.33.33.863.343 1.177.029l5.34-5.34c.314-.314.3-.846-.03-1.176-.33-.33-.862-.344-1.176-.03l-5.34 5.34c-.314.314-.3.846.03 1.177z" fill-rule="evenodd"></path></svg>
                                </span>
                                <span>${3}</span>
                            </span>
                        </span>
                        <span class="LinkCard-imageCell">
                        <span class="LinkCard-image LinkCard-image-default">
                            <svg fill="currentColor" viewBox="0 0 24 24" width="32" height="32"><path d="M11.991 3C7.023 3 3 7.032 3 12s4.023 9 8.991 9C16.968 21 21 16.968 21 12s-4.032-9-9.009-9zm6.237 5.4h-2.655a14.084 14.084 0 0 0-1.242-3.204A7.227 7.227 0 0 1 18.228 8.4zM12 4.836A12.678 12.678 0 0 1 13.719 8.4h-3.438A12.678 12.678 0 0 1 12 4.836zM5.034 13.8A7.418 7.418 0 0 1 4.8 12c0-.621.09-1.224.234-1.8h3.042A14.864 14.864 0 0 0 7.95 12c0 .612.054 1.206.126 1.8H5.034zm.738 1.8h2.655a14.084 14.084 0 0 0 1.242 3.204A7.188 7.188 0 0 1 5.772 15.6zm2.655-7.2H5.772a7.188 7.188 0 0 1 3.897-3.204c-.54.999-.954 2.079-1.242 3.204zM12 19.164a12.678 12.678 0 0 1-1.719-3.564h3.438A12.678 12.678 0 0 1 12 19.164zm2.106-5.364H9.894A13.242 13.242 0 0 1 9.75 12c0-.612.063-1.215.144-1.8h4.212c.081.585.144 1.188.144 1.8 0 .612-.063 1.206-.144 1.8zm.225 5.004c.54-.999.954-2.079 1.242-3.204h2.655a7.227 7.227 0 0 1-3.897 3.204zm1.593-5.004c.072-.594.126-1.188.126-1.8 0-.612-.054-1.206-.126-1.8h3.042c.144.576.234 1.179.234 1.8s-.09 1.224-.234 1.8h-3.042z"></path></svg>
                        </span>
                        </span>
                    </span>
                </a>
                ', $content);
            }
      
                
            $content = Comments::parseContentPublic($content);
            return ''.$content.'';
        } else {
            if ($isTime) {
                echo Comments::getPermalinkFromCoid($comments->parent);
                return '<div class="secret">此条为悄悄话，仅发布者可见</div>';
            } else {
                echo Comments::getPermalinkFromCoid($comments->parent);
                return '<div class="secret">此条为悄悄话，仅发布者可见</div>';
            }
        }
        
    }


    /**
     * 获取匹配短代码的正则表达式
     * @param null $tagnames
     * @return string
     * @link https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L254
     */
    public static function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        // phpcs:disable Squiz.Strings.ConcatenationSpacing.PaddingFound -- don't remove regex indentation
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
        // phpcs:enable
    }

    /**
     * 评论加@
     * @param $coid
     */
    public static function getPermalinkFromCoid($coid) {
        $db = Typecho_Db::get();
        $row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
        if (empty($row)) return '';
        return '<a class="comments-at" href="#comment-'.$coid.'" style="display: contents;font-size: 15px;"> 回复 '.$row['author'].'</a>';
    }
    /* --------------------------------- */
    //评论加@
    public static function reply($parent) {
        if ($parent == 0) {
            return '';
        }
        $db = Typecho_Db::get();
        $commentInfo = $db->fetchRow($db->select('author,status,mail')->from('table.comments')->where('coid = ?', $parent));
        $link = '<a class="comments-at" href="#comment-' . $parent . '" style="display: contents;">@' . $commentInfo['author'] .  '</a>';
        return $link;
    }

    public static function get_comment_at($_var_108)
    {
        $_var_109 = Typecho_Db::get();
        $_var_110 = $_var_109->fetchRow($_var_109->select('parent,status')->from('table.comments')->where('coid = ?', $_var_108));
        $_var_111 = '';
        $_var_112 = @$_var_110['parent'];
        if ($_var_112 != '0') {
            $_var_113 = $_var_109->fetchRow($_var_109->select('author,status,mail')->from('table.comments')->where('coid = ?', $_var_112));
            @($_var_114 = @$_var_113['author']);
            $_var_111 = @$_var_113['mail'];
            if (@$_var_114 && $_var_113['status'] == 'approved') {
                if (@$_var_110['status'] == 'waiting') {}
            } else {
                if (@$_var_110['status'] == 'waiting') {
                } else {
                    echo '';
                }
            }
        } else {
            if (@$_var_110['status'] == 'waiting') {
            } else {
                echo '';
            }
        }
        return $_var_111;
    }

    public static function commentsID(){
        $user = Typecho_Widget::widget('Widget_User');
        $db = Typecho_Db::get();
        $sql = $db->select()->from('table.comments')
            ->where('coid = ?', Typecho_Widget::widget('Widget_Comments_Archive')->coid)
            ->where('mail = ?', Typecho_Widget::widget('Widget_Archive')->remember('mail', true))
            ->limit(1);
        $result = $db->fetchAll($sql);
        if ($user->hasLogin()) {
            $commentsID = 'Comments-by-author';
        } else if ($result) {
            $commentsID = 'Comments-by-authors';
        } else {
            $commentsID = 'Comments-by-user';
        }
        echo $commentsID;
    }

    /**
     * 评论过滤器
     */
    public static function filter($comment, $post)
    {
        $options = Typecho_Widget::widget('Widget_Options');
		$filter_set = Helper::options();
		$opt = "none";
		$error = "";

        //屏蔽评论内容包含文章标题
		if ($opt == "none" && $filter_set->opt_title != "none") {
			 $db = Typecho_Db::get();
            // 获取评论所在文章
            $po = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $comment['cid']));        
            if(strstr($comment['text'], $po['title'])){
                $error = "对不起，评论内容不允许包含文章标题";
				$opt = $filter_set->opt_title;
            }        
		}
        

		//屏蔽IP段处理
		if ($opt == "none" && $filter_set->opt_ip != "none") {
			if (comments::check_ip($filter_set->words_ip, $comment['ip'])) {
				$error = "评论发布者的IP已被管理员屏蔽";
				$opt = $filter_set->opt_ip;
			}			
		}       
        
        
        //屏蔽邮箱处理
		if ($opt == "none" && $filter_set->opt_mail != "none") {
			if (comments::check_in($filter_set->words_mail, $comment['mail'])) {
				$error = "评论发布者的邮箱地址被管理员屏蔽";
				$opt = $filter_set->opt_mail;
			}			
		}  
        
        //屏蔽网址处理
        if(!empty($filter_set->words_url)){
            if ($opt == "none" && $filter_set->opt_url != "none") {
                if (comments::check_in($filter_set->words_url, $comment['url'])) {
                    $error = "评论发布者的网址被管理员屏蔽";
                    $opt = $filter_set->opt_url;
                }			
            }
        }        
        
        
        //屏蔽昵称关键词处理
		if ($opt == "none" && $filter_set->opt_au != "none") {
			if (comments::check_in($filter_set->words_au, $comment['author'])) {
				$error = "对不起，昵称的部分字符已经被管理员屏蔽，请更换";
				$opt = $filter_set->opt_au;
			}			
		}
        
        
        //日文评论处理
		if ($opt == "none" && $filter_set->opt_nojp != "none") {
			if (preg_match("/[\x{3040}-\x{31ff}]/u", $comment['text']) > 0) {
				$error = "禁止使用日文";
				$opt = $filter_set->opt_nojp;
			}
		}
        
        
        //日文用户昵称处理
		if ($opt == "none" && $filter_set->opt_nojp_au != "none") {
			if (preg_match("/[\x{3040}-\x{31ff}]/u", $comment['author']) > 0) {
				$error = "用户昵称禁止使用日文";
				$opt = $filter_set->opt_nojp_au;
			}
		}
        
        
        //昵称长度检测
		if ($opt == "none" && $filter_set->opt_au_length != "none") {            
            if(comments::strLength($comment['author']) < $filter_set->au_length_min){           	
           		$error = "昵称请不得少于".$filter_set->au_length_min."个字符";
				$opt = $filter_set->opt_au_length;
            }else 
            if(comments::strLength($comment['author']) >  $filter_set->au_length_max){           	
            	$error = "昵称请不得多于".$filter_set->au_length_max."个字符";
				$opt = $filter_set->opt_au_length;
            }
             
		}
        
        //用户昵称网址判断处理
		if ($opt == "none" && $filter_set->opt_nourl_au != "none") {
            if (preg_match(" /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/ ", $comment['author']) > 0) {
				$error = "用户昵称不允许为网址";
				$opt = $filter_set->opt_nourl_au;
			}
		}
            
        
		//纯中文评论处理
		if ($opt == "none" && $filter_set->opt_nocn != "none") {
			if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
				$error = "评论内容请不少于一个中文汉字";
				$opt = $filter_set->opt_nocn;
			}
		}
        
        
        //字符长度检测
		if ($opt == "none" && $filter_set->opt_length != "none") {            
            if(comments::strLength($comment['text']) < $filter_set->length_min){           	
           		$error = "评论内容请不得少于".$filter_set->length_min."个字符";
				$opt = $filter_set->opt_length;
            }else 
            if(comments::strLength($comment['text']) >  $filter_set->length_max){           	
            	$error = "评论内容请不得多于".$filter_set->length_max."个字符";
				$opt = $filter_set->opt_length;
            }
             
		}
        
		//检查禁止词汇
		if ($opt == "none" && $filter_set->opt_ban != "none") {
			if (comments::check_in($filter_set->words_ban, $comment['text'])) {
				$error = "评论内容中包含禁止词汇";
				$opt = $filter_set->opt_ban;
			}
		}
		//检查敏感词汇
		if ($opt == "none" && $filter_set->opt_chk != "none") {
			if (comments::check_in($filter_set->words_chk, $comment['text'])) {
				$error = "评论内容中包含敏感词汇";
				$opt = $filter_set->opt_chk;
			}
		}

		//执行操作
		if ($opt == "abandon") {
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
            throw new Typecho_Widget_Exception($error);
		}
		else if ($opt == "spam") {
			$comment['status'] = 'spam';
		}
		else if ($opt == "waiting") {
			$comment['status'] = 'waiting';
		}
		Typecho_Cookie::delete('__typecho_remember_text');

        if ($_POST['secret']) {
            $comment['text'] = '[secret] &nbsp;' . $comment['text'] . '[/secret]';
        }
        return $comment;
    }

    /**
     * 首页文章底部评论
     * @param $archive
     * @return array
     * @throws Typecho_Db_Exception
     */
    public static function get_post_comment($archive)
    {
        $db = Typecho_Db::get();
        return $db->fetchAll($db->select()->from('table.comments')
            ->where("cid = ? AND status = 'approved' AND type = 'comment' AND parent = 0", $archive->cid)
            ->limit(3)->order('created', Typecho_Db::SORT_DESC)
        );
    }
    
    /**
     * @param $email
     * @param int $size
     * @param null $rating
     * @param null $default
     * @return string
     */
    function get_gravatar($email, $size = 100, $rating = 'G', $default = 'mm')
    {
        $options = Helper::options();
        return Typecho_Common::gravatarUrl($email, $size,
            $rating ?: $options->commentsAvatarRating,
            $default ?: $options->avatarRandomString,
            true
        );
    }

    /**
    * PHP获取字符串中英文混合长度 
    */
    private static function strLength($str){        
        preg_match_all('/./us', $str, $match);
        return count($match[0]);  // 输出9
    }
        

    /**
     * 检查$str中是否含有$words_str中的词汇
     * 
     */
	private static function check_in($words_str, $str)
	{
		$words = explode("\n", $words_str);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
            if (false !== strpos($str, trim($word))) {
                return true;
            }
		}
		return false;
	}

    /**
     * 检查$ip中是否在$words_ip的IP段中
     * 
     */
	private static function check_ip($words_ip, $ip)
	{
		$words = explode("\n", $words_ip);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
			$word = trim($word);
			if (false !== strpos($word, '*')) {
				$word = "/^".str_replace('*', '\d{1,3}', $word)."$/";
				if (preg_match($word, $ip)) {
					return true;
				}
			} else {
				if (false !== strpos($ip, $word)) {
					return true;
				}
			}
		}
		return false;
	}

}



/**
 * 最近评论组件
 *
 * @category typecho
 * @package Widget
 * @copyright Copyright (c) 2008 Typecho team (http://www.typecho.org)
 * @license GNU General Public License 2.0
 */
class Widget_Comments_Recent extends Widget_Abstract_Comments
{
    /**
     * 构造函数,初始化组件
     *
     * @access public
     * @param mixed $request request对象
     * @param mixed $response response对象
     * @param mixed $params 参数列表
     * @return void
     */
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }

    /**
     * 执行函数
     *
     * @access public
     * @return void
     */
    public function execute()
    {
        $select  = $this->select()->limit($this->parameter->pageSize)
        ->where('table.comments.status = ?', 'approved')
        ->order('table.comments.coid', Typecho_Db::SORT_DESC);

        if ($this->parameter->parentId) {
            $select->where('cid = ?', $this->parameter->parentId);
        }

        if ($this->options->commentsShowCommentOnly) {
            $select->where('type = ?', 'comment');
        }
        
        /** 忽略作者评论 */
        if ($this->parameter->ignoreAuthor) {
            $select->where('ownerId <> authorId');
        }

        $this->db->fetchAll($select, array($this, 'push'));
    }

    /**
     * 输出评论摘要
     *
     * @access public
     * @param integer $length 摘要截取长度
     * @param string $trim 摘要后缀
     * @return void
     */
    public function excerpt($length = 100, $trim = '...')
    {
        $result = preg_replace("/\[secret\](.*?)\[\/secret\]/sm", "<div class=\"secret\">此条为悄悄话，首页不可见</div>", Comments::parseBiaoQing(strip_tags($this->content,"<img>"), 0, $length, $trim));
        echo $result;
    }
}
