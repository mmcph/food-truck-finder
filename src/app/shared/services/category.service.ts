import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Category} from "..classes/category";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class CategoryService {

    constructor(protected http: HttpClient) {

    }

    // define the API endpoint
    private categoryUrl = "/api/category";


    // call the category API and create a new Category
    createCategory(category : Category) : Observable<Status> {
        return (this.http.post<Status>(this.categoryUrl, category));

    }

    // grabs a category based on its composite key
    get



}