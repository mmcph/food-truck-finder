import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {OpenPipe} from "./shared/classes/open.pipe";
import {JwtModule} from "@auth0/angular-jwt";
// import {NguiMapModule} from "@ngui/map";


const moduleDeclarations = [AppComponent, OpenPipe];

const JwtHelper = JwtModule.forRoot({
    config: {
        tokenGetter: () => {
            return localStorage.getItem("jwt-token");
        },
        skipWhenExpired:true,
        whitelistedDomains: ["localhost:7272", "https://bootcamp-coders.cnm.edu/"],
        headerName:"X-JWT-TOKEN",
        authScheme: ""
    }
});

@NgModule({
    imports:      [BrowserModule, HttpClientModule, routing, FormsModule, ReactiveFormsModule, JwtHelper],
    declarations: [...moduleDeclarations, ...allAppComponents],
    bootstrap:    [AppComponent],
    providers:    [...appRoutingProviders]
})
export class AppModule {}
