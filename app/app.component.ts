import {Component} from "@angular/core";

@Component({
	selector: 'misquote-app',
	templateUrl: './templates/misquote-app.php'
})

export class AppComponent {
	navCollapse = true;

	toggleCollapse() {
		this.navCollapse = !this.navCollapse;
	}
}
