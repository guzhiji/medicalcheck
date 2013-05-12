<form method="post" action="?mode=dialog&module=evaluation/person&function=save&id={$Id}&parent={$Parent}" data-ajax="false">
    <ul data-role="listview">
        <li data-role="list-divider">个人信息</li>
        <li data-role="fieldcontain">
            <label for="name">姓名</label>
            <input type="text" name="name" id="name" value="{$Name}"  />
        </li>
        <li data-role="fieldcontain">
            {$DegreeList}
        </li>
        <li data-role="fieldcontain">
            {$XiangzhenList}
        </li>
        {$ListItems}
        <li data-role="list-divider">评估</li>
        <li data-role="fieldcontain">
            <input type="checkbox" name="pass" id="pass" class="custom"{$Pass} />
            <label for="pass">合格</label>
        </li>
        <li data-role="fieldcontain">
            <label for="note">注释</label>
            <textarea id="note" name="note">{$Note}</textarea>
        </li>
        <li>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><button type="submit" data-theme="a">保存</button></div>
                <div class="ui-block-b"><a href="?module={$Parent}" data-role="button" data-theme="d">取消</a></div>
            </fieldset>
        </li>
    </ul>
</form>