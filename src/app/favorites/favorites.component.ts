import {Component, OnInit} from "@angular/core";
import {Favorite} from "../shared/classes/favorite";
import {FavoriteService} from "../shared/services/favorite.service";




@Component ({

    template: require ("./favorites.component.html"),
})

export class FavoritesListComponent  {

    // favorite : string = "";
    // favorites : Favorites[] = [];
    //
    // favoritesList : Favorites = new Favorite (null, null);
    //
    //
    // constructor(private favoriteService: FavoriteService){
    //
    // }
    //
    // ngOnInit() : void {
    //     this.showFavorites()
    // }
    //
    // showFavorites() : void {
    //     this.favoriteService.getFavoriteByProfileId()
    //         .subscribe(favorites => this.favorites = favorites);
    //
    // }
}