<table class="table table-bordered table-hover table-responsive table-striped table-word-wrap">
	<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th><th>Actions</th></tr>
	<tr ng-click="loadMisquote(misquotes[$index].misquoteId);" ng-repeat="misquote in misquotes">
		<td>{{ misquote.misquoteId }}</td>
		<td>{{ misquote.misquote }}</td>
		<td>{{ misquote.attribution }}</td>
		<td>{{ misquote.submitter }}</td>
		<td>
			<button class="btn btn-info" ng-click="setEditedMisquote(misquote);"><i class="fa fa-pencil"></i></button>
			<form class="inline" ng-submit="deleteMisquote(misquote.misquoteId);">
				<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
			</form>
		</td>
	</tr>
</table>