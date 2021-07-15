$(function () {
    // クリアは検索やリセットとは異なる処理
    bindClickCloseModal('search');
    // 本来のサブミットは実行しない
    bindClickNullificationSubmitForm();
    // 検索、リセットは共にデータを再レンダリングする
    $('#search, #btnReset').on('click', function(){
        // ただしリセットは検索条件をリセットする
        if ($(this).attr('id') == 'btnReset') {
            resetForm();
        }
        customSearch('exec-search-user', 'user-list', true);
    });
});
