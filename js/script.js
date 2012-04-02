(function() {

  $(document).ready(function() {});

  $('.add-step').on('click', function(e) {
    var tpl;
    e.preventDefault();
    tpl = $('#tpl-step').jqote({
      step: 1
    });
    return $(tpl).hide().fadeIn().insertAfter('fieldset:last');
  });

}).call(this);
