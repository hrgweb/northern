export class DateClass {
	constructor(datetime) {
		this.datetime = new Date(datetime); 
	}

	onlyDate() {
		let date = this.datetime;
		let year = date.getFullYear();
		let month = parseInt(date.getMonth(), 10) + 1;
		let day = (parseInt(date.getDate(), 10) < 10) ? '0' + date.getDate() : date.getDate();

		// add 1 to month since 0-11
		month = (++month < 10) ? '0' + month : month;

		return `${year}-${month}-${day}`;
	}

	greet() {
		console.log('greetings from date.js file');
	}
}