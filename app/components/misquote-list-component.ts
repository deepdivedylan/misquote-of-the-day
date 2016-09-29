import {Component, OnInit} from "@angular/core";
import {MisquoteService} from "../services/misquote-service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/misquote-list.php"
})

export class MisquoteListComponent implements OnInit {
	misquotes: Misquote[] = [];
	misquote: Misquote = new Misquote(0, "", "", "");
	status: Status = null;

	constructor(private misquoteService: MisquoteService) {}

	ngOnInit() : void {
		this.reloadMisquotes();
	}

	reloadMisquotes() : void {
		this.misquoteService.getAllMisquotes()
			.subscribe(misquotes => this.misquotes = misquotes);
	}

	createMisquote() : void {
		this.misquoteService.createMisquote(this.misquote)
			.subscribe(status => this.status = status);
	}
}
