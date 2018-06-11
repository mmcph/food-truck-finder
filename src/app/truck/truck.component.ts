import {Component, EventEmitter, Output} from "@angular/core";
import {TruckService} from "../shared/services/truck.service";
import {ActivatedRoute, Router} from "@angular/router";
import {OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Truck} from "../shared/classes/truck";
import {TruckVote} from "../shared/classes/truck.vote";
import {TruckCategory} from "../shared/classes/truckcategory";
import {IsOpen} from "../shared/classes/is-open";
import {FavoriteService} from "../shared/services/favorite.service";
import {Favorite} from "../shared/classes/favorite";


@Component({

    template: require("./truck.component.html")
})

export class TruckComponent implements OnInit {

    categories: TruckCategory[] = [];
    status : Status = null;
    truck: Truck = new Truck("", "", "", IsOpen.Closed, 0, 0, "", "", "");
    truckVote: TruckVote = new TruckVote(0, 0);
    truckId = this.router.snapshot.params["truckId"];
    favorite: Favorite = new Favorite("", "");

    constructor(private router: ActivatedRoute, private truckService: TruckService, private favoriteService: FavoriteService) {

    }

    ngOnInit() : void {
    this.loadTruck();

    // check if favorite exists
    if (Favorite) this.favoriteService.getFavoriteByCompositeKey("", "").subscribe(reply => {



    })

    }

// grabs the truck object & assoc. votes & categories with it
    loadTruck() : void {
        this.truckService.getTruck(this.truckId).subscribe(reply => {
            this.truck = reply.truck;
            this.categories = reply.truckCategories;
            this.truckVote =  reply.truckVote;
        });

    }

// grab favorite to see if already favorites or not
    loadFavorite() : void {

    }




// allow user to create or delete this favorite
    createFavorite() : void {

        let favorite = new Favorite(null, this.truckId);
        this.favoriteService.createFavorite(favorite).subscribe(status => this.status = status

        )
    }

}


