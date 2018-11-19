import {RouterModule, Routes} from "@angular/router";
import {MisquoteComponent} from "./misquote/misquote.component";
import {MisquoteListComponent} from "./misquote-list/misquote.list.component";
import {SplashComponent} from "./splash/splash.component";
import {MisquoteService} from "./shared/services/misquote.service";
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";

export const allAppComponents = [MisquoteComponent, MisquoteListComponent, SplashComponent];

export const routes: Routes = [
	{path: "misquote", component: MisquoteListComponent},
	{path: "misquote/:misquoteId", component: MisquoteComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	MisquoteService
];

export const routing = RouterModule.forRoot(routes);
