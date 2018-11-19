import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms"
import {Router} from "@angular/router";
import {MisquoteService} from "../shared/services/misquote.service";
import {Misquote} from "../shared/interfaces/misquote";
import {Status} from "../shared/interfaces/status";
import {faBan, faComment, faPencilAlt, faQuoteLeft, faShare, faUser} from "@fortawesome/free-solid-svg-icons";

@Component({
	template: require("./misquote-list.html")
})

export class MisquoteListComponent implements OnInit {
	misquoteForm: FormGroup;
	misquotes: Misquote[] = [];
	status: Status = null;

	// fontawesome icons
	faBan = faBan;
	faComment = faComment;
	faPencilAlt = faPencilAlt;
	faQuoteLeft = faQuoteLeft;
	faShare = faShare;
	faUser = faUser;

	constructor(private formBuilder: FormBuilder, private misquoteService: MisquoteService, private router: Router) {}


	ngOnInit() : void {
		this.reloadMisquotes();
		this.misquoteForm = this.formBuilder.group({
			attribution: ["", [Validators.maxLength(64), Validators.required]],
			misquote: ["", [Validators.maxLength(255), Validators.required]],
			submitter: ["", [Validators.maxLength(64), Validators.required]]
		});
	}

	reloadMisquotes() : void {
		this.misquoteService.getAllMisquotes()
			.subscribe(misquotes => this.misquotes = misquotes);
	}

	switchMisquote(misquote : Misquote) : void {
		this.router.navigate(["/misquote/", misquote.misquoteId]);
	}

	createMisquote() : void {
		let misquote = {misquoteId: null, attribution: this.misquoteForm.value.attribution, misquote: this.misquoteForm.value.misquote, submitter: this.misquoteForm.value.submitter};
		this.misquoteService.createMisquote(misquote)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadMisquotes();
					this.misquoteForm.reset();
				}
			});
	}
}
