import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Misquote} from "../classes/misquote";

@Injectable()
export class DicewareService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private dicewareUrl = "api/misquote/";

	getAllDiceware() : Observable<Misquote[]> {
		return(this.http.get(this.dicewareUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}
