class Helper {

	convertToJson(formArray=[]) {
		let returnArray = {};

		for (let i = 0; i < formArray.length; i++){
			returnArray[formArray[i]['name']] = formArray[i]['value'];
		}

		return returnArray;
	}
}

export default Helper;