import {Injectable} from "@angular/core";
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs/Observable";

@Injectable()
export class DataIntercept implements HttpInterceptor {

	intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		// hand off to the next interceptor
		return(next.handle(request).map((event: HttpEvent<any>) => {
			// if this is an HTTP Response, from Angular...
			if(event instanceof HttpResponse) {
				console.log(request);
				console.log(event);
				// create an event to return (by default, return the same event)
				let dataEvent = event;

				// if the API is successful...
				if(event.status === 200) {

					// extract the data or message from the response body
					let body = event.body;
					if(body.status === 200) {
						if(body.data) {
							// extract data returned from a GET request
							dataEvent = event.clone({body: body.data});
						} else if(body.message) {
							// extract a successful message
							dataEvent = event.clone({body: {message: body.message, status: 200, type: "alert-success"}});
						}
					} else {
						// extract a failing message when the API fails
						dataEvent = event.clone({body: {message: body.message, status: body.status, type: "alert-danger"}});
					}
				} else {
					// extract a failing message when the web server fails
					dataEvent = event.clone({body: {message: event.statusText, status: event.status, type: "alert-danger"}});
				}
				return(dataEvent);
			}
		}));
	}
}