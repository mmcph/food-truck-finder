import {Truck} from "./truck";
import {TruckCategory} from "./truckcategory";
import {TruckVote} from "./truck.vote";

export class TruckReply {


    constructor(public truck: Truck, public truckCategories : TruckCategory[], public truckVote : TruckVote) {



    }


}


