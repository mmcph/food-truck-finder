//import all needed Angular dependencies
import {RouterModule, Routes} from "@angular/router";

// import all needed components
import {HomeComponent} from "./home/home.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {SignInComponent} from "./shared/components/navbar/sign-in.component";
import {TruckComponent} from "./truck/truck.component";


// import all needed services
import {AuthService} from "./shared/services/auth.service";
import {CategoryService} from "./shared/services/category.service";
import {FavoriteService} from "./shared/services/favorite.service";
import {ProfileService} from "./shared/services/profile.service";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign-in.service";
import {SignUpService} from "./shared/services/sign-up.service";
import {TruckCategoryService} from "./shared/services/truck.category.service";
import {TruckService} from "./shared/services/truck.service";
import {VoteService} from "./shared/services/vote.service";


// import all needed interceptors
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {APP_BASE_HREF} from "@angular/common";
import {NavbarComponent} from "./shared/components/navbar/navbar.component";
import {FooterComponent} from "./shared/components/footer/footer.component";
import {Truck} from "./shared/classes/truck";




export const allAppComponents = [HomeComponent, SignUpComponent, SignInComponent, NavbarComponent, FooterComponent, TruckComponent];

export const routes: Routes = [


    {path: "truck/:truckId", component: TruckComponent},
	{path: "sign-up", component: SignUpComponent},
    {path: "sign-in", component: SignInComponent},
    {path: "", component: HomeComponent},

];


const services : any[] = [SessionService, SignUpService, SignInService, TruckService];

const providers : any[] = [
    {provide: APP_BASE_HREF, useValue: window["_base_href"]},
    {provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},


];



export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);

