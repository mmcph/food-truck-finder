import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup,Validators} from "@angular/forms";
import {Status} from "../shared/classes/status";
import {SignUpService} from "../shared/services/sign.up.service";
import {Router} from "@angular/router";
import {SignUp} from "../shared/classes/sign.up";


// set the template url and the selector for the ng powered html tag
@Component({
    template: require("./sign-up.component.html"),

})
export class SignUpComponent implements OnInit {


    //  sign-up state variable

    // status variable needed for interacting with the API
    status : Status = null;
    signUpForm : FormGroup;

    constructor(private formBuilder : FormBuilder, private router: Router, private signUpService: SignUpService) {

    }

    ngOnInit() {

        this.signUpForm = this.formBuilder.group({

            profileFirstName : ["",[Validators.maxLength(64),Validators.required]],
            profileLastName : ["",[Validators.maxLength(64),Validators.required]],
            profileUserName : ["",[Validators.maxLength(32),Validators.required]],
            profileEmail : ["",[Validators.email, Validators.required]],
            profilePassword: ["",[Validators.required]],
            profilePasswordConfirm : ["",[Validators.maxLength(97),Validators.required]],

        });

    }

    createProfile() : void {

        let signUp = new SignUp(this.signUpForm.value.profileFirstName, this.signUpForm.value.profileLastName, this.signUpForm.value.profileUserName, this.signUpForm.value.profileEmail, this.signUpForm.value.profilePassword, this.signUpForm.value.profilePasswordConfirm);

        this.signUpService.createProfile(signUp)
            .subscribe(status=>{
            this.status = status;
            if(status.status === 200) {
                alert(status.message);
            }
        });


    }
}

