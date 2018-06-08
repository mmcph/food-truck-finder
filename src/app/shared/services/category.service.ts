import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {Category} from "../classes/category";

@Injectable ()
export class CategoryService {

    constructor(protected http: HttpClient) {

    }

    // define the API endpoint
    private categoryUrl = "/api/category";


    // call the category API and create a new Category
    private createCategory(category: Category) : Observable<Status> {
        return (this.http.post<Status>(this.categoryUrl, category));

    }

    // grabs a category and deletes it -- commented out because API *should* only have GET per ASANA ticket, but it seems like we want delete. API needs to be cleaned up and tested.
    // deleteCategory(categoryId : string) : Observable<Status> {
    //     return (this.http.delete<Status>(this.categoryUrl + categoryId));
    //
    // }



}