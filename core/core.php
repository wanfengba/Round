<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/* 继承方法函数 */
require_once('widget.php');
/* 过滤内容函数 */
require_once('parse.php');
// 评论工具
require_once('Comments.php');
// 文章工具
require_once('factory.php');


function themeConfig($form)
{
  $_db = Typecho_Db::get();
  $_prefix = $_db->getPrefix();
  try {
    if (!array_key_exists('views', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
      $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `views` INT DEFAULT 0;');
    }
    if (!array_key_exists('agree', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
      $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
    }
  } catch (Exception $e) {
  }
?>
<style>
    body{
        background-image:url(<?php _getAssets('assets/images/za/3.png') ?>);
        background-position: 50% 0;
        background-size: 100% 100%;
        background-repeat: repeat;
        background-repeat:repeat-x;
        background-attachment: fixed;
    }
    @font-face {
        font-family:"wodeziti-2";
        src:url('<?php _getAssets('assets/font/SanJiWenYuanJianTi-2.ttf'); ?>');
        font-display:swap;
    }
</style>
  <link rel="stylesheet" href="<?php _getAssets('assets/typecho/config/css/joe.config.min.css') ?>">
  <script src="<?php _getAssets('assets/typecho/config/js/joe.config.min.js') ?>"></script>
    <div class="header" style="background:url(<?php _getAssets('assets/images/za/2.jpg') ?>)">
        <div class="header_title">
            <sapn class="title"><?php echo _themes() ?>主题</span>
        </div>
    </div>
  <div class="joe_config">
    <div>
      <div class="joe_config__aside">
        <div class="logo"><?php echo _themes() ?> <?php echo _getVersion() ?></div>
        <ul class="tabs">
          <li class="item" data-current="joe_notice">最新公告</li>
          <li class="item" data-current="global">全局设置</li>
          <li class="item" data-current="image">图片设置</li>
          <!--<li class="item" data-current="post">文章设置</li>-->
          <li class="item" data-current="center">文字设置</li>
          <!--<li class="item" data-current="aside">附件设置</li>-->
          <!--<li class="item" data-current="music">邮箱设置</li>-->
          <!--<li class="item" data-current="other">其他设置</li>-->
        </ul>
      </div>
    </div>
    <div class="joe_config__notice">请求数据中...</div>
    <?php
    $ACustomCSS = new Typecho_Widget_Helper_Form_Element_Textarea(
    'ACustomCSS',
    NULL,
    '.post_comment {display: none;}',
    '自定义CSS（非必填）',
    '介绍：请填写自定义CSS内容，填写时无需填写style标签。<br />
         其他：如果不想要某个小代码或者想修改透明圆润度等，都可以通过这个实现 <br />
         例如: .post_comment {display: none;}'
    );
    $ACustomCSS->setAttribute('class', 'joe_content global');
    $form->addInput($ACustomCSS);
    // 
    $ACustomScript = new Typecho_Widget_Helper_Form_Element_Textarea(
    'ACustomScript',
    NULL,
    NULL,
    '自定义JS（非必填）',
    '介绍：请填写自定义JS内容，例如网站统计等，填写时无需填写script标签。'
    );
    $ACustomScript->setAttribute('class', 'joe_content global');
    $form->addInput($ACustomScript);
    // 
    $ACustomHeadEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
    'ACustomHeadEnd',
    NULL,
    NULL,
    '自定义增加&lt;head&gt;&lt;/head&gt;里内容（非必填）',
    '介绍：此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容 <br />
         例如：可以填写引入第三方css、js等等'
    );
    $ACustomHeadEnd->setAttribute('class', 'joe_content global');
    $form->addInput($ACustomHeadEnd);
    // 
    $ACustomBodyEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
    'ACustomBodyEnd',
    NULL,
    NULL,
    '自定义&lt;body&gt;&lt;/body&gt;末尾位置内容（非必填）',
    '介绍：此处用于填写在&lt;body&gt;&lt;/body&gt;标签末尾位置的内容 <br>
         例如：可以填写引入第三方js脚本等等'
    );
    $ACustomBodyEnd->setAttribute('class', 'joe_content global');
    $form->addInput($ACustomBodyEnd);
    // 
    $ABirthDay = new Typecho_Widget_Helper_Form_Element_Text(
    'ABirthDay',
    NULL,
    NULL,
    '网站成立日期（非必填）',
    '介绍：用于显示当前站点已经运行了多少时间。<br>
         注意：填写时务必保证填写正确！例如：2021/1/1 00:00:00 <br>
         其他：不填写则不显示，若填写错误，则不会显示计时'
    );
    $ABirthDay->setAttribute('class', 'joe_content global');
    $form->addInput($ABirthDay);
    // 
    $ACustomFont = new Typecho_Widget_Helper_Form_Element_Text(
    'ACustomFont',
    NULL,
    NULL,
    '自定义网站字体（非必填）',
    '介绍：用于修改全站字体，填写则使用引入的字体，不填写使用默认字体 <br>
         格式：字体URL链接（推荐使用TTX格式的字体，网页专用字体格式） <br>
         注意：字体文件一般有几兆，建议使用cdn链接<br>
         多说：不会用又不喜欢默认字体可以把字体文件（assets/font）删除'
    );
    $ACustomFont->setAttribute('class', 'joe_content global');
    $form->addInput($ACustomFont);
    
    
    $AFavicon = new Typecho_Widget_Helper_Form_Element_Textarea(
    'AFavicon',
    NULL,
    'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAaVBMVEUAAAA2Jyc2Jyc2Jyc2JyfWngc2Jyc2Jyc2Jyc2Jyc2Jyc2JydGMiSSbhU2Jyc2JydvUhs3Jyc2KCg2JyeYchRWPyCmexE2Jyc2JyfurwOKZhfEkQs2Jyd4Who2KCg2KCg2Jyf9ugD3tgL5+sE2AAAAIHRSTlMA6gsW9vuGMcTQtEb9+JNp+6lQKPz7+55y/fv7OvrZXtrXQoIAAAGdSURBVEjHxdXrcoIwEAXgBSJXi4oXVLwcfP+HbAyRQzrtLE6n0+8XagjZsyHKr8VZwg/ZVjRZhKjx10kOk4qiBBD56yMs7RkFABOLU8O6yE84a+uvLwYoYlHc2+M4pmrTZFZQI5llZfBkjIlmzZ9EGLWi8Nns187SZaTJDJan3umAXFQlcOi9NbASRWMX9Oi9BaDVHd+Arh+dgfr7cXU+KIB1T6elLcO7B9GDFv3Ejt+bbRh95Bjg3NNj//rBjiiD6FPeOnnEwQ6Lh0UXQMXoGcbqWQRL4EKqyc4tGbebqWNI/skcxXtfKjYibMP2uQ6ujjbAdefsw0anvil3Vz8lBqPiyzY2ybCGm5D9TFwR1+SqOYrFqg8L58qNwaqZ6jRXpppxWzKbmjOFnTv48pgNq8nY9HOwMxqeP+V0GXnmNAboFqMPG8jF/VDZSbdBobo0iFIXvntNOmgBfNDVjku9TD0DeArop4zXqYcxc2WqGte5h8O+qf8QS8e9+JqwKbXMUW1e2kT+zKYo8remXzGgeeIIlbwlzeU9SSP/5RPis0lhQ1CXpwAAAABJRU5ErkJggg==',
    '网站 Favicon 设置',
    '介绍：用于设置网站 Favicon，一个好的 Favicon 可以给用户一种很专业的观感 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费转换 Favicon 网站 <a target="_blank" href="//tool.lu/favicon">tool.lu/favicon</a>'
    );
    $AFavicon->setAttribute('class', 'joe_content image');
    $form->addInput($AFavicon);
    // 
    $AThumbnail = new Typecho_Widget_Helper_Form_Element_Textarea(
    'AThumbnail',
    NULL,
    NULL,
    '网站 中栏头图 设置',
    '介绍：用于设置网站 中栏头图，一个好看 中栏头图 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />'
    );
    $AThumbnail->setAttribute('class', 'joe_content image');
    $form->addInput($AThumbnail);
    // 
    $Aimage = new Typecho_Widget_Helper_Form_Element_Textarea(
    'Aimage',
    NULL,
    NULL,
    '网站 背景图 设置',
    '介绍：用于设置网站 背景图，一个好看 壁纸 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
    注意：不会填则留空'
    );
    $Aimage->setAttribute('class', 'joe_content image');
    $form->addInput($Aimage);
    // 
    $Alogo = new Typecho_Widget_Helper_Form_Element_Textarea(
    'Alogo',
    NULL,
    NULL,
    '网站 LOGO 设置 - pc （友链页面显示此logo链接）',
    '介绍：用于设置网站 LOGO，一个好的 LOGO 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />'
    );
    $Alogo->setAttribute('class', 'joe_content image');
    $form->addInput($Alogo);
    // 
    $Aimg = new Typecho_Widget_Helper_Form_Element_Text(
    'Aimg',
    NULL,
    'http://q2.qlogo.cn/headimg_dl?dst_uin=160860446&spec=100',
    '网站 小头像 设置 - pc',
    '介绍：用于设置网站  小头像，一个好看 头像 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />'
    );
    $Aimg->setAttribute('class', 'joe_content image');
    $form->addInput($Aimg);
    
    // 
    $Alogotext = new Typecho_Widget_Helper_Form_Element_Text(
    'Alogotext',
    NULL,
    NULL,
    '网站 LOGO旁文字 设置 - pc',
    '介绍：用于设置网站  LOGO旁文字，一个好的 名字 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />'
    );
    $Alogotext->setAttribute('class', 'joe_content center');
    $form->addInput($Alogotext);
    // 
    $Aside_Author = new Typecho_Widget_Helper_Form_Element_Text(
    'Aside_Author',
    NULL,
    "尘落",
    '博主栏博主昵称 - PC/WAP(友链页面也显示此称呼)',
    '介绍：用于修改博客的博主昵称 <br />
         注意：如果不填写时则显示 *个人设置* 里的昵称，不显示此栏可忽略'
    );
    $Aside_Author->setAttribute('class', 'joe_content center');
    $form->addInput($Aside_Author);
    // 
    $Aside_Author_Round = new Typecho_Widget_Helper_Form_Element_Text(
    'Aside_Author_Round',
    NULL,
    "天终会亮，没有太阳也会。",
    '博主栏座右铭- PC/WAP',
    '介绍：用于修改右侧栏的座右铭 <br />
         格式：可以填写API地址 <br />
         注意：API需要开启跨域权限才能调取，否则会调取失败！<br />
         推荐API：https://api.vvhan.com/api/ian<br />
            注意：不显示此栏可忽略，不填则不显示'
    );
    $Aside_Author_Round->setAttribute('class', 'joe_content center');
    $form->addInput($Aside_Author_Round);
    // 
    $Atongji = new Typecho_Widget_Helper_Form_Element_Text(
    'Atongji',
    NULL,
    NULL,
    '底部站点统计代码 - PC/WAP',
    '介绍：用于添加站点统计 <br />
         注意：如果不填写则不会显示'
    );
    $Atongji->setAttribute('class', 'joe_content center');
    $form->addInput($Atongji);
    // 
    $menu_list = new Typecho_Widget_Helper_Form_Element_Textarea(
    'menu_list',
    NULL,
    '首页 || ./',
    '添加导航',
    '介绍：用于添加头部导航 <br />
         格式：名字 || 跳转链接 （中间使用两个竖杠分隔）'
    );
    $menu_list->setAttribute('class', 'joe_content center');
    $form->addInput($menu_list);
    
    
    
    } ?>
    