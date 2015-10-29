app.constant("MISQUOTE_ENDPOINT", "api/misquote/");
app.service("MisquoteService", function($http, MISQUOTE_ENDPOINT) {
	function getUrl() {
		return(MISQUOTE_ENDPOINT);
	}

	function getUrlForId(misquoteId) {
		return(getUrl() + misquoteId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(misquoteId) {
		return($http.get(getUrlForId(misquoteId)));
	};

	this.create = function(misquote) {
		return($http.post(getUrl(), misquote));
	};

	this.update = function(misquoteId, misquote) {
		return($http.put(getUrlForId(misquoteId), misquote));
	};

	this.destroy = function(misquoteId) {
		return($http.delete(getUrlForId(misquoteId)));
	};
});