import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup} from "@angular/forms";
import {Status} from "../shared/classes/status";
import {Router} from "@angular/router";
import {TruckService} from "../shared/services/truck.service";
import {Truck} from "../shared/classes/truck";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/classes/category";



@Component ({

	template: require ("./categories.component.html"),
})
export class CategoriesComponent implements OnInit {

	status: Status = null;
	categorySearchForm: FormGroup;
	category: string = "";
	categories: Category[] = [];
	allCategories: any[] = [];
	categorySearchArray: number[] = [];
	truckResults : any[] = [];


	constructor(private formBuilder: FormBuilder, private router: Router, private truckService: TruckService, private categoryService: CategoryService) {

	}

	ngOnInit(): void {

		this.categorySearchForm = this.formBuilder.group({

		});

		this.loadCategories();

	}

	loadCategories() {
		this.categoryService.getAllCategories().subscribe(reply => {

			// console.log(reply);
			this.allCategories = reply;
		});
		// console.log(this.allCategories);
	}

	setTacoTruckCategory(event: any) {
		let checked = event.target.checked;
		let categoryId = +event.target.value;

		if(checked === true) {
			this.categorySearchArray.push(categoryId);
		} else {
			this.categorySearchArray = this.categorySearchArray.filter(category => category !== categoryId);
		}
		return (this.categorySearchArray);
	}


	getMatchingTrucks() {

		let truckResults = this.truckService.getCategoriesAndTrucksByCategoryId(this.categorySearchArray);


		console.log(truckResults);
		return truckResults;

	}
}