import {RouterModule, Routes} from "@angular/router";
import {MisquoteComponent} from "./components/misquote-component";
import {MisquoteListComponent} from "./components/misquote-list-component";
import {SplashComponent} from "./components/splash-component";
import {MisquoteService} from "./services/misquote-service";
import {APP_BASE_HREF} from "@angular/common";


export const allAppComponents = [MisquoteComponent, MisquoteListComponent, SplashComponent];

export const routes: Routes = [
	{path: "misquote", component: MisquoteListComponent},
	{path: "misquote/:misquoteId", component: MisquoteComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	MisquoteService
];

export const routing = RouterModule.forRoot(routes);
