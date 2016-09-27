<div *ngIf = "deleted === false">
	<h1>Misquote {{ misquote.misquoteId }}</h1>
	<blockquote>
		<p>{{ misquote.misquote }}</p>
		<footer>
			{{ misquote.attribution }} <cite>added by {{ misquote.submitter }}</cite>
		</footer>
	</blockquote>
	<form #misquoteForm="ngForm" name="misquoteForm" id="misquoteForm" class="form-horizontal well" (ngSubmit)="editMisquote();" novalidate>
		<h2>Edit Misquote</h2>
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
				<p *ngIf="misquoteText.errors?.maxlength">Misquote is too long.</p>
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
		<button type="button" class="btn btn-danger btn-lg" (click)="deleteMisquote();"><i class="fa fa-trash"></i> Delete Misquote</button>
	</form>
</div>
<div *ngIf="deleted === true">
	<h1>Deleted Misquote</h1>
	<p><em>You just deleted this misquote. How dare you!</em> <a routerLink="/misquote">Go back from whence you came</a>.</p>
</div>
<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
	<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>
