(function(window, document, undefined) {
$(document).ready(function() {
	
	var lastStepId = 0;
	
	$('#new-step').click(function(e) {
		e.preventDefault();
		
		lastStepId += 1;
		$('#recipe-steps').jqoteapp('#tmpl-new-step', { step: lastStepId });
	});
	
	$('#new-recipe').submit(function(e) {
		e.preventDefault();
		
		alert('submitting the form.');
	});
	
});
})(window, document);