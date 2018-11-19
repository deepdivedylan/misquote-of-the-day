import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {ReactiveFormsModule} from "@angular/forms";
import {AppComponent} from "./app.component";
import {FontAwesomeModule} from "@fortawesome/angular-fontawesome";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, ReactiveFormsModule, HttpClientModule, FontAwesomeModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})
export class AppModule {}
