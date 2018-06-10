import {Component} from "@angular/core";
import {TruckService} from "../shared/services/truck.service";
import {ActivatedRoute} from "@angular/router";
import {OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Truck} from "../shared/classes/truck";
import {TruckVote} from "../shared/classes/truck.vote";
import {TruckCategory} from "../shared/classes/truckcategory";
import {IsOpen} from "../shared/classes/is-open";


@Component({

    template: require("./truck.component.html")
})

export class TruckComponent implements OnInit {

    categories: TruckCategory[] = [];
    status : Status = null;
    truck: Truck = new Truck("", "", "", IsOpen.Closed, 0, 0, "", "", "");
    truckVote: TruckVote = new TruckVote(0, 0);

    constructor(private router: ActivatedRoute, private truckService: TruckService) {

    }

    ngOnInit() : void {
    this.loadTruck();


    }

    loadTruck() : void {
        let truckId = this.router.snapshot.params["truckId"];
        this.truckService.getTruck(truckId).subscribe(reply => {
            this.truck = reply.truck;
            this.categories = reply.truckCategories;
            this.truckVote =  reply.truckVote;
        });
    }


}


