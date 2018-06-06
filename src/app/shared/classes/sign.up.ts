export class SignUp {
	constructor(
		public profileId: string,
		public profileActivationToken: string,
		public profileEmail: string,
		public profileHash: string,
		public profileIsOwner: string,
		public profileFirstName: string,
		public profileLastName: string,
		public profileUserName: string,
	) {}
}