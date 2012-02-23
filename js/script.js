(function(window, document, undefined) {
$(document).ready(function() {
	var lastStepId = 0,
		fileReader = new FileReader();
	
	$('#new-step').click(function(e) {
		e.preventDefault();
		
		lastStepId += 1;
		$('#recipe-steps').jqoteapp('#tmpl-new-step', { step: lastStepId });
	});
	
	var onFileLoaded = function(e, el) {
		$(el).data('file', e.target.result);
	};
	
	/**
	 * Bind the selected file data to the jquery element
	 */
	$('#new-recipe').on('change', 'input:file', function(e) {
		var that = this;
		fileReader.onload = function(e) {
			onFileLoaded(e, that);
		};
		
		fileReader.readAsText(this.files[0]);
	});
	
	(function() {
		var ingredients = [],
			filter = function(term) {
				var filtered = [];
				$.each(ingredients, function(index, ingredient) {
					if(new RegExp(term, 'i').test(ingredient.label)) {
						filtered.push(ingredient);
					}
				});
				return filtered;
			};
			
		$('#dlg-add-ingredient-name').autocomplete({
			source: function(req, responseFn) {
				if(ingredients.length < 1) {
					$.get('ingredients', function(response) {
						if(! response.error) {
							for(var i in response) {
								ingredients.push({ id: response[i].id, label: response[i].name });
							}
							
							return responseFn(filter(req.term));
						}
						
						ingredients([]);
					});
				}
				else {
			        responseFn(filter(req.term));
				}
			}
		});
		
		/**
		 * Add ingredient
		 */
		var insertIngredientItem = function(id, step) {
			var $list = $('#step-' + step + '-ingredients'),
				$ingredient = $('#dlg-add-ingredient-name'),
				$amount = $('#dlg-add-ingredient-amount'),
				$unit = $('#dlg-add-ingredient-amount-unit');
			
			$list.append(
				$('<li/>').text($amount.val() + ' ' + $unit.val() + "\t" + $ingredient.val())
			);
			
			$('#new-recipe').append(
				$('<input/>').attr('type', 'hidden').attr('name', 'ingredients[' + step + '][]').attr('value', id + ':::' + $amount.val() + ':::' + $unit.val())
			);
			
			$ingredient.val('');
			$amount.val('');
		};
		
		$('#recipe-steps').on('click', '.add-ingredient', function(e) {
			e.preventDefault();
			
			var step = $(this).data('step');
			
			$('#dlg-add-ingredient').dialog({
				title: 'Zutat hinzufügen',
				buttons: [{
					text: 'Hinzufügen',
					click: function() {
						var $ingredient = $('#dlg-add-ingredient-name');
						
						// Check, if ingredient exists
						var ingredient = $ingredient.val(),
							id = null;
						
						$.each(ingredients, function(index, item) {
							if(new RegExp(ingredient, 'i').test(item.label)) {
								id = item.id;
								return;
							}
						});
						
						if(id === null) {
							// Add ingredient via json
							$.post('manage', { ingredient: true, name: ingredient }, function(response) {
								if(! response.error) {
									ingredients.push({ id: response.id, label: ingredient });
									
									insertIngredientItem(response.id, step);
								}
							});
						}
						else {
							insertIngredientItem(id, step);
						}
						
						$(this).dialog('close');
					}
				}],
				modal: true,
				width: 420,
				height: 'auto'
			});
		});
	})();
});
})(window, document);