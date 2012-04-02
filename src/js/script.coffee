$(document).ready () ->
  
$('.add-step').on 'click', (e) ->
  e.preventDefault()

  tpl = $('#tpl-step').jqote 
    step: 1

  $(tpl).hide().fadeIn().insertAfter 'fieldset:last'
