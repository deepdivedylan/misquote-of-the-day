<form name="editMisquoteForm" id="editMisquoteForm" class="form-horizontal well" ng-submit="updateMisquote(misquote, editMisquoteForm.$valid);" novalidate>
	<h2>Edit Misquote</h2>
	<hr />
	<div class="form-group" ng-class="{ 'has-error': editMisquoteForm.editMisquote.$touched && editMisquoteForm.editMisquote.$invalid }">
		<label for="editMisquote">Misquote</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="editMisquote" id="editMisquote" class="form-control" maxlength="255" ng-model="misquote.misquote" ng-minlength="1" ng-maxlength="255" ng-required="true" />
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
			<input type="text" name="addAttribution" id="addAttribution" class="form-control" maxlength="64" ng-model="misquote.attribution" ng-minlength="1" ng-maxlength="64" ng-required="true" />
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
			<input type="text" name="addSubmitter" id="addSubmitter" class="form-control" maxlength="64" ng-model="misquote.submitter" ng-minlength="1" ng-maxlength="64" ng-required="true" />
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="editMisquoteForm.addSubmitter.$error" ng-if="editMisquoteForm.addSubmitter.$touched" ng-hide="editMisquoteForm.addSubmitter.$valid">
			<p ng-message="required">Submitter is required.</p>
			<p ng-message="minlength">Submitter cannot be empty.</p>
			<p ng-message="maxlength">Submitter is too long.</p>
		</div>
	</div>
	<button type="submit" class="btn btn-info btn-lg" ng-disabled="editMisquoteForm.$invalid"><i class="fa fa-share"></i> Misquote</button>
	<button type="reset" class="btn btn-warning btn-lg" ng-click="cancelEditing();"><i class="fa fa-ban"></i> Cancel</button>
</form>