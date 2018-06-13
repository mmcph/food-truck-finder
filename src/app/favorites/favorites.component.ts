import {Component, OnInit} from "@angular/core";
import {Favorite} from "../shared/classes/favorite";
import {FavoriteService} from "../shared/services/favorite.service";
import {AuthService} from "../shared/services/auth.service";
import {FavoriteTruckName} from "../shared/classes/favoriteTruckName";




@Component ({

    template: require ("./favorites.component.html"),
})

export class FavoritesListComponent  {

    favorite : string = "";
    favorites : FavoriteTruckName[] = [];
    authToken  = this.jwt.decodeJwt();

    favoriteList : Favorite= new Favorite (null, null);


    constructor(private favoriteService: FavoriteService, private jwt : AuthService){

    }

    ngOnInit() : void {
        this.showFavorites()

    }

    showFavorites() : void {
        if(this.authToken) {
            this.favoriteService.getFavoriteByProfileId(this.authToken.auth.profileId)
                .subscribe(favorites => this.favorites = favorites);


        }
    }
}