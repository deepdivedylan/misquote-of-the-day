<div class="row" ng-class="{ 'spacer': collapseAddForm }">
	<button type="button" class="btn btn-lg btn-info" ng-click="collapseAddForm = !collapseAddForm"><i class="fa fa-plus"></i> Add Misquote</button>
</div>
<div class="row">
	<form name="addMisquoteForm" id="addMisquoteForm" class="form-horizontal well" ng-submit="createMisquote(newMisquote, addMisquoteForm.$valid);" uib-collapse="collapseAddForm" novalidate>
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
		<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
	</form>
	<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>
</div>