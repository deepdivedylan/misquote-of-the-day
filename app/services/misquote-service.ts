import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Misquote} from "../classes/misquote";

@Injectable()
export class MisquoteService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private misquoteUrl = "api/misquote/";

	getAllMisquotes() : Observable<Misquote[]> {
		return(this.http.get(this.misquoteUrl)
			.map((json: any) => json.data as Misquote[])
			.catch(this.handleError));
	}

	getMisquote(misquoteId: number) : Observable<Misquote> {
		return(this.http.get(this.misquoteUrl + misquoteId)
			.map((json: any) => json.data as Misquote)
			.catch(this.handleError));
	}
}
