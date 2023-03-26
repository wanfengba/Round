<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("core/core.php");
/**屏蔽报错**/
error_reporting(0);

/* 评论解析 */
Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('comments','parseContent');
Typecho_Plugin::factory('Widget_Feedback')->comment_1000 = array('comments','filter');

/* 初始化主题 */
function themeInit(Widget_Archive $archive)
{

  //暴力解决访问加密文章会被 pjax 刷新页面的问题
  if ($archive->hidden) header('HTTP/1.1 200 OK');
  //评论回复楼层最高999层.这个正常设置最高只有7层
  Helper::options()->commentsMaxNestingLevels = 999;
  //强制评论关闭反垃圾保护
  Helper::options()->commentsAntiSpam = false;
  //将最新的评论展示在前
  Helper::options()->commentsOrder = 'DESC';
  //关闭检查评论来源URL与文章链接是否一致判断
  Helper::options()->commentsCheckReferer = false;
  // 强制开启评论markdown
  Helper::options()->commentsMarkdown = '1';
  Helper::options()->commentsHTMLTagAllowed .= '<img class src alt><div class>';
  //评论显示列表
  Helper::options()->commentsListSize = 5;
//   if ($archive->is('single')) {
//     $archive->content = Contents::createCatalog($archive->content);
//   }
}
/* 获取主题当前版本号 */
function _getVersion()
{
  return "1.1";
};
/* 获取主题名字 */
function _themes()
{
  echo "Round";
};
/* 获取资源路径 */
function _getAssets($assets, $type = true)
{
  $assetsURL = "";
  // 是否本地化资源
  if (Helper::options()->JAssetsURL) {
    $assetsURL = Helper::options()->JAssetsURL . '/' . $assets;
  } else {
    $assetsURL = Helper::options()->themeUrl . '/' . $assets;
  }
  if ($type) echo $assetsURL;
  else return  $assetsURL;
}

//get_post_view($this)
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}
function  art_count ($cid){
$db=Typecho_Db::get ();
$rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
echo mb_strlen($rs['text'], 'UTF-8');
}
/**
     * 页面耗时
     * @return bool
     */
function timer_start() {
  global $timestart;
  $mtime = explode( ' ', microtime() );
  $timestart = $mtime[1] + $mtime[0];
  return true;
}
timer_start();
 
function timer_stop( $display = 0, $precision = 3 ) {
  global $timestart, $timeend;
  $mtime = explode( ' ', microtime() );
  $timeend = $mtime[1] + $mtime[0];
  $timetotal = $timeend - $timestart;
  $r = number_format( $timetotal, $precision );
  if ( $display )
    echo $r;
  return $r;
}
// 时间
/*<?php echo formatTime($this->created); ?>*/
function formatTime($time){
    $text = '';
    $time = intval($time);
    $ctime = time();
    $t = $ctime - $time; //时间差
    if ($t < 0) {
        return date('Y-m-d', $time);
    }
    $y = date('Y', $ctime) - date('Y', $time);//是否跨年
    switch ($t) {
    case $t == 0:
        $text = '刚刚';
    break;
    case $t < 60://一分钟内
        $text = $t . '秒前';
    break;
    case $t < 3600://一小时内
    $text = floor($t / 60) . '分钟前';
        break;
    case $t < 86400://一天内
    $text = floor($t / 3600) . '小时前'; // 一天内
        break;
    case $t < 2592000://30天内
        if($time > strtotime(date('Ymd',strtotime("-1 day")))) {
        $text = '昨天';
    } elseif($time > strtotime(date('Ymd',strtotime("-2 days")))) {
        $text = '前天';
    } else {
        $text = floor($t / 86400) . '天前';
    }
    break;
    case $t < 31536000 && $y == 0://一年内 不跨年
        $m = date('m', $ctime) - date('m', $time) -1;
        if($m == 0) {
            $text = floor($t / 86400) . '天前';
        } else {
            $text = $m . '个月前';
        }
        break;
    case $t < 31536000 && $y > 0://一年内 跨年
        $text = (11 - date('m', $time) + date('m', $ctime)) . '个月前';
        break;
    default:
        $text = (date('Y', $ctime) - date('Y', $time)) . '年前';
        break;
    }
    return $text;
}
function isqq($email)
{
    if ($email) {
        if (strpos($email, "@qq.com") !== false) {
            $email = str_replace('@qq.com', '', $email);
            if(is_numeric($email)){
            echo "//q1.qlogo.cn/g?b=qq&nk=" . $email . "&";
            }else{
                $mmail = $email.'@qq.com';
                $email = md5($mmail);
                echo "//cdn.v2ex.com/gravatar/" . $email . "?";
            }
            
        } else {
            $email = md5($email);
            echo "//cdn.v2ex.com/gravatar/" . $email . "?";
        }
    } else {
        echo "//cdn.v2ex.com/gravatar/null?";
    }
}
/* 获取头像懒加载图 */
function _getAvatarLazyload($type = true)
{
  $str = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAMAAAC5zwKfAAAC/VBMVEUAAAD87++g2veg2ff++fmg2feg2fb75uag2fag2fag2fag2fag2feg2vah2fef2POg2feg2vag2fag2fag2fag2fag2vah2fag2vb7u3Gg2fag2fb0tLSg2fb3vHig2ff0s7P2wMD0s7Og2fXzs7Pzs7Of2fWh2veh2vf+/v7///+g2vf9/f2e1/ag2fSg2/mg3PT3r6+30tSh2fb+0Hj76ev4u3P6u3K11dr60H3UyKr+/v766On80Hz49vj2xcXm5u3z0IfUx6v2u7vazKTn0pfi6PKg2fbztLT///+g2faf2fag2vf///+g2feg2fe63O6l3vb///+g2fb80Kb8um+x1uD80Hv86er+0Hf73tb0s7P10YX/0Hiq2Or+/v6g2vbe0qL60YT+/v6y1NzuvoS20dSz09ru0Y6z3fTI1MDbxp+h2fag2fb////O4PDuv4XA3/LOz7bh06Du0o/1t7ex3PP+/v6h2ffSzrLdxZ3s5u3/2qag2fb7+/z40NCg2fb9/f2f2PWf2PX0tLT+/v70s7P+/v7M7Pyf1/b1s7P////zs7P0tbWZ2fL20dH+/v7+0Hep2vWl2O+x2/P+/v641tbI1b7C1cf8xpCz0tj1wMD1x8fTya392KPo0ZT56ez4vXbN1bn26Orh0p3x8/jbxZ/CzcT8xo7327DV1tHt0Y7u8/n759661tLyy6L049710IK8z870s7PX1a3xvX/y6OzA1cvBzsXI1cG30dP+38D73Mn/0oX3ysrpwYzv5+zo0pXv5+zH4PDW4e/n5O3+/v786+vN4vP9/f30s7P9/f2f2fSu0er//Pzgu8X///+4zOD////z8/OW0vCq1f+g2fb86er0s7P+z3f8um/+/v72xcX948ym2O/85+T839D8v3v86ej54eH828X+3Kz80qz8w4T8u3Oq2/Wq1ees2Ob64OCx1d/F2N785tv529v94MH82b/1vb382bj93LD91pf91ZH+04b+0X2p2er+2aH8zJ78yZX8yJU3IRXQAAAA1nRSTlMA8PbEz5vhv1X6Y0wzrX9A8/DJt6mHsnH98uzo4NzY19DJwKGAf3tpZmVVSD86LysgIP787ejn4uHf29jW1M3MysnHxcK+vbywn5ONg39wW0AlIBr8+/f29PTx7+rm5eTj4+Df29nX1tLR0dHQz8zKyMXFxcPCwL+9u7u5t7KsqaObmH1wbWBcVVJQSUAwFA34+Pbz8vHx8O7u7ero6Ofl4ODf3t7d3Nvb2djY19fU1NLS0M/NzcrJycjHx8LCwcHAwL68uraxr5SSkId4X1NTNTItFREGybAGmgAABQNJREFUWMOl13N0HEEcwPFp2lzTpElq20jTpLZt27Zt27Zt27b7m9vbpqlt+3Xvdvd2ZncWufv+e+993t7saJFJ0wL8M1UKjJ4yTpyU0QMrZfIPmIa8qLZ/edBU3r+2Z1pY5qGg09DMYVHmsicCwxJljxIXnABMSxBsmcsxAiw1IoclLtQXLOcbau75tYAo1MLPzMsEUSyTsZceolx6Iy86eFB0fS8ZeFQyPS85eFhythcfPC4+y0sIXpRQ6yUGr0qs9vzBy/xpLwC8LsDghXj/YvzApJdgHrmsB4BuzfaXKVkwT6u6+VL1KNXOEBygeNVBrwJlm3LOlj13OEtV6r6BWN10Cc/rwEl9rOMQy1fIYFGbTZk9Mzm5iEYOubYFTKdOPPa/LckpvccP3WLSUnpgPOkIAVb1CnJEGP9xKHXWE8VDpgowekt5PzD+5CDSG8gqLrALaHvdhCP7hnHkQ1Jcyga7OL3YwGgNR/UUY1yHBOvmYouxdbatBRzdRwF84CBrq7+NpQZN91vR3s9HWOifw3wYUyOUE7St4uh+Y6x5xHzALCeaCNo2q8AI7OoZJbJHcSLKDJp+cepXIhb5nATXMcHMKAg0zedUc0buATl1kjLBIOQLmlqqn08RXxAic+PxRYyL5XLS+4rJnhD/+hXzIsraGYhV8j0C00U+kx7yxd937P3BBprqu5fw10dY04Mnn748exKJMRO0oVhA16l3h40u8ef3L5HYqO2DetXTgLGQD1CVFajDOCIi4j02a6HDkb+NGvRR3ZA4Z0OwlcQtd5Hm3pRSO2GOWvKKiLNRNXlSoq7kLsi5arjVCniEuXt3pU68Thxn/T9vEMGVqpOPWinysVTUgrfDIdVetVKygFIeGTxhDm6SwYEUmIU8AZpxUgN7mnqnIL8EHqfPAPKmflDy8syGwSZe3n4wSAJTUfd36ibXWwJPAtiKGINnANo4pHKTdzrqLrxT9PqAUD9D7ywIHUgqgu2omzF5qDR0eWXB1WkDb7W4XneJw1iGPFLIu9c2J9dU+DkJOCunP4A2EGu/1wn2UN+/RoNYH2G+9PIRPBGEnnnZXom4irA+lSAeArnRiHF1SOIe5DklGNyK7kCV6+2r+8qkYX2C5iZ2yI6DG9BcgxIvLXyYBtNbpAASZDllAj3a130WGBWMpAIpkNpyEwTVrnmh3Ja1xYoVG3atFgqtVl7fC2R/9vj4EFz2kKojeaL+VW/FrhTH/NNnFBP0rZExBq/pfMabVeKyvFFIKcxGgNIYpr6asbFdAh9/XlxRBmPaG2cMDdR6tjACJDexONLjXU9ht8vgG3sK1NoN2u27p1bTgFkQVaAK9Btutysg/jA8K6+AQuP8NG+ErqaNAoOz3ZNBORpMN5YWbTWRKvfvcV0erwKbt6bBvvz4YPrLUVNCBQzKxtPg48/pkBrkswWRd2tGCWQwdY3CIki9FBoszfOFa8R1z1fEzFecNlC9Iq8C8YfHvAbkR1ZzH3U6VRaveJN5AqSiQX6yuJVWRrq5RiWgmwJG09bI7iwtL9QtQLwFG5QYIN54XgbZKSCf1QaxsiPDYkPl/tbBYVfi3UEm3Z3AWwfnTkDmjbUEFuddVUUWylrYKtg8K7LU7cszLIEXpyOr1arILzEGj/HnQswUmgyZeimNnpZmTHjIDeRB4WMYZoVx4ciLwqdMypChQroUwmOlq5Ahw6QpZuP2HxxXd11eM9wcAAAAAElFTkSuQmCC";
  if ($type) echo $str;
  else return $str;
}
/* 通过邮箱生成头像地址 */
function _getAvatarByMail($mail)
{
  $gravatarsUrl = Helper::options()->JCustomAvatarSource ? Helper::options()->JCustomAvatarSource : 'https://gravatar.helingqi.com/wavatar/';
  $mailLower = strtolower($mail);
  $md5MailLower = md5($mailLower);
  $qqMail = str_replace('@qq.com', '', $mailLower);
  if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
    echo 'https://thirdqq.qlogo.cn/g?b=qq&nk=' . $qqMail . '&s=100';
  } else {
    echo $gravatarsUrl . $md5MailLower . '?d=mm';
  }
};
/* 根据评论agent获取设备类型 */
function _getAgentOS($agent)
{
  $os = "Linux";
  if (preg_match('/win/i', $agent)) {
    if (preg_match('/nt 6.0/i', $agent)) {
      $os = 'Windows Vista';
    } else if (preg_match('/nt 6.1/i', $agent)) {
      $os = 'Windows 7';
    } else if (preg_match('/nt 6.2/i', $agent)) {
      $os = 'Windows 8';
    } else if (preg_match('/nt 6.3/i', $agent)) {
      $os = 'Windows 8.1';
    } else if (preg_match('/nt 5.1/i', $agent)) {
      $os = 'Windows XP';
    } else if (preg_match('/nt 10.0/i', $agent)) {
      $os = 'Windows 10';
    } else {
      $os = 'Windows X64';
    }
  } else if (preg_match('/android/i', $agent)) {
    if (preg_match('/android 9/i', $agent)) {
      $os = 'Android Pie';
    } else if (preg_match('/android 8/i', $agent)) {
      $os = 'Android Oreo';
    } else {
      $os = 'Android';
    }
  } else if (preg_match('/ubuntu/i', $agent)) {
    $os = 'Ubuntu';
  } else if (preg_match('/linux/i', $agent)) {
    $os = 'Linux';
  } else if (preg_match('/iPhone/i', $agent)) {
    $os = 'iPhone';
  } else if (preg_match('/mac/i', $agent)) {
    $os = 'MacOS';
  } else if (preg_match('/fusion/i', $agent)) {
    $os = 'Android';
  } else {
    $os = 'Linux';
  }
  echo $os;
}
/* 根据评论agent获取浏览器类型 */
function _getAgentBrowser($agent)
{
  if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
    $outputer = 'Internet Explore';
  } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'FireFox';
  } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'MicroSoft Edge';
  } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
    $outputer = '360 Fast Browser';
  } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'MicroSoft Edge';
  } else if (preg_match('/UC/i', $agent)) {
    $outputer = 'UC Browser';
  } else if (preg_match('/QQ/i', $agent, $regs) || preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'QQ Browser';
  } else if (preg_match('/UBrowser/i', $agent, $regs)) {
    $outputer = 'UC Browser';
  } else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
    $outputer = 'Opera';
  } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'Google Chrome';
  } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
    $outputer = 'Safari';
  } else {
    $outputer = 'Google Chrome';
  }
  echo $outputer;
}
/* 获取父级评论 */
function _getParentReply($parent)
{
  if ($parent !== "0") {
    $db = Typecho_Db::get();
    $commentInfo = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ?', $parent));
    echo '<div class="parent"><span style="vertical-align: 1px;">@</span> ' . $commentInfo['author'] . '</div>';
  }
}
/* 评论点赞 */
function _getSupport($coid)
{
$db = Typecho_Db::get();
$prefix = $db->getPrefix();
if (!array_key_exists('support', $db->fetchRow($db->select()->from('table.comments')))) {
$db->query('ALTER TABLE `' . $prefix . 'comments` ADD `support` INT(10) DEFAULT 0;');
return [
'icon' => 'iconfont icon-dianzan1',
'count' => 0,
'text' => ''
];
}
$row = $db->fetchRow($db->select('support')->from('table.comments')->where('coid = ?', $coid));
$support = Typecho_Cookie::get('extend_comments_support');
if (empty($support)) {
$support = array();
} else {
$support = explode(',', $support);
}
if (!in_array($coid, $support)) {
return [
'icon' => 'iconfont icon-dianzan1',
'count' => $row['support'],
'text' => ''
];
} else {
return [
'icon' => 'iconfont icon-dianzan',
'count' => $row['support'],
'text' => ''
];
}
}
function _addSupport($coid)
{
$db = Typecho_Db::get();
$row = $db->fetchRow($db->select('support')->from('table.comments')->where('coid = ?', $coid));
$support = Typecho_Cookie::get('extend_comments_support');
if (empty($support)) {
$support = array();
} else {
$support = explode(',', $support);
}
if (!in_array($coid, $support)) {
$db->query($db->update('table.comments')->rows(array('support' => (int)$row['support'] + 1))->where('coid = ?', $coid));
array_push($support, $coid);
$support = implode(',', $support);
Typecho_Cookie::set('extend_comments_support', $support);
return $row['support'] + 1;
} else {
return false;
}
}

/** 输出文章缩略图 <?php showThumbnail($this,0); ?> */
function showThumbnail($widget,$imgnum){ //获取两个参数，文章的ID和需要显示的图片数量
    // 当文章无图片时的默认缩略图
    $rand = rand(1,10); 
    $random = $widget->widget('Widget_Options')->themeUrl . '/assets/images/rand/' . $rand . '.jpg'; // 随机缩略图路径
    $attach = $widget->attachments(1)->attachment;
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
    $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png))/i';
    $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|png))/i';
    //如果文章内有插图，则调用插图
    if (preg_match_all($pattern, $widget->content, $thumbUrl)) { 
        echo $thumbUrl[1][$imgnum];
    }
    //没有就调用第一个图片附件
    else if ($attach && $attach->isImage) {
        echo $attach->url; 
    } 
    //如果是内联式markdown格式的图片
    else if (preg_match_all($patternMD, $widget->content, $thumbUrl)) {
        echo $thumbUrl[1][$imgnum];
    }
    //如果是脚注式markdown格式的图片
    else if (preg_match_all($patternMDfoot, $widget->content, $thumbUrl)) {
        echo $thumbUrl[1][$imgnum];
    }
    //如果真的没有图片，就调用一张随机图片
    else{
        echo $random;
    }
}


function agreeNum($cid, &$record = NULL)
{
    $db = Typecho_Db::get();
    $callback = array(
        'agree' => 0,
        'recording' => false
    );

    //  判断点赞数量字段是否存在
    if (array_key_exists('agree', $data = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid)))) {
        //  查询出点赞数量
        $callback['agree'] = $data['agree'];
    } else {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $db->getPrefix() . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  获取记录点赞的 Cookie
    //  判断记录点赞的 Cookie 是否存在
    if (empty($recording = Typecho_Cookie::get('__typecho_agree_record'))) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('__typecho_agree_record', '[]');
    } else {
        $callback['recording'] = is_array($record = json_decode($recording)) && in_array($cid, $record);
    }

    //  返回
    return $callback;
}

function agree($cid)
{
    $db = Typecho_Db::get();
    $callback = agreeNum($cid, $record);

    //  获取点赞记录的 Cookie
    //  判断 Cookie 是否存在
    if (empty($record)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('__typecho_agree_record', "[$cid]");
    } else {
        //  判断文章是否点赞过
        if ($callback['recording']) {
            //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
            return $callback['agree'];
        }
        //  添加点赞文章的 cid
        array_push($record, $cid);
        //  保存 Cookie
        Typecho_Cookie::set('__typecho_agree_record', json_encode($record));
    }

    //  更新点赞字段，让点赞字段 +1
    $db->query('UPDATE `' . $db->getPrefix() . 'contents` SET `agree` = `agree` + 1 WHERE `cid` = ' . $cid . ';');

    //  返回点赞数量
    return ++$callback['agree'];
}

/* 增加自定义字段 */
function themeFields($layout)
{
  $keywords = new Typecho_Widget_Helper_Form_Element_Text(
    'keywords',
    NULL,
    NULL,
    'SEO关键词（非常重要！）',
    '介绍：用于设置当前页SEO关键词 <br />
         注意：多个关键词使用英文逗号进行隔开 <br />
         例如：Typecho,Typecho主题,Typecho模板 <br />
         其他：如果不填写此项，则默认取文章标签'
  );
  $layout->addItem($keywords);

  $description = new Typecho_Widget_Helper_Form_Element_Textarea(
    'description',
    NULL,
    NULL,
    'SEO描述语（非常重要！）',
    '介绍：用于设置当前页SEO描述语 <br />
         注意：SEO描述语不应当过长也不应当过少 <br />
         其他：如果不填写此项，则默认截取文章片段'
  );
  $layout->addItem($description);

  $abstract = new Typecho_Widget_Helper_Form_Element_Textarea(
    'abstract',
    NULL,
    NULL,
    '自定义摘要（非必填）',
    '填写时：将会显示填写的摘要 <br>
         不填写时：默认取文章里的内容'
  );
  $layout->addItem($abstract);

  $thumb = new Typecho_Widget_Helper_Form_Element_Textarea(
    'thumb',
    NULL,
    NULL,
    '页面自定义缩略图（非必填）',
    '没有则不显示页面头部缩略图'
  );
  $layout->addItem($thumb);
}