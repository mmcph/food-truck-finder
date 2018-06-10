import {Pipe, PipeTransform} from "@angular/core";
import {IsOpen} from "./is-open";


@Pipe({
    name: 'open'
})


export class OpenPipe implements PipeTransform {
    transform(value: IsOpen) : string {
        if(IsOpen.Open === value){
            return "Open";
        } else {
            return "Closed";
        }

    }

}