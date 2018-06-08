import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./home/home.component";
import {APP_BASE_HREF} from "@angular/common";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {SignUpService} from "./shared/services/sign.up.service";


export const allAppComponents = [HomeComponent, SignUpComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "sign-up", component: SignUpComponent}
];

export const appRoutingProviders: any[] = [
    {provide: APP_BASE_HREF, useValue: window["_base_href"]},
    {provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
    SignUpService,


];

export const routing = RouterModule.forRoot(routes);

