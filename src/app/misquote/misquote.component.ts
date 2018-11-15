import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {MisquoteService} from "../shared/services/misquote.service";
import {Misquote} from "../shared/interfaces/misquote";
import {Status} from "../shared/interfaces/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {faBan, faComment, faQuoteLeft, faShare, faTrash, faUser} from "@fortawesome/free-solid-svg-icons";

@Component({
	templateUrl: "./templates/misquote.html"
})

export class MisquoteComponent implements OnInit {
	misquoteForm: FormGroup;
	deleted: boolean = false;
	misquote: Misquote;
	status: Status = null;

	// fontawesome icons
	faBan = faBan;
	faComment = faComment;
	faQuoteLeft = faQuoteLeft;
	faShare = faShare;
	faTrash = faTrash;
	faUser = faUser;

	constructor(private formBuilder: FormBuilder, private misquoteService: MisquoteService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let misquoteId = params["misquoteId"];
			this.misquoteService.getMisquote(misquoteId)
				.subscribe(misquote => {
					this.misquote = misquote;
					this.misquoteForm.patchValue(misquote);
				});
		});
		this.misquoteForm = this.formBuilder.group({
			attribution: ["", [Validators.maxLength(64), Validators.required]],
			misquote: ["", [Validators.maxLength(255), Validators.required]],
			submitter: ["", [Validators.maxLength(64), Validators.required]]
		});
		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.misquoteForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.misquote[field] = values[field];
			}
		});
	}

	deleteMisquote() : void {
		this.misquoteService.deleteMisquote(this.misquote.misquoteId)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.deleted = true;
					this.misquote = {misquoteId: null, attribution: null, misquote: null, submitter: null};
				}
			});
	}

	editMisquote() : void {
		this.misquoteService.editMisquote(this.misquote)
			.subscribe(status => this.status = status);
	}
}
