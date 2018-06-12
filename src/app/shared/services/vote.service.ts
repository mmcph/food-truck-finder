import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../classes/status";
import {Vote} from "../classes/vote";
import {Observable} from "rxjs/Observable";
import {TruckVote} from "../classes/truck.vote";

@Injectable ()
export class VoteService {

    constructor(protected http : HttpClient) {

    }

    // define the API endpoint
    private voteUrl = "/api/vote/";

    // call the vote API and create a new vote (POST)
    createVote(vote : Vote) : Observable<Status> {
        return (this.http.post<Status>(this.voteUrl, vote));

    }

    // call the vote API and delete a vote (DELETE)
    // deleteVote(vote : Vote) : Observable<Status> {
    //     return (this.http.delete<Status>(this.voteUrl + vote));
    //
    // }

    // grabs a vote based on its composite key (GET)
    getVoteByCompositeKey(voteProfileId : string, voteTruckId : string) : Observable <Vote> {
        return (this.http.get<Vote>(this.voteUrl + "?voteProfileId=" + voteProfileId + "&voteTruckId=" + voteTruckId ));
    }


    getTruckVote(voteTruckId : string) : Observable <TruckVote> {
        return (this.http.get<TruckVote>(this.voteUrl + "?voteTruckId=" + voteTruckId));

    }


}