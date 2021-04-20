(function () {
  jQuery(function($) {

    var $select = $('select');

    if($select.length > 0) {
      $select.selectBoxIt({
        autoWidth: false
      });
    }

    $(document).foundation();

  });
})();
