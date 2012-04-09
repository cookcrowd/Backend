ingredients = []
textIngredients = []

getIngredient = (name) ->
  retVal = ''
  for key, ingr of ingredients
    retVal = ingr if ingr.name is name
  
  if retVal is ''
    # add ingredient
    $.ajax
      url: 'manage/ingredients'
      type: 'post'
      data:
        name: name
      async: false
      success: (response) ->
        retVal =
          id: response.id
          name: name
        ingredients.push retVal
        textIngredients.push name
  retVal

$(document).ready () ->
  $.get 'ingredients', (response) =>
    ingredients = response
    textIngredients.push ingr.name for ingr in ingredients


# ----
$('.add-step').on 'click', (e) ->
  e.preventDefault()

  tpl = $('#tpl-step').jqote 
    step: $('fieldset').size()

  $tpl = $(tpl).hide().fadeIn().insertAfter 'fieldset:last'
  $tpl.find('input[type="text"].add-ingredient').typeahead
    source: textIngredients


# ----
$('input[type="text"].add-ingredient').typeahead({
  source: textIngredients
})

# ----
$('form').on 'click', '.btn.add-ingredient', (e) ->
  e.preventDefault()
  
  $this = $(this)
  amount = $this.siblings('div.input-append').find('input').val()
  $this.siblings('div.input-append').find('input').val('')

  unit = $this.siblings('div.input-append').find('button').text()

  ingredient = getIngredient($this.siblings('input.add-ingredient').val())
  $this.siblings('input.add-ingredient').val('')

  span = $('<span/>').addClass('label ingredient').text(amount + " " + unit + " " + ingredient.name)

  step = $this.parents('fieldset').data('step')
  
  span.append(
    $('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][amount][]').attr('value', amount)
  )

  span.append(
    $('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][unit][]').attr('value', unit)
  )

  span.append(
    $('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][ingredient][]').attr('value', ingredient.id)
  )

  span.append(
    $('<a/>').attr('href', '#').addClass('append').append(
      $('<i/>').addClass('icon-trash icon-white')
    )
  )
  span.appendTo($this.siblings('p.ingredients'))

# ----
$('form').on 'click', 'span.ingredient a', (e) ->
  e.preventDefault()

  $this = $(this)
  $this.parent().remove()

# ----
$('form').on 'click', 'ul.add-ingredient-amount a', (e) ->
  e.preventDefault()
  
  $(this).parent().parent().parent().find('span.ingredient-unit').text $(this).text()