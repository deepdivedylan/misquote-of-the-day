import {Component, OnInit} from "@angular/core";
import {MisquoteService} from "../services/misquote-service";
import {Misquote} from "../classes/misquote";

@Component({
	templateUrl: "./templates/misquote-list.php"
})

export class MisquoteListComponent implements OnInit {
	misquotes: Misquote[] = [];

	constructor(private misquoteService: MisquoteService) {}

	ngOnInit() : void {
		this.reloadMisquotes();
	}

	reloadMisquotes() : void {
		this.misquoteService.getAllMisquotes()
			.subscribe(misquotes => this.misquotes = misquotes);
	}
}
