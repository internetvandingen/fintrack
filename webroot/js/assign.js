window.onload = function() {
    $('select[name="account_id"]').on("change", switch_table);
    switch_table();

    var tables = $('table');
    
    tables.each(function(){
        var table = $(this);
        $(this, 'th.sortable')
            .wrapInner('<span title="sort this column"/>')
            .each(function(){
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            th.click(function(){
                table.find('td').filter(function(){
                    return $(this).index() === thIndex;
                }).sortElements(function(a, b){
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                }, function(){
                    // parentNode is the element we want to move
                    return this.parentNode; 
                });
                inverse = !inverse;
            });
        });

    });
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
