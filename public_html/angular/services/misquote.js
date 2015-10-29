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

	this.create = function(tweet) {
		return($http.post(getUrl(), tweet));
	};

	this.update = function(misquoteId, tweet) {
		return($http.put(getUrlForId(misquoteId), tweet));
	};

	this.destroy = function(misquoteId) {
		return($http.delete(getUrlForId(misquoteId)));
	};
});