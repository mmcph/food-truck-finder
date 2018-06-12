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
import {Vote} from "../shared/classes/vote";
import {VoteService} from "../shared/services/vote.service";
import {AuthService} from "../shared/services/auth.service";

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
    token : any = null;

    constructor(private router: ActivatedRoute, private truckService: TruckService, private favoriteService: FavoriteService, private voteService: VoteService, private authService: AuthService) {

    }

    ngOnInit() : void {
    this.token = this.authService.decodeJwt();
    this.loadTruck();
    this.loadFavorite();
    // this.loadVote();

    }

// grabs the truck object & assoc. votes & categories with it
    loadTruck() : void {
        this.truckService.getTruck(this.truckId).subscribe(reply => {
            this.truck = reply.truck;
            this.categories = reply.truckCategories;
            this.truckVote =  reply.truckVote;
        });

    }

// grab favorite if it exists
    loadFavorite() : void {this.favoriteService.getFavoriteByCompositeKey(this.token.auth.profileId, this.truckId).subscribe(reply => {

        if(!reply.favoriteTruckId ) {
            this.favorite = null;
        }else {
            this.favorite = reply;
        }
        })

    }

// allow user to favorite this truck; create a favorite
    createFavorite() : void {

        let favorite = new Favorite(null, this.truckId);
        this.favoriteService.createFavorite(favorite).subscribe(status => {
            this.status = status;
            this.loadFavorite();

        })
    }


// allow user to delete favorite
    deleteFavorite() : void  {

        this.favoriteService.deleteFavorite(this.favorite).subscribe(status => {
            this.status = status;

            this.loadFavorite();


            if(status.status === 200) {
                this.loadFavorite();
            }

        })

    }


    // grab votes if they exist
    // loadVote() : void {this.voteService.getVoteByCompositeKey(this.token.auth.profileId, this.truckId).subscribe(reply => {
    // }
    // })



    getVoteTruckId() : void {

        this.voteService.getTruckVote(this.truckId).subscribe(reply => {
            this.truckVote = reply;
        }
        )
    }


// allow user to vote
    createVote(voteValue : number) : void {
        let vote = new Vote(null, this.truckId, voteValue);
        this.voteService.createVote(vote).subscribe(status => {
            this.status = status;
            if (status.status === 200){
                this.getVoteTruckId()
            }
            }

        )};




}




