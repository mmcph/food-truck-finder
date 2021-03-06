import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup,Validators} from "@angular/forms";
import {Status} from "../shared/classes/status";
import {Router} from "@angular/router";
import {TruckService} from "../shared/services/truck.service";
import {Truck} from "../shared/classes/truck";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/classes/category";

@Component({
	template: require("./new-truck-form.component.html"),
})
export class NewTruckFormComponent  implements OnInit{

	//  new truck form state variable

	// status variable needed for interacting with the API
	status : Status = null;
	newTruckForm : FormGroup;

	Categories : Category[] = [];



	constructor(private formBuilder : FormBuilder, private router: Router, private truckService: TruckService, private categoryService: CategoryService) {

	}

	ngOnInit() : void {

		this.newTruckForm = this.formBuilder.group({

			truckBio : ["",[Validators.maxLength(1024),Validators.required]],
			truckName: ["",[Validators.maxLength(64),Validators.required]],
			truckPhone: ["",[Validators.maxLength(24),Validators.required]],
			truckUrl: ["",[Validators.maxLength(128),Validators.required]],

		});
		// this.getAllCategories();
	}

	createNewTruckForm() : void {

		let newTruck = new Truck(null, null, this.newTruckForm.value.truckBio, null,35, -106, this.newTruckForm.value.truckName, this.newTruckForm.value.truckPhone, this.newTruckForm.value.truckUrl);

		this.truckService.createTruck(newTruck)
			.subscribe(status=>{
				this.status = status;
				if(status.status === 200) {
					alert(status.message);
				}
			});
	}

	// getAllCategories() : void {
	// 	this.categoryService.getAllCategories().subscribe(reply => this.Categories = reply)
	// }
}