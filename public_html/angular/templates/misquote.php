<div ng-if="deletedMisquote === false">
	<h1>View Misquote {{ misquote.misquoteId }}</h1>
	<blockquote>
		<p>{{ misquote.misquote }}</p>
		<footer>
			{{ misquote.attribution }} <cite>added by {{ misquote.submitter }}</cite>
		</footer>
	</blockquote>
</div>
<div ng-if="deletedMisquote === true">
	<h1>404 Misquote Not Found</h1>
</div>