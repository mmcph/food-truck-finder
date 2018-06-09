import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {SignIn} from "../classes/sign-in";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class SignInService {
	constructor(protected http: HttpClient) {

	}

	private signInUrl = "api/sign-in/";
	private signOutUrl = "api/sign-out";



	postSignIn(signIn:SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.signInUrl, signIn));
	}

	signOut():Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl));
	}

}
