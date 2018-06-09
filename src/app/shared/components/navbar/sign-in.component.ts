import {Component, ViewChild, EventEmitter, Output } from "@angular/core";

import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../../classes/status";

import {SignIn} from "../../classes/sign-in";
import {CookieService} from "ng2-cookies";

// import sign-in svc

// what?
declare var $: any;

@Component({
    template: require("./signin.html"),
    selector: "signin"
})

export class SignInComponent {
    @ViewChild("signInForm") signInForm: any;

    signin: SignIn = new SignIn(null, null);
    status: Status = null;

    constructor(private SignInService: SignInService, private router: Router, private cookieService: CookieService) {

    }

    signIn() : void {
        localStorage.removeItem("jwt-token");
        this.SignInService.postSignIn(this.signin).subscribe(status => {
            this.status = status;



            if(status.status === 200) {

                this.router.navigate([profile - page]);
                this.signInForm.reset();
                setTimeout(function () {
                    $("#sign-in.modal").modal('hide');
                }, 1000);
            } else {
                console.log("failed login")

            }

        });
    }

}