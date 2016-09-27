import {RouterModule, Routes} from "@angular/router";
import {MisquoteComponent} from "./components/misquote-component";
import {MisquoteListComponent} from "./components/misquote-list-component";
import {SplashComponent} from "./components/splash-component";


export const allAppComponents = [MisquoteComponent, MisquoteListComponent, SplashComponent];

export const routes: Routes = [
	{path: "misquote", component: MisquoteListComponent},
	{path: "misquote/:misquoteId", component: MisquoteComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
