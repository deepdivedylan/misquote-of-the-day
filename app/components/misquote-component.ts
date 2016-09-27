import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {MisquoteService} from "../services/misquote-service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/misquote.php"
})

export class MisquoteComponent implements OnInit {
	misquote: Misquote = new Misquote(0, "", "", "");
	status: Status = null;

	constructor(private misquoteService: MisquoteService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let misquoteId = +params["misquoteId"];
			this.misquoteService.getMisquote(misquoteId)
				.subscribe(misquote => this.misquote = misquote);
		});
	}

	editMisquote() : void {
		this.misquoteService.editMisquote(this.misquote)
			.subscribe(status => this.status = status);
	}
}
