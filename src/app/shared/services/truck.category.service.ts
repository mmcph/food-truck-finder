import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {TruckCategory} from "../classes/truckCategory";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class TruckCategoryService {

	constructor(protected http : HttpClient ) {

	}
	private truckCategoryUrl = "/api/truckCategory/";


	//call the category API and create a new truck category
	createTruckCategory(truckCategory : TruckCategory) : Observable<Status> {
		return (this.http.post<Status>(this.truckCategoryUrl, truckCategory));
	}

	//grabs a  Truck Category based on its composite key
	getTruckCategoryByCompositeKey(truckCategoryTruckId : string, truckCategoryCategoryId : string) : Observable <truckCategory> {
		return (this.http.get<TruckCategory>(this.truckCategoryUrl+ "?truckCategoryTruckId=" + truckCategoryTruckId +"&truckCategoryCategoryId=" + truckCategoryCategoryId))
	}

	getTruckCategoryByTruckd (truckCategoryTruckId : string) : Observable<TruckCategory[]> {
		return(this.http.get<TruckCategory[]>(this.truckCategoryUrl + truckCategoryTruckId))
	}


}

