import {Response} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {HttpClient, HttpResponse} from "@angular/common/http";
import {Status} from "../classes/status";

export abstract class BaseService {
	constructor(protected http: HttpClient) {}

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

	protected extractMessage(response: Response) : Status {
		if(response.status < 200 || response.status >= 300) {
			throw(new Error("Bad response status: " + response.status))
		}

		let json = response.json();
		let jsonStatus = "alert-success";
		if(json.status !== 200) {
			jsonStatus = "alert-danger";
		}
		let status = new Status(json.status, json.message, jsonStatus);
		return(status);
	}

	protected handleError(error:any) {
		let message = error.message;
		console.log(message);
		return(Observable.throw(message));
	}
}
