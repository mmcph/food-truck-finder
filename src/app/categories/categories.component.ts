import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup,Validators} from "@angular/forms";
import {Status} from "../shared/classes/status";
import {Router} from "@angular/router";
import {TruckService} from "../shared/services/truck.service";
import {Truck} from "../shared/classes/truck";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/classes/category";
import {TruckCategoryService} from "../shared/services/truck.category.service";
import {TruckCategory} from "../shared/classes/truckcategory";


@Component ({

	template: require ("./categories.component.html"),
})
export class CategoriesComponent {

}

export class CategorySearchFormComponent  implements OnInit {

	// status variable needed for interacting with the API
	status: Status = null;
	categorySearchForm: FormGroup;



	constructor(private formBuilder: FormBuilder, private router: Router, private truckService: TruckService, private categoryService: CategoryService) {

	}

	ngOnInit(): void {

		this.categorySearchForm = this.formBuilder.group({

			// NEED TO BUILD ARRAY OF CATEGORY IDs SENT FROM FRONT END SEARCH.

		});

	}

	getTrucksByCategories(): void {

		let searchArray = [];

		for(i=0; i<=searchTerms.length; i++){
			searchArray.push(searchTerms[i]);
		}

		this.truckService.getCategoriesAndTrucksByCategoryId(searchArray)
	}
}