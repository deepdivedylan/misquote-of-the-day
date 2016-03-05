<add-misquote></add-misquote>
<div class="row">
	<table class="table table-bordered table-hover table-responsive table-striped table-word-wrap">
		<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th></tr>
		<tr ng-click="loadMisquote(misquotes[$index].misquoteId);" ng-repeat="misquote in misquotes">
			<td>{{ misquote.misquoteId }}</td>
			<td>{{ misquote.misquote }}</td>
			<td>{{ misquote.attribution }}</td>
			<td>{{ misquote.submitter }}</td>
		</tr>
	</table>
</div>
<misquote-footer></misquote-footer>