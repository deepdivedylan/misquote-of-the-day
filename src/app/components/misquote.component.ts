import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {MisquoteService} from "../services/misquote.service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({
	templateUrl: "./templates/misquote.html"
})

export class MisquoteComponent implements OnInit {
	misquoteForm: FormGroup;
	deleted: boolean = false;
	misquote: Misquote = new Misquote(null, null, null, null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private misquoteService: MisquoteService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let misquoteId = params["misquoteId"];
			this.misquoteService.getMisquote(misquoteId)
				.subscribe(misquote => this.misquote = misquote);
		});
		this.misquoteForm = this.formBuilder.group({
			attribution: ["", Validators.required],
			misquote: ["", Validators.required],
			submitter: ["", Validators.required]
		});
	}

	deleteMisquote() : void {
		this.misquoteService.deleteMisquote(this.misquote.misquoteId)
			.subscribe(status => {
				this.deleted = true;
				this.status = status;
				this.misquote = new Misquote(null, null, null, null);
			});
	}

	editMisquote() : void {
		this.misquoteService.editMisquote(this.misquote)
			.subscribe(status => this.status = status);
	}
}
