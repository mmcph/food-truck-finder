import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NguiMapModule} from "@ngui/map";


const moduleDeclarations = [AppComponent];

@NgModule({
    imports:      [BrowserModule, HttpClientModule, routing, FormsModule, ReactiveFormsModule, NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyC3Bc97wjIqDbhwC4gSFz8xM0B4G8PAT-A'})],
    declarations: [...moduleDeclarations, ...allAppComponents],
    bootstrap:    [AppComponent],
    providers:    [...appRoutingProviders]
})
export class AppModule {}

