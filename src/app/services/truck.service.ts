import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";

import {Status} from "../classes/status";
import {Profile} from "../classes/truck";
import {Observable} from "rxjs/Observable";

@Injectable()
export class TruckService {

    constructor(protected http: HttpClient) {

    }

    //define the API endpoint
    private truckUrl = "api/truck/";


    //reach out to the Truck API and create the truck (POST)
    createTruck(truck : Truck) : Observable<Status> {
        return(this.http.post<Status>(this.truckUrl, truck));
    }

    // call to the Truck API to grab the truck in question and edit it (PUT)
    editTruck(truck : Truck) : Observable<Status> {
        return(this.http.put<Status>(this.truckUrl + truck.truckId, truck));
    }

    //reach out to the Truck API and delete the truck in question (DELETE)
    deleteTruck(truckId : string) : Observable<Status> {
        return(this.http.delete<Status>(this.truckUrl + id));
    }

    // call to the Truck API and get a truck object by its truckId (GET specific truck)
    getTruck(id : string) : Observable<Truck> {
        return(this.http.get<Truck>(this.truckUrl + id));
    }

    // call to the Truck API and grab the corresponding truck by its _____? (GET array)



    // call to the Truck API and grab the corresponding truck by its _____? (GET array)







}