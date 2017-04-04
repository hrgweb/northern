<template>
	<div class="customer-create">
		<form method="POST" class="form-inline" id="customer-create" role="form">
			<legend>Enter new customer details</legend>

			<!-- sanitize against attacks -->
			<input type="hidden" name="_token" :value="token">

			<div class="customer-create__primary-info">
				<!-- id -->
				<!-- <label for="id">ID</label> -->
				<!-- <input type="text" name="id" class="form-control"> -->

				<!-- ic -->
				<label for="ic">IC</label>
				<input type="text" name="ic" class="form-control">

				<!-- salutation -->
				<label for="salutation">Salutation</label>
				<select name="salutation" class="form-control">
					<option value="MR">MR</option>
					<option value="MS">MS</option>
					<option value="MRS">MRS</option>
					<option value="MDM">MDM</option>
					<option value="DR">DR</option>
				</select> <br><br>

				<div class="customer-create__name">
					<!-- surname -->
					<label for="surname">Surname</label>
					<input type="text" name="surname" class="form-control">

					<!-- firstname -->
					<label for="firstname">Firstname</label>
					<input type="text" name="firstname" class="form-control">
				</div>
			</div>

			<div class="customer-create__address">
				<h3>Address</h3>

				<!-- block -->
				<label for="block">Block / House no</label>
				<input type="text" name="block" class="form-control">

				<!-- unit_no -->
				<label for="unit_no">Unit Number</label>
				<input type="text" name="unit_no" class="form-control"> <br>

				<!-- building -->
				<label for="building">Building</label>
				<input type="text" name="building" class="form-control"> <br>

				<!-- street -->
				<label for="street">Street</label>
				<input type="text" name="street" class="form-control"> <br>

				<!-- country -->
				<label for="country">Country</label>
				<select name="country" class="form-control">
					<option value="singapore">Singapore</option>
					<option value="other">Other</option>
				</select>

				<!-- postcode -->
				<label for="postcode">Postcode</label>
				<input type="text" name="postcode" class="form-control">
			</div>

			<div class="customer-create__other">
				<h3>Other Information</h3>

				<!-- dob -->
				<label for="dob">DOB</label>
				<input type="date" name="dob" class="form-control" :value="date">

				<!-- occupation -->
				<label for="occupation">Occupation</label>
				<input type="text" name="occupation" class="form-control"> <br><br>

				<!-- gender -->
				<label for="gender">Gender</label>
				<input type="radio" name="gender" class="form-control" value="female" checked> <span>Female</span>
				<input type="radio" name="gender" class="form-control" value="male"> <span>Male</span> <br>

				<!-- homephone -->
				<label for="homephone">Home phone</label>
				<input type="text" name="homephone" class="form-control">

				<!-- handphone -->
				<label for="handphone">Hand phone</label>
				<input type="text" name="handphone" class="form-control"> <br>

				<!-- email -->
				<label for="email">Email</label>
				<input type="text" name="email" class="form-control"> <br>

				<label for="remarks">Remarks</label>
				<textarea name="remarks" class="form-control" rows="3"></textarea>
			</div>

			<!-- Error - component -->
			<error v-if="isError" :errors="errors"></error>

			<div class="customer-create__buttons">
				<button type="submit" class="btn btn-info" @click.prevent="postCustomer">Save</button>
				<button type="button" class="btn btn-danger" @click.prevent="goToHome">Close</button>
			</div>
		</form>
	</div>
</template>

<script>
	import error from './Error.vue';

	export default {
		components: { error },
		props: ['auth', 'date', 'token'],
		data() {
			return {
				authUser: {},
				errors: [],
				isError: false,
				// icList: [],
				emailList: [],
				customerRecord: {},
				lastID: 0,
			}
		},
		computed: {
			tableName() {
				return '?table=' + this.authUser.AllowedtblCustomer;
			}
		},
		created() {
			this.authUser = JSON.parse(this.auth);

			// http request
			this.customerLastId();
		},
		methods: {
			columnResultConvertToArray(data=[], column) {
				let result = data.map(response => {
					let newResult = [];
					let data = response[column];
				  
					newResult.push((data != null) ? data.trim() : '');

					return newResult;
				});

				return _.flatten(result);
			},
			convertToJson(formArray=[]) {
				let returnArray = {};

				for (let i = 0; i < formArray.length; i++){
					returnArray[formArray[i]['name']] = formArray[i]['value'];
				}

				return returnArray;
			},
			postCustomer() {
				let form = document.getElementById('customer-create');
				let action = '/customers' + this.tableName  + '&id=' + this.lastID;
				let icElem = $('input[name=ic]').val().trim();
	
				// check if response promise return 1 then it exist
				this.isIcExist(icElem).then(response => {
					if (parseInt(response, 10) > 0) {
						// notify that ic exist
						noty({
							layout: 'bottomLeft',
							theme: 'relax', // or relax
							type: 'error', // success, error, warning, information, notification
							text: `This ic number already exist.`,
							timeout: 5000,
						});
					} else {
						let data = $('form#customer-create').serializeArray();
						data = this.convertToJson(data);

						axios.post(action, data).then(response => {
							let data = response.data;

							if (data.isFail) {
								this.errors = data.errors;
								this.isError = true;
							} else {
								this.isError = false;
								this.customerRecord = data.records;

								let vm = this;
								let duration = 2500;

								// notify that new record save.
								noty({
									layout: 'bottomLeft',
									theme: 'relax', // or relax
									type: 'success', // success, error, warning, information, notification
									text: `New customer successfully added.`,
									timeout: duration,
								});

								// redirect to homepage
								window.setTimeout(vm.goToHome, duration);
							}
						});
					}
				});
			},
			goToHome() {
				window.location = '/home';
			},
			customerLastId() {
				let table = this.authUser.AllowedtblCustomer.trim();
				let url = '/customers/customerID?table=' + table;

				axios.get(url).then(response => {
					let id = parseInt(response.data, 10) + 1;

					this.lastID = id;
				});
			},
			isIcExist(icNo) {
				icNo = (icNo.length > 0) ? icNo.toUpperCase().trim() : 'empty';

				return axios.get('/customers/checkIc/'+icNo+this.tableName).then(response => response.data);
			}
		}
	}
</script>