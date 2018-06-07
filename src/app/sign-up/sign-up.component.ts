import {Component, OnInit, ViewChild,} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {Router} from "@angular/router";
import {Status} from "../shared/classes/status";
import {SignUp} from "../shared/classes/sign.up";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign.up.service";

//declare $ for good old jquery
declare let $: any;

// set the template url and the selector for the ng powered html tag
@Component({
	template: require
	("./sign-up.component.html"),
	selector: "sign-up"
})
export class SignUpComponent implements OnInit {

	//
	signUpForm: FormGroup;

	signUp: SignUp = new SignUp(null, null, null, null, null);
	status: Status = null;


	constructor(private formBuilder: FormBuilder, private router: Router, private signUpService: SignUpService) {
	}

	ngOnInit(): void {

	}

	createSignUp(): void {


	}
}