import {Component, EventEmitter, Output} from "@angular/core";
import {TruckService} from "../shared/services/truck.service";
import {ActivatedRoute, Router} from "@angular/router";
import {OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Truck} from "../shared/classes/truck";
import {TruckVote} from "../shared/classes/truck.vote";
import {TruckCategoryService} from "../shared/services/truck.category.service";
import {TruckCategory} from "../shared/classes/truckcategory";
import {IsOpen} from "../shared/classes/is-open";
import {FavoriteService} from "../shared/services/favorite.service";
import {Favorite} from "../shared/classes/favorite";
import {Vote} from "../shared/classes/vote";
import {VoteService} from "../shared/services/vote.service";
import {AuthService} from "../shared/services/auth.service";
import {literalArr} from "@angular/compiler/src/output/output_ast";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/classes/category";
import {FormGroup, Validators} from "@angular/forms";
import {FormBuilder} from "@angular/forms";
import {SignUp} from "../shared/classes/sign-up";

@Component({

    template: require("./truck.component.html")
})

export class TruckComponent implements OnInit {

    categories : Category[] = [];
    truckCategories: TruckCategory[] = [];
    status : Status = null;
    truck: Truck = new Truck("", "", "", IsOpen.Closed, 0, 0, "", "", "");
    truckVote: TruckVote = new TruckVote(0, 0);
    truckId = this.router.snapshot.params["truckId"];
    favorite: Favorite = new Favorite("", "");
    token : any = null;
    truckEdit: FormGroup;

    constructor(private router: ActivatedRoute, private formBuilder : FormBuilder, private truckService: TruckService, private favoriteService: FavoriteService, private voteService: VoteService, private authService: AuthService, private truckCategoryService: TruckCategoryService, private categoryService: CategoryService) {

    }

    ngOnInit() : void {
    this.token = this.authService.decodeJwt();
    this.loadTruck();
    this.loadFavorite();

    this.getTruckCategory();

    this.truckEdit = this.formBuilder.group({

       truckPhone : ["",[Validators.maxLength(24),Validators.required]],
		 truckUrl : ["",[Validators.maxLength(128),Validators.required]],
		 truckBio : ["",[Validators.maxLength(1024),Validators.required]]
		 });

		 console.log(this.truckEdit)
	 }






   loadTruck() : void {
        this.truckService.getTruck(this.truckId).subscribe(reply => {
            this.truck = reply.truck;
            this.truckCategories = reply.truckCategories;
            this.truckVote =  reply.truckVote;
        });

    }

// grab favorite if it exists


    loadFavorite() : void {

        if(this.token) {
            this.favoriteService.getFavoriteByCompositeKey(this.token.auth.profileId, this.truckId).subscribe(reply => {

                if (!reply.favoriteTruckId) {
                    this.favorite = null;
                } else {
                    this.favorite = reply;
                }
            })
        }

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

    // display categories of food that the truck serves; get an array of category objects


    getTruckCategory() : void {


        this.categoryService.getAllCategories().subscribe(reply => { this.categories = reply;});

        console.log(this.categories);

       this. truckCategories.forEach(function (element) {
            console.log(element);


        });

       }

	truckEditMethod() : void {

		//create truck object from updated form values
		let truck = new Truck(this.truckId, null, this.truckEdit.value.truckBio, null, null, null, null, this.truckEdit.value.truckPhone, this.truckEdit.value.truckUrl);

		this.truckService.editTruck(truck).subscribe(status => {
			this.status = status;
			if (status.status === 200){
				this.loadTruck()
			}
		})
	}

}






