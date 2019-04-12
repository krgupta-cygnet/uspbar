{literal}
<style>
.uspbar-header{
    /* height: 40px;  */
    text-align: center;
    /* font-weight: 700; */
    /* font-size: 12px; */
    margin: 3px -30px 3px 3px;
}

.uspbar-header-para{
    padding: 5px 0 0 0;
    text-align: center;
    vertical-align: middle;
}
p {
    margin: 0;
    padding: 0;
}
div{
    margin: 0;
    padding: 0;
}
</style>
{/literal}
<div class="row" style="margin-left: -15px; margin-right: -15px;"> 
    {foreach from=$uspbarLists item=uspbar}
        {if $countUspBar == 3}
            {$listCol = 'col-md-4'}
        {else if $countUspBar == 2}
            {$listCol = 'col-md-6'}
        {else}
            {$listCol = 'col-md-12'}
        {/if}

        <div class="{$listCol} text-center" >
                <div class="uspbar-header" style="background-color:{$uspbar.color}">
                    <div class="uspbar-header-in">
                        <a href="{$uspbar.link}" style="color:#000000;">{$uspbar.description nofilter}</a>
                    </div>
                </div>
        </div>
    {/foreach}
</div>
