import {Component, } from "@angular/core";


//declare $ for good old jquery
declare let $: any;

// set the template url and the selector for the ng powered html tag
@Component({
	template: require("./sign-up.component.html"),

})
export class SignUpComponent {



	constructor() {}

	ngOnInit(): void {

	}

}