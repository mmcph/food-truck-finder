import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Status} from "../classes/status";
import {Favorite} from "../classes/favorite";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class FavoriteService {

	constructor(protected http : HttpClient ) {

	}

	//define the API endpoint
	private favoriteUrl = "/api/favorite/";


	//call the like API and create a new like
	createFavorite(favorite : Favorite) : Observable<Status> {
		return (this.http.post<Status>(this.favoriteUrl, favorite));
	}

	//grabs a  favorite based on its composite key
	getFavoriteByCompositeKey(favoriteProfileId : string, favoriteTruckId : string) : Observable <Favorite> {
		return (this.http.get<Favorite>(this.favoriteUrl+ "?favoriteProfileId=" + favoriteProfileId +"&favoriteTruckId=" + favoriteTruckId))
	}

	// getFavoriteByProfileId ( favoriteTruckId : string) : Observable <Favorite[]> {
	// 	return(this.http.get<Favorite[]>(this.favoriteUrl + favoriteTruckId))
	// }


// allow user to delete favorite
    deleteFavorite(favorite : Favorite) : Observable<Status> {
        return(this.http.put<Status>(this.favoriteUrl, favorite) );
    }


}