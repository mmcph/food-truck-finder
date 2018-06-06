export class Profile {
	constructor(
		public profileId: string,
		public profileEmail: string,
		public profileHash: string,
		public profileIsOwner: number,
		public profileFirstName: string,
		public profileLastName: string,
		public profileUserName: string
	) {}
}