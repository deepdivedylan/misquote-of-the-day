import {RouterModule, Routes} from "@angular/router";
import {MisquoteComponent} from "./components/misquote-component";
import {SplashComponent} from "./components/splash-component";


export const allAppComponents = [MisquoteComponent, SplashComponent];

export const routes: Routes = [
	{path: "misquote", component: MisquoteComponent},
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);
