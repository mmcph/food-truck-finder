import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup,Validators} from "@angular/forms";
import {Router} from "@angular/router";

import {SignInService} from "../../services/sign-in.service";
import {SignIn} from "../../classes/sign-in";
import {Status} from "../../classes/status";

// set the template url and the selector for the ng powered html tag
@Component({
    template: require("./sign-in.component.html"),

})
export class SignInComponent implements OnInit {


    //  sign-in state variable

    // status variable needed for interacting with the API
    status : Status = null;
    signInForm : FormGroup;

    constructor(private formBuilder : FormBuilder, private router: Router, private signInService: SignInService) {

    }

    ngOnInit() : void {

        this.signInForm = this.formBuilder.group({

            profileEmail : ["",[Validators.email, Validators.required]],
            profilePassword: ["",[Validators.maxLength(97),Validators.required]],

        });

    }

    createSignIn() : void {

        window.localStorage.removeItem("jwt-token");

        let signIn = new SignIn(this.signInForm.value.profileEmail, this.signInForm.value.profilePassword);

        this.signInService.postSignIn(signIn)
            .subscribe(status=>{
                this.status = status;
                if(status.status === 200) {
                    alert(status.message);
                }
            });


    }
}

