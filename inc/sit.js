/*

* Function that parses input fields

*/

jQuery(document).ready(function($){

	function getHostName(url) {
	    var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
	    if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
	    	var hostName = match[2];
	    	return hostName;
	    }
	    else {
	        return null;
	    }
	}
	function getDomain(url) {
	    var hostName = getHostName(url);
	    var domain = hostName;
	    
	    if (hostName != null) {
	        var parts = hostName.split('.').reverse();
	        
	        if (parts != null && parts.length > 1) {
	            domain = parts[1] + '.' + parts[0];
	                
	            if (hostName.toLowerCase().indexOf('.co.uk') != -1 && parts.length > 2) {
	              domain = parts[2] + '.' + domain;
	            }
	        }
	    }
	    
	    return domain;
	}

	function getDomainName(url) {
		var host = getHostName(url);
		var domain = getDomain(url);

		if ( domain !== null ) {
			var str = domain.split( '.' );
			var domainName = str[0];

			return domainName;

		} else {

			return null;
		}

	}

	function isExternal(url) {
	    var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
	    if (match != null && typeof match[1] === 'string' &&
	        match[1].length > 0 && match[1].toLowerCase() !== location.protocol)
	        return true;

	    if (match != null && typeof match[2] === 'string' &&
	        match[2].length > 0 &&
	        match[2].replace(new RegExp(':('+{'http:':80,'https:':443}[location.protocol]+')?$'),'')
	           !== location.host) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}

	function isPdf(url) {
		var match = url;

		if ( match.indexOf(".pdf") >= 0) {
			return true;
			
		} else {
			return false;
		}
	}

	function handlePdfUrl(url) {
		//Set all targets to blank
		if (($(url).attr('target') !== '_blank')) {
			$(url).attr('target', "_blank");
			return true;
		} else {
			return null;
		}
	}

	function parseAnchorTags() {
		//counter and constants
		var count = 0;
		var blank = "_blank";
		var base = "<?php echo $server; ?>";

		$('a[href$=".pdf"]').each


		//looping through each anchor tag
		$("a").each(function() {
			//set url to href value if href doesnt contains
			//base site in it, will return -1

			if ( ( $(this).attr('href') !== '#' ) && ( $(this).attr('href') !== null ) ) {

				var external = isExternal( $(this).attr('href') );
				var pdf = isPdf( $(this).attr('href') );

				if ( ( external === true ) || ( pdf === true ) ) {
					$(this).attr('target', '_blank');
					count++;
				}
				//if (($(this).attr('target') !== '_blank')) {
				//	$(this).attr('target', '_blank');
				//	count++;
				//} //target
			} //undefined

		}); //each

		return count;
	}

	function getImageFilename(url) {
		
		if ( url !== null ) {
			
			var index = fullUrl.lastIndexOf("/") + 1;
			var filename = fullUrl.substr(index);

			if ( filename !== null ) {
				return filename;

			} else {

				var src = url; // "static/images/banner/blue.jpg"
				var tarr = src.split('/');      // ["static","images","banner","blue.jpg"]
				var file = tarr[tarr.length-1]; // "blue.jpg"
				var data = file.split('.')[0];

				if ( data !== null ) {
					
					return data;

				} else if ( file !== null ) {
					return file;

				} else {
					var num = Math.floor(Math.random() * 1001);
					var numStr = num.toString();
					var domain = getDomainName(url);

					var str = domain + "-" + numStr;

					console.log( 'No filename for ' + url );
					return str;
				}

			}

		} else {
			return null;
		}
	}

	function parseImageTags() {
		var count = 0;

		$("img").each(function() {

			if ( ($(this).attr('alt') === null) || ($(this).attr('alt') === "" ) ) {

				var alt = getImageFilename(url)

				if ( alt !== null ) {
					$(this).attr('alt', alt); //FALSE AS OF 2015
				} else {
					console.log('didnt fine one');
					$(this).attr('alt', 'error'); //FALSE AS OF 2015
				}
			}

		count++;

		}); // .each

		return count;
	}



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

