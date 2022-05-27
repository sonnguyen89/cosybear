'use strict';

(function($) {
  $(document).ready(function() {
    if ($('input[name="_woovr_active"]:checked').val() == 'yes') {
      $('.woovr_show_if_active').css('display', 'flex');
    }
  });

  $(document).on('change', 'input[name="_woovr_active"]', function() {
    if ($(this).val() == 'yes') {
      $('.woovr_show_if_active').css('display', 'flex');
    } else {
      $('.woovr_show_if_active').css('display', 'none');
    }
  });
})(jQuery);