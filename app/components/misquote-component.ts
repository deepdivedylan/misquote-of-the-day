import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {MisquoteService} from "../services/misquote-service";
import {Misquote} from "../classes/misquote";

@Component({
	templateUrl: "./templates/misquote.php"
})

export class MisquoteComponent implements OnInit {
	misquote: Misquote = new Misquote(0, "", "", "");

	constructor(private misquoteService: MisquoteService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let misquoteId = +params["misquoteId"];
			this.misquoteService.getMisquote(misquoteId)
				.subscribe(misquote => this.misquote = misquote);
		});
	}
}
