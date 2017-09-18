import {Injectable} from "@angular/core";
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs/Observable";

@Injectable()
export class DataIntercept implements HttpInterceptor {
	intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		return(next.handle(request).map((event: HttpEvent<any>) => {
			if(event instanceof HttpResponse) {
				console.log(request);
				console.log(event);
				let dataEvent = event;
				if(event.status === 200) {
					let body = event.body;
					if(body.status === 200) {
						dataEvent = event.clone({body: body.data});
						console.log("cloning");
					}
				}
				console.log(dataEvent);
				return(dataEvent);
			}
		}));
	}
}