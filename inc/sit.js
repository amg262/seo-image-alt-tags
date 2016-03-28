/**
* File that contains JS methods for frontside
*/
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
function getDomain(hostName) {
   
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

function getDomainName(domain) {

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
function isExtension(url, exts) {
				var match = url;
				var type = exts.split(',');
				//console.log(type)

				for (var i = 0; i <= type.length; i++) {
					console.log(type[i]);
					if ( match.indexOf(type[i]) >= 0) {
						return true;
						
					} else {
						return false;
					}
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

function getImageFilename(url) {
	
	if ( url !== null ) {
		
		var index = url.lastIndexOf("/") + 1;
		var filename = url.substr(index);

		//if ( filename !== null ) {
		//	return filename;

		//} else {

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
				var host = getHostName(url);
				var domain = getDomain(host);
				var name = getDomainName(domain);
				var str = name + "-" + numStr;

				console.log( 'No filename for ' + url );
				return str;
			}

		//}

	} else {
		return null;
	}
}

function disable_gf_autofill() {
	jQuery(document).bind('gform_post_render', function(){

			if ($.browser.chrome) {
				//autcomplete_false();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
			    }); // .each

			} else {
				//autcomplete_off();
				$("input").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each

			    $("form").each(function() {
			    	//alert("ello");
			    	$(this).attr('autocomplete', 'off');
			    }); // .each
			} // end if
		});
}

function disable_form_autofill() {
	if ($.browser.chrome) {
		//autcomplete_false();
		$("input").each(function() {
	    	//alert("ello");
	    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
	    }); // .each

	    $("form").each(function() {
	    	//alert("ello");
	    	$(this).attr('autocomplete', 'false'); //FALSE AS OF 2015
	    }); // .each

	} else {
		//autcomplete_off();
		$("input").each(function() {
	    	//alert("ello");
	    	$(this).attr('autocomplete', 'off');
	    }); // .each

	    $("form").each(function() {
	    	//alert("ello");
	    	$(this).attr('autocomplete', 'off');
	    }); // .each

	} // end if
}