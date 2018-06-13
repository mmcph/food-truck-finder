
import {Component, OnInit} from "@angular/core";
import {Truck} from "../shared/classes/truck";
import {TruckService} from "../shared/services/truck.service";
import {Router} from "@angular/router";

@Component({
	template: require("./home.html")

})

export class HomeComponent implements OnInit{

	truck : string = "";
	trucks : Truck[] = [];

	detailedTruck : Truck = new Truck(null, null, null, null, null, null,null, null, null);


	constructor(private truckService: TruckService, public router: Router){

	}

	ngOnInit() : void {
		this.showTrucks()


	}

	showTrucks() : void {
        this.truckService.getTruckByTruckIsOpen()
            .subscribe(trucks => this.trucks = trucks);

	}


}