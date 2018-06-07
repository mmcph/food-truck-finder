import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./home/home.component";
import {APP_BASE_HREF} from "@angular/common";
import {SignUpComponent} from "./sign-up/sign-up.component";


export const allAppComponents = [HomeComponent];

export const routes: Routes = [
    {path: "sign-up", component: SignUpComponent},
    {path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [
    {provide: APP_BASE_HREF, useValue: window["_base_href"]},
    {}
];

export const routing = RouterModule.forRoot(routes);