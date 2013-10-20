$(document).ready(function(){

	/**
	 * Used in takeatest_random to select all checkboxes
 	 */
	
	$(function() {
		   $('.selectall').change(function() {
		      $(this).siblings('input[type=checkbox]').prop('checked', this.checked);
		   });
		});

	
	/**
	 * Used in mytests_new to add fields to the form
 	 */
	
//	click + to add another field
	$("#addOption").click (function(){
		$("<input type='text' value='' autofocus style='display:inline; width:60%' />")
		 .attr("name", "answers[]")
		 .attr("class", "answers")
		 .attr("placeholder", "Answer " + answernojs)
	     .insertAfter(".answers:last");
		answernojs ++;  
	});
	
//	or press tab twice to add another field
	$('#addOption').keydown(function(e) {
		var code = e.keyCode || e.which;
		if (code == 9) {
			$("<input type='text' value='' autofocus style='display:inline; width:60%' />")
			 .attr("name", "answers[]")
			 .attr("class", "answers")
			 .attr("placeholder", "Answer " + answernojs)
		     .insertAfter(".answers:last");
			answernojs ++;  
		}
		return false;
	});
	
	
//	Save an open question before saving the test. Doesn't work.
//	$("#testform").submit(function() {
//	    $("questionform").submit();
//	    return false;
//	});
	
	
//	Save question (is submit form) when another question is clicked. Doesn't work.
	$("button").click(function() {
		  $('#questionform').submit();
	}); 
//	$("form").click(function(e) {
//		  e.stopPropagation();
//	});
		
});