<form #misquoteForm="ngForm" name="misquoteForm" id="misquoteForm" class="form-horizontal well" (ngSubmit)="createMisquote();" novalidate>
	<h2>Create Misquote</h2>
	<hr />
	<div class="form-group" [ngClass]="{ 'has-error': misquote.touched && misquote.invalid }">
		<label for="misquote">Misquote</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="misquote" id="misquote" class="form-control" maxlength="255" required [(ngModel)]="misquote.misquote" #misquoteText="ngModel" />
		</div>
		<div [hidden]="misquoteText.valid || misquoteText.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="misquoteText.errors?.required">Misquote is required.</p>
			<p *ngIf="misquoteText.errors?.maxlength">Misquote is too long. You typed</p>
		</div>
	</div>
	<div class="form-group" [ngClass]="{ 'has-error': attribution.touched && attribution.invalid }">
		<label for="attribution">Attribution</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-quote-left" aria-hidden="true"></i>
			</div>
			<input type="text" name="attribution" id="attribution" class="form-control" maxlength="64" required [(ngModel)]="misquote.attribution" #attribution="ngModel" />
		</div>
		<div [hidden]="attribution.valid || attribution.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="attribution.errors?.required">Attribution is required.</p>
			<p *ngIf="attribution.errors?.maxlength">Attribution is too long.</p>
		</div>
	</div>
	<div class="form-group" [ngClass]="{ 'has-error': submitter.touched && submitter.invalid }">
		<label for="submitter">Submitter</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-user" aria-hidden="true"></i>
			</div>
			<input type="text" name="submitter" id="submitter" class="form-control" maxlength="64" required [(ngModel)]="misquote.submitter" #submitter="ngModel" />
		</div>
		<div [hidden]="submitter.valid || submitter.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="submitter.errors?.required">Submitter is required.</p>
			<p *ngIf="submitter.errors?.maxlength">Submitter is too long.</p>
		</div>
	</div>
	<button type="submit" class="btn btn-info btn-lg" [disabled]="misquoteForm.invalid"><i class="fa fa-share"></i> Misquote</button>
	<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i> Cancel</button>
</form>
<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>
<hr />
<h1>All Misquotes</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th><th>Edit</th></tr>
	<tr *ngFor="let misquote of misquotes">
		<td>{{ misquote.misquoteId }}</td>
		<td>{{ misquote.misquote }}</td>
		<td>{{ misquote.attribution }}</td>
		<td>{{ misquote.submitter }}</td>
		<td><a class="btn btn-warning" (click)="switchMisquote(misquote);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
	</tr>
</table>
