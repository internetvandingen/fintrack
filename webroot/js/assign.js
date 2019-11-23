window.onload = function() {
    $('select[name="account_id"]').on("change", switch_table);
    switch_table();
}

function switch_table(){
    let el = $('select[name="account_id"]');
    let selected = el.find(":selected").val();
    $('table').each(function(){
        if ($(this).data('account') == selected){
            $(this).removeClass('hidden');
        } else {
            $(this).addClass('hidden');
        }
    });
}
