import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";

export abstract class BaseService {
	constructor(protected http: Http) {}

	protected extractData(response: Response) : any {
		if(response.status < 200 || response.status >= 300) {
			throw(new Error("Bad response status: " + response.status))
		}

		let json = response.json();
		if(json.status !== 200) {
			throw(new Error("Bad API status: " + json.status));
		}
		return(json.data);
	}

	protected handleError(error:any) {
		let message = error.message;
		console.log(message);
		return(Observable.throw(message));
	}
}
