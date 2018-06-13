import {Component, OnInit} from "@angular/core";
import {Favorite} from "../shared/classes/favorite";
import {FavoriteService} from "../shared/services/favorite.service";
import {AuthService} from "../shared/services/auth.service";




@Component ({

    template: require ("./favorites.component.html"),
})

export class FavoritesListComponent  {

    favorite : string = "";
    favorites : Favorite[] = [];
    authToken  = this.jwt.decodeJwt();

    favoritesList : Favorite= new Favorite (null, null);


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