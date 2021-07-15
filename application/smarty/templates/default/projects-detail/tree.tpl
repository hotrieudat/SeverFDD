<style>
#wrapper_tree {
    display: block;
    width: 100%;
    border: solid 1px #808080;
}
.dhtmlxTree {
    width: 100%;
    height: 420px;
    overflow: auto;
}
#tree_information_box {
    display: block;
    width: auto;
    margin: 10px;
    padding: 10px;
    border: dotted 1px #ccc;
    text-align: center;
    color: #aaa;
}
.subInfo_forGroupName {
    display: inline-block;
    height: 20px;
    margin: 0;
    padding: 0;
    z-index: 10;
    position: absolute;
    right: 10px;
    background-color: #fff;
    opacity: .7;
}
.subInfo_forGroupName img {
    vertical-align: middle;
    width: 14px;
    opacity: .8;
}
.subInfo_forGroupName img:hover {
    opacity: 1;
}
.teamEditButtons {
    padding-left: 4px;
    position: absolute;
    background-color: #fff;
    height: 20px;
}
.editButtonOnTree {
    width: 14px;
}
</style>

<div id="wrapper_tree">
    {*  height:{$boxHeight}px; *}
    <div class="dhtmlxTree" id="{$treeId}" style="width:100%; overflow:auto;"></div>
    <div id="tree_information_box">
        {$arr_word.C_PROJECTSDETAIL_006}<br>{$arr_word.C_PROJECTSDETAIL_007}
    </div>
</div>
