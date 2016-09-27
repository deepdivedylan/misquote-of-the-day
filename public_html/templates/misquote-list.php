<h1>Misquote List Component</h1>
<table class="table table-bordered table-hover table-responsive table-striped table-word-wrap">
	<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th></tr>
	<tr *ngFor="let misquote of misquotes">
		<td>{{ misquote.misquoteId }}</td>
		<td>{{ misquote.misquote }}</td>
		<td>{{ misquote.attribution }}</td>
		<td>{{ misquote.submitter }}</td>
	</tr>
</table>
