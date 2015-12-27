/*
* Function that parses input fields
*/
jQuery(document).ready(function($){

	var count = 0;

	$("img").each(function() {
		//alert("ello");

		if (($(this).attr('alt') == null) || ($(this).attr('alt') == "")) {

			var alt = "";
			var title = "";
			var src = $('img').attr('src'); // "static/images/banner/blue.jpg"
			var tarr = src.split('/');      // ["static","images","banner","blue.jpg"]
			var file = tarr[tarr.length-1]; // "blue.jpg"
			var data = file.split('.')[0];  // "blue"

			if (data !== null) {

				alt = data;
			} else if (file !== null) {
				alt = file;
			} else {
				alt = 'Image Alt-' + count;
			}

			$(this).attr('alt', alt); //FALSE AS OF 2015
		}

		/*if ($(this).attr('title') == null) {

			if (data !== null) {
				title = data;
			} else if (file !== null) {
				title = file;
			} else {
				title = 'Image Title-' + count;
			}
			$(this).attr('title', title); //FALSE AS OF 2015
		}*/

		count++;
	}); // .each

	/**$("#delete_tags").click(function() {
		if (this.checked) {
			$("#update_tags").attr('checked', false);
			$("#update_tags").attr('disabled', true);
		} else {
			$("#update_tags").attr('checked', false);
			$("#update_tags").attr('disabled', false);
		}
	});

	$("#update_tags").click(function() {
		if (this.checked) {
			$("#delete_tags").attr('checked', false);
			$("#delete_tags").attr('disabled', true);
		} else {
			$("#delete_tags").attr('checked', false);
			$("#delete_tags").attr('disabled', false);
		}
	});*/
	//console.log(count);
}); //.ready
