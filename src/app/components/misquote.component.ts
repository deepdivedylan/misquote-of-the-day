import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {MisquoteService} from "../services/misquote.service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/misquote.html"
})

export class MisquoteComponent implements OnInit {
	deleted: boolean = false;
	misquote: Misquote = new Misquote(null, null, null, null);
	status: Status = null;

	constructor(private misquoteService: MisquoteService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let misquoteId = params["misquoteId"];
			this.misquoteService.getMisquote(misquoteId)
				.subscribe(misquote => this.misquote = misquote);
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
