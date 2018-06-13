
import {Component, OnInit} from "@angular/core";
import {Truck} from "../shared/classes/truck";
import {TruckService} from "../shared/services/truck.service";
import {Router} from "@angular/router";
import {FormGroup, Validators, FormBuilder} from "@angular/forms";

@Component({
	template: require("./home.html")

})

export class HomeComponent implements OnInit{

	truck : string = "";
	trucks : Truck[] = [];
	 truckSearchForm : FormGroup;

	detailedTruck : Truck = new Truck(null, null, null, null, null, null,null, null, null);



	constructor(private truckService: TruckService, private router: Router,private formBuilder: FormBuilder){

	}

	ngOnInit() : void {
		this.showTrucks();

		this.truckSearchForm = this.formBuilder.group({
			truckSearchName: ["",[Validators.maxLength(140), Validators.minLength(1)]]
		});

	}

	showTrucks() : void {
        this.truckService.getTruckByTruckIsOpen()
            .subscribe(trucks => this.trucks = trucks);

	}

    clicked({target: marker} : any, truck : Truck) {

		this.detailedTruck = truck;

		marker.nguiMapComponent.openInfoWindow('detailedTruck', marker);
	}

	getTrucksByTruckName() : void{
		this.truckService.getTruckByTruckName(this.truckSearchForm.value.truckSearchName).subscribe(reply=>this.trucks=reply)
	}

}