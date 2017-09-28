import {Component, OnInit, ViewChild} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms"
import {Router} from "@angular/router";
import {MisquoteService} from "../services/misquote.service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "templates/misquote-list.html"
})

export class MisquoteListComponent implements OnInit {
	misquoteForm: FormGroup;
	misquotes: Misquote[] = [];
	misquote: Misquote = new Misquote(null, null, null, null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private misquoteService: MisquoteService, private router: Router) {}


	ngOnInit() : void {
		this.reloadMisquotes();
		this.misquoteForm = this.formBuilder.group({
			attribution: ["", Validators.required],
			misquote: ["", Validators.required],
			submitter: ["", Validators.required]
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
		this.misquoteService.createMisquote(this.misquote)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.reloadMisquotes();
					this.misquoteForm.reset();
				}
			});
	}
}
