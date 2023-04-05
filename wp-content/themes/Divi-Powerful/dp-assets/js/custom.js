(function($){

$(document).ready(function (e) {
    if($('select#billing_state option').length > 0) {
        $('select#billing_state option').each(function() {
           var new_label_value = $(this).text();
           if($(this).text() != 'Victoria') {
               new_label_value = new_label_value + ' - fee: $50';
           } else {
               new_label_value = new_label_value + ' - free shipping';
           }
           $(this).text(new_label_value);
        });
    }
    if($('.select2-selection__rendered').length > 0) {
        var new_label_value = $('#select2-billing_state-container').text();
        if (new_label_value == 'Victoria') {
            $('#select2-billing_state-container').text(new_label_value +  ' - free shipping');
        }
    }


});

})(jQuery);