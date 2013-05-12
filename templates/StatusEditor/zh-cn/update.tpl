<form action="?mode=dialog&module=preparation/section/status&function=update&id={$id}" method="post" data-ajax="false">
    <input type="text" name="s_text" value="{$name}" />
    <input type="hidden" name="section_id" value="{$section}"  />
    <input type="submit"  data-theme="b" value="修改" />
    <a href="?mode=dialog&module=preparation/section/status&function=delete&id={$id}&section={$section}" data-role="button" data-theme="e">删除</a>
    <a href="?module=preparation/section/status&section={$section}" data-role="button" data-theme="c" data-rel="back">取消</a>
</form>