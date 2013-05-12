<form action="?mode=dialog&module=preparation/degree&function=update&id={$id}" method="post" data-ajax="false">
    <input type="text" name="d_name" value="{$name}"  />
    <input type="submit"  data-theme="b" value="修改" />
    <a href="?mode=dialog&module=preparation/degree&function=delete&id={$id}" data-role="button" data-theme="e">删除</a>
    <a href="?module=preparation/degree" data-role="button" data-theme="c" data-rel="back">取消</a>
</form>