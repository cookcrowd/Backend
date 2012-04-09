(function() {
  var getIngredient, ingredients, textIngredients;

  ingredients = [];

  textIngredients = [];

  getIngredient = function(name) {
    var ingr, key, retVal;
    retVal = '';
    for (key in ingredients) {
      ingr = ingredients[key];
      if (ingr.name === name) retVal = ingr;
    }
    if (retVal === '') {
      $.ajax({
        url: 'manage/ingredients',
        type: 'post',
        data: {
          name: name
        },
        async: false,
        success: function(response) {
          retVal = {
            id: response.id,
            name: name
          };
          ingredients.push(retVal);
          return textIngredients.push(name);
        }
      });
    }
    return retVal;
  };

  $(document).ready(function() {
    var _this = this;
    return $.get('ingredients', function(response) {
      var ingr, _i, _len, _results;
      ingredients = response;
      _results = [];
      for (_i = 0, _len = ingredients.length; _i < _len; _i++) {
        ingr = ingredients[_i];
        _results.push(textIngredients.push(ingr.name));
      }
      return _results;
    });
  });

  $('.add-step').on('click', function(e) {
    var $tpl, tpl;
    e.preventDefault();
    tpl = $('#tpl-step').jqote({
      step: $('fieldset').size()
    });
    $tpl = $(tpl).hide().fadeIn().insertAfter('fieldset:last');
    return $tpl.find('input[type="text"].add-ingredient').typeahead({
      source: textIngredients
    });
  });

  $('input[type="text"].add-ingredient').typeahead({
    source: textIngredients
  });

  $('form').on('click', '.btn.add-ingredient', function(e) {
    var $this, amount, ingredient, span, step, unit;
    e.preventDefault();
    $this = $(this);
    amount = $this.siblings('div.input-append').find('input').val();
    $this.siblings('div.input-append').find('input').val('');
    unit = $this.siblings('div.input-append').find('button').text();
    ingredient = getIngredient($this.siblings('input.add-ingredient').val());
    $this.siblings('input.add-ingredient').val('');
    span = $('<span/>').addClass('label ingredient').text(amount + " " + unit + " " + ingredient.name);
    step = $this.parents('fieldset').data('step');
    span.append($('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][amount][]').attr('value', amount));
    span.append($('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][unit][]').attr('value', unit));
    span.append($('<input type="hidden"/>').attr('name', 'steps[' + step + '][ingredients][ingredient][]').attr('value', ingredient.id));
    span.append($('<a/>').attr('href', '#').addClass('append').append($('<i/>').addClass('icon-trash icon-white')));
    return span.appendTo($this.siblings('p.ingredients'));
  });

  $('form').on('click', 'span.ingredient a', function(e) {
    var $this;
    e.preventDefault();
    $this = $(this);
    return $this.parent().remove();
  });

  $('form').on('click', 'ul.add-ingredient-amount a', function(e) {
    e.preventDefault();
    return $(this).parent().parent().parent().find('span.ingredient-unit').text($(this).text());
  });

}).call(this);
