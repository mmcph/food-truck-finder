import {IsOpen} from"./is-open";


export class Truck {
	constructor(
		public truckId: string,
		public truckProfileId: string,
		public truckBio: string,
		public truckIsOpen: IsOpen,
		public truckLatitude: number,
		public truckLongitude: number,
		public truckName: string,
		public truckPhone: string,
		public truckUrl: string
	) {



	}
}


