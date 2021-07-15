{* #error_message  *}
<div id="error_message" style="display:none;">
    <div id="PlottFrameworkDebug">
        {foreach from=$debug key=myId item=i}
            {$i}
            <hr>
        {/foreach}
    </div>
    <div id="PlottFrameworkMessage">
        <div id="PlottFrameworkBox">
            <div id="PlottFrameworkMessageContents">
                {foreach from=$message key=myId item=i}{$i|nl2br nofilter}{/foreach}
            </div>
            <div class="PlottFrameworkMessageContents2">
                <input type="button" value="閉じる" onclick="closeMessage()">
            </div>
        </div>
    </div>
</div>

{capture name="debugErrorJs"}
<script>
/**
 *
 */
var closeMessage = function()
{
    var _closeButton = inputButtonTag.clone();
    _closeButton
        .attr({
            onclick: 'closeMessage()'
        })
        .val('[close]');
    var _buttonWrapperDiv = divTag.clone();
    _buttonWrapperDiv
        .css({
            float: 'left',
            width: '100%',
            height: '30px',
            textAlign: 'center'
        })
        .append(_closeButton);
    var _messageContentsDiv = divTag.clone();
    _messageContentsDiv
        .css({
            float: 'left',
            width: '100%',
            height: '130px',
            overflow: 'auto'
        })
        .attr({
            id: 'PlottFrameworkMessageContents'
        });
    var _innerWrapperBoxDiv = divTag.clone();
    _innerWrapperBoxDiv
        .attr({
            id: 'PlottFrameworkBox'
        })
        .append(_buttonWrapperDiv, _messageContentsDiv);
    $('#PlottFrameworkMessage').append(_innerWrapperBoxDiv);
    win_msg.close();
};
</script>
{/capture}