import {Component} from "@angular/core";
import {TruckService} from "../shared/services/truck.service";
import {ActivatedRoute} from "@angular/router";
import {OnInit} from "@angular/core";
import {Status} from "../shared/classes/status";
import {Truck} from "../shared/classes/truck";

@Component({

    template: require("./truck.component.html"),

})

export class TruckComponent implements OnInit {

    status : Status = null;
    truck : Truck;

    constructor(private router: ActivatedRoute, private truckService: TruckService) {

    }

    ngOnInit() : void {
    this.loadTruck();

    }

    loadTruck() : void {

        let truckId = this.router.snapshot.params["truckId"];
        this.truckService.getTruck(truckId).subscribe(reply=>{

            this.truck = reply.truck;


        }
        
        );


    }


}


