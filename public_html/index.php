<?php
/**
* Angular version
**/
$ANGULAR_VERSION = "1.4.7";
?>
<!DOCTYPE html>
<html ng-app="MisquoteOfTheDay">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<link type="text/css" href="css/misquote-of-the-day.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-pusher/0.0.14/angular-pusher.min.js"></script>
		<script type="text/javascript" src="angular/misquote-of-the-day.js"></script>
		<script type="text/javascript" src="angular/pusher-config.js"></script>
		<script type="text/javascript" src="angular/services/misquote.js"></script>
		<script type="text/javascript" src="angular/controllers/misquote.js"></script>
		<title>Misquote of the Day</title>
	</head>
	<body>
		<main class="container" ng-controller="MisquoteController">
			<h1>Misquotes</h1>
			<div class="row">
				<div class="col-md-4">
					<form name="addMisquoteForm" id="addMisquoteForm" class="form-horizontal well" ng-submit="createMisquote(newMisquote, addMisquoteForm.$valid);" ng-hide="isEditing" novalidate>
						<h2>Create Misquote</h2>
						<hr />
						<div class="form-group" ng-class="{ 'has-error': addMisquoteForm.addMisquote.$touched && addMisquoteForm.addMisquote.$invalid }">
							<label for="addMisquote">Misquote</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-comment" aria-hidden="true"></i>
								</div>
								<input type="text" name="addMisquote" id="addMisquote" class="form-control" maxlength="255" ng-model="newMisquote.misquote" ng-minlength="1" ng-maxlength="255" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="addMisquoteForm.addMisquote.$error" ng-if="addMisquoteForm.addMisquote.$touched" ng-hide="addMisquoteForm.addMisquote.$valid">
								<p ng-message="required">Misquote is required.</p>
								<p ng-message="minlength">Misquote cannot be empty.</p>
								<p ng-message="maxlength">Misquote is too long.</p>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': addMisquoteForm.addAttribution.$touched && addMisquoteForm.addAttribution.$invalid }">
							<label for="addAttribution">Attribution</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-quote-left" aria-hidden="true"></i>
								</div>
								<input type="text" name="addAttribution" id="addAttribution" class="form-control" maxlength="64" ng-model="newMisquote.attribution" ng-minlength="1" ng-maxlength="64" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="addMisquoteForm.addAttribution.$error" ng-if="addMisquoteForm.addAttribution.$touched" ng-hide="addMisquoteForm.addAttribution.$valid">
								<p ng-message="required">Attribution is required.</p>
								<p ng-message="minlength">Attribution cannot be empty.</p>
								<p ng-message="maxlength">Attribution is too long.</p>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': addMisquoteForm.addSubmitter.$touched && addMisquoteForm.addSubmitter.$invalid }">
							<label for="addSubmitter">Submitter</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-user" aria-hidden="true"></i>
								</div>
								<input type="text" name="addSubmitter" id="addSubmitter" class="form-control" maxlength="64" ng-model="newMisquote.submitter" ng-minlength="1" ng-maxlength="64" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="addMisquoteForm.addSubmitter.$error" ng-if="addMisquoteForm.addSubmitter.$touched" ng-hide="addMisquoteForm.addSubmitter.$valid">
								<p ng-message="required">Submitter is required.</p>
								<p ng-message="minlength">Submitter cannot be empty.</p>
								<p ng-message="maxlength">Submitter is too long.</p>
							</div>
						</div>
						<button type="submit" class="btn btn-info btn-lg" ng-disabled="addMisquoteForm.$invalid"><i class="fa fa-share"></i> Misquote</button>
						<button class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
					</form>
					<form name="editMisquoteForm" id="editMisquoteForm" class="form-horizontal well" ng-submit="updateMisquote(editedMisquote, editMisquoteForm.$valid);" ng-show="isEditing" novalidate>
						<h2>Edit Misquote</h2>
						<hr />
						<div class="form-group" ng-class="{ 'has-error': editMisquoteForm.editMisquote.$touched && editMisquoteForm.editMisquote.$invalid }">
							<label for="editMisquote">Misquote</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-comment" aria-hidden="true"></i>
								</div>
								<input type="text" name="editMisquote" id="editMisquote" class="form-control" maxlength="255" ng-model="editedMisquote.misquote" ng-minlength="1" ng-maxlength="255" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="editMisquoteForm.editMisquote.$error" ng-if="editMisquoteForm.editMisquote.$touched" ng-hide="editMisquoteForm.editMisquote.$valid">
								<p ng-message="required">Misquote is required.</p>
								<p ng-message="minlength">Misquote cannot be empty.</p>
								<p ng-message="maxlength">Misquote is too long.</p>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': editMisquoteForm.addAttribution.$touched && editMisquoteForm.addAttribution.$invalid }">
							<label for="addAttribution">Attribution</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-quote-left" aria-hidden="true"></i>
								</div>
								<input type="text" name="addAttribution" id="addAttribution" class="form-control" maxlength="64" ng-model="editedMisquote.attribution" ng-minlength="1" ng-maxlength="64" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="editMisquoteForm.addAttribution.$error" ng-if="editMisquoteForm.addAttribution.$touched" ng-hide="editMisquoteForm.addAttribution.$valid">
								<p ng-message="required">Attribution is required.</p>
								<p ng-message="minlength">Attribution cannot be empty.</p>
								<p ng-message="maxlength">Attribution is too long.</p>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': editMisquoteForm.addSubmitter.$touched && editMisquoteForm.addSubmitter.$invalid }">
							<label for="addSubmitter">Submitter</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-user" aria-hidden="true"></i>
								</div>
								<input type="text" name="addSubmitter" id="addSubmitter" class="form-control" maxlength="64" ng-model="editedMisquote.submitter" ng-minlength="1" ng-maxlength="64" ng-required="true" />
							</div>
							<div class="alert alert-danger" role="alert" ng-messages="editMisquoteForm.addSubmitter.$error" ng-if="editMisquoteForm.addSubmitter.$touched" ng-hide="editMisquoteForm.addSubmitter.$valid">
								<p ng-message="required">Submitter is required.</p>
								<p ng-message="minlength">Submitter cannot be empty.</p>
								<p ng-message="maxlength">Submitter is too long.</p>
							</div>
						</div>
						<button type="submit" class="btn btn-info btn-lg" ng-disabled="editMisquoteForm.$invalid"><i class="fa fa-share"></i> Misquote</button>
						<button class="btn btn-warning btn-lg" ng-click="cancelEditing();"><i class="fa fa-ban"></i> Cancel</button>
					</form>
				</div>
				<div class="col-md-8">
					<table class="table table-bordered table-hover table-responsive table-striped table-word-wrap">
						<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th><th>Actions</th></tr>
						<tr ng-repeat="misquote in misquotes">
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
				</div>
			</div>
			<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>
		</main>
	</body>
</html>