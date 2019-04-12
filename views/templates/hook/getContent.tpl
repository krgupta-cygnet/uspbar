
{if isset($confirmation)}
<div class="alert alert-success">Settings updated</div>
{/if}
<script type="text/javascript" src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}js/jquery/plugins/jquery.colorpicker.js"></script>

<script type="text/javascript" src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}js/admin/tinymce.inc.js"></script>

<script type="text/javascript">
    var iso = "{$isoTinyMCE}";
    var pathCSS = "{$smarty.const._THEME_CSS_DIR_|escape:'htmlall':'UTF-8'}";
    var ad = "{$ad}";
</script>

<script>
    $(document).ready(function(){
        tinySetup();
    });
</script>

<fieldset>
    <div class="panel">
        <div class="panel-heading">
            <legend><img src="../img/admin/cog.gif" alt="" width="16" />Configuration</legend>
        </div>
        <form action="" method="post">
            {foreach from=$uspbarLists item=uspbar}
                <div class="panel">
                        <div class="panel-heading">
                            <legend>Section {$uspbar.id_uspbar}</legend>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-3 text-right" >Enable :</label>
                            <div class="col-lg-9">
                                    <div class="form-group">
                                        <img src="../img/admin/enabled.gif" alt="" />
                                        <input type="radio" id="active_{$uspbar.id_uspbar}" name="active[{$uspbar.id_uspbar}]" value="1" {if $uspbar.active eq '1'}checked{/if} />
                                        <label class="t" for="active_{$uspbar.id_uspbar}">Yes</label>
                                        <img src="../img/admin/disabled.gif" alt="" />
                                        <input type="radio" id="active_{$uspbar.id_uspbar}" name="active[{$uspbar.id_uspbar}]" value="0" {if empty($uspbar.active) || $uspbar.active eq '0'}checked{/if} />
                                        <label class="t" for="active_{$uspbar.id_uspbar}">No</label>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-lg-3 text-right">Color :</label>
                            <div class="col-lg-8">
                                    <div class="input-group col-lg-6">
                                        <input type="text" class="mColorPicker" id="color_{$uspbar.id_uspbar}" value="{if isset($uspbar) AND isset($uspbar.color)}{$uspbar.color|escape:'htmlall':'UTF-8'}{/if}" name="color[{$uspbar.id_uspbar}]" data-hex="true" />
                                        <span id="icp_color_{$uspbar.id_uspbar}" class="input-group-addon mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
                                    </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-lg-3 text-right">Title:</label>
                            <div class="col-lg-9">
                                
                                    <textarea cols="100" rows="5" type="text" id="description_{$uspbar.id_uspbar}" 
                                    name="description[{$uspbar.id_uspbar}]" 
                                    class="rte" >{if isset($uspbar)}{$uspbar.description|htmlentitiesUTF8}{*html content*}{/if}</textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                                <label class="col-lg-3 text-right">Link:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="link[{$uspbar.id_uspbar}]" id="link" class="form-control" value="{$uspbar.link}"/>  
                                </div>
                        </div>
                </div>
            {/foreach}
               
            <div class="panel-footer">
                <button type="submit" value="1" id="saveConfiguration" name="saveConfiguration" class="button pull-right">
                        <i class="process-icon-save"></i> Save 
                    </button>
            </div>
        </form>
    </div>
</fieldset>