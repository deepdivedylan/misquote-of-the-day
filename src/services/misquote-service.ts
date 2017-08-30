import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Misquote} from "../classes/misquote";
import {Status} from "../classes/status";

@Injectable()
export class MisquoteService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private misquoteUrl = "api/misquote/";

	deleteMisquote(misquoteId: number) : Observable<Status> {
		return(this.http.delete(this.misquoteUrl + misquoteId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllMisquotes() : Observable<Misquote[]> {
		return(this.http.get(this.misquoteUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getMisquote(misquoteId: number) : Observable<Misquote> {
		return(this.http.get(this.misquoteUrl + misquoteId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createMisquote(misquote: Misquote) : Observable<Status> {
		return(this.http.post(this.misquoteUrl, misquote)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editMisquote(misquote: Misquote) : Observable<Status> {
		return(this.http.put(this.misquoteUrl + misquote.misquoteId, misquote)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}
