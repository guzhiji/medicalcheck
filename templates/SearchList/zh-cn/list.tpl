<form class="ui-listview-filter ui-bar-d" method="get" data-ajax="false">
    <input type="search" name="search" id="search" value="{$search}" />
    <input type="hidden" name="module"  value="{$module}" />
</form>
<ul data-role="listview">
    {$ListItems}
</ul>