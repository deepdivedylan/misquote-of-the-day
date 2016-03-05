<div ng-if="deletedMisquote === false">
	<h1>View Misquote {{ misquote.misquoteId }}</h1>
	<blockquote>
		<p>{{ misquote.misquote }}</p>
		<footer>
			{{ misquote.attribution }} <cite>added by {{ misquote.submitter }}</cite>
		</footer>
	</blockquote>
	<edit-misquote></edit-misquote>
</div>
<div ng-if="deletedMisquote === true">
	<h1>404 Misquote Not Found</h1>
</div>
<h2>Return</h2>
<p><a ng-href=".">Go back from whence you came.</a></p>
<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>
<misquote-footer></misquote-footer>