# Round

潦草截图下（在最下面） 反正就是主打朋友圈类型 有时间会更新 （字有点多 使用者请耐心看完 可能对你的疑问有帮助）
<a href="https://github.com/wanfengba/links">友链插件下载</a>

# 菜单
<table role="table">
<thead>
<tr>
<th>字段名</th>
<th>作用</th>
<th>备注</th>
</tr>
</thead>
<tbody>
<tr>
<td>name</td>
<td>名称</td>
<td>鼠标悬停，显示的名称</td>
</tr>
<tr>
<td>icon</td>
<td>图标字体</td>
<td>使用 <a href="https://icons.getbootstrap.com/" rel="nofollow">Bootstrap Icons</a> 图标字体库</td>
</tr>
<tr>
<td>url</td>
<td>链接</td>
<td>点击跳转的链接</td>
</tr>
<tr>
<td>newTab</td>
<td>新窗口打开</td>
<td>true/false</td>
</tr>
</tbody>
</table>

<pre>[
  {
    <span class="pl-ent">"name"</span>: <span class="pl-s"><span class="pl-pds">"</span>首页<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"icon"</span>: <span class="pl-s"><span class="pl-pds">"</span>bi bi-house-door-fill<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"url"</span>: <span class="pl-s"><span class="pl-pds">"</span>/<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"newTab"</span>: <span class="pl-c1">false</span>
  },
  {
    <span class="pl-ent">"name"</span>: <span class="pl-s"><span class="pl-pds">"</span>友链<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"icon"</span>: <span class="pl-s"><span class="pl-pds">"</span>bi bi-train-freight-front-fill<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"url"</span>: <span class="pl-s"><span class="pl-pds">"</span>/<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"newTab"</span>: <span class="pl-c1">false</span>
  },
  {
    <span class="pl-ent">"name"</span>: <span class="pl-s"><span class="pl-pds">"</span>关于<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"icon"</span>: <span class="pl-s"><span class="pl-pds">"</span>bi bi-person<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"url"</span>: <span class="pl-s"><span class="pl-pds">"</span>/<span class="pl-pds">"</span></span>,
    <span class="pl-ent">"newTab"</span>: <span class="pl-c1">false</span>
  }
]</pre>

计划：
1.邮箱收到评论信息（有此文件，但没博客测试，然后就没添加相关设置）
2.添加文章\书单\相册等单独样式 （有时间的话 会继续折腾）
3.增加评论表情 （目前只有emoji表情）
4.增加昼夜模式 （本来打算添加github版本的 后来算了 没时间）
5.手机端也会考虑添加个搜索 （手机端添加弹出搜索好像不错）
6.手机端导航会和joe一样添加博主栏 （没添加的话 总感觉缺少了什么）

版权：
1.后台主题模板和编辑器来源joe （当然之后会再添加些东西 不能保证不是joe里移植过来）
2.友链插件来源寒泥的修改而来（只是删掉一下用不上的东西）
3.首页显示评论功能来源南博（主题里自定义css里自动删除 清除掉就会显示）
4.首页构建来源快手某博主的 当时刷视频 看到文案发现这个很简约 于是便有了此博客（修改过的）
5.友链（插件功能）页面显示链接框架来源jdeal博客 网址获取使用<a href="https://www.jdeal.cn/322.html">生成网站快照缩略图</a> （表示自己也不知道能稳多久 到时候要是倒了 请自行修改）
6.页面头图添加背景图构建来源即刻学术（当时有被惊艳到 但在此模板用上好像不行 看不了 所有 有需要的可以在自定义字段添加背景图链接 不需要的话直接忽略）
7.专题页面的分类构建来源泽泽的友情链接页面修改而来（除了缺少个介绍和图片圆度不一 其他一样）这里补充一个<b>重点</b>内容 专题显示图片要求把图片链接放在此分类的介绍框里 这里没有博客不好演示截图

所有内容来源各大博主大佬们 我只负责使用并和成一款主题 所以此主题免费发布 所有人都可以使用 而且欢迎二改（看得懂的话 小白一个 代码不是一点儿的乱）

文件介绍，让小白也知道修改（因为时间急迫 可能有些地方设置没有添加到后台主题设置里 可以打开文件修改）此文件
1.public/include.php和config.php用于添加外链或style
2.public/header.php用于修改电脑端导航和中栏上部分内容
3.comment.php用于修改评论
4.footer.php用于修改底部和手机端导航
5.index.php用于修改中栏中间部分
6.post.php用于修改文章内容中间部分

以上内容来源1.1版本的 之后如果还有更新 那么会添加所更新的内容 不会再介绍新添加的文件 （有点儿麻烦 耗时间）

最后 本人 做此主题当初是想使用此主题赚点儿生活费 后来修改多次（因为自己写的太乱） 只能使用各大博主的功能 所以免费发布 此主题会在 本人 找到工作之前持续更新 但如果一直没有更新的话 那么证明本人已经找到工作了 使用者还请见谅 麻烦到最后能自行修改 

此主题修修改改 花费半个月的时间 期间构建从单栏到三栏到双栏又回到单栏 也曾想过在主题后台添加切换功能 但碍于时间有限 换了一个又一个名字 一次又一次的重新 最后成了大家所见到的模样 望大家能够喜欢

留：23/3/26 

首页截图

![首页](https://user-images.githubusercontent.com/83448377/227761538-10935d05-65ba-4722-8e0d-bcb7e305110a.jpg)

主题截图
![专题](https://user-images.githubusercontent.com/83448377/227761591-fdb37af7-9107-4c2f-87ae-17952e3fbf24.jpg)

友链截图
![友链](https://user-images.githubusercontent.com/83448377/227761602-21ee18a8-240d-40bd-b803-ce1297ecae1e.jpg)

页面截图
![页面](https://user-images.githubusercontent.com/83448377/227761619-62a36807-3aab-4635-939e-dcab58b79ab4.jpg)
（全部页面都如此 不添加图片则不显示 添加则显示 此功能只有页面才实现）

![image](https://user-images.githubusercontent.com/83448377/227759795-092d8399-f661-4151-8b09-2abd928e1d8d.png)

赞赏码 还是希望这个月是可以有点收入的 （细节：如果发现名字太女生了 请不要怀疑 本人就是女生）

![微信](https://user-images.githubusercontent.com/83448377/227762143-8c2bd57a-f08c-4526-88f3-f68de62555ea.jpg)



