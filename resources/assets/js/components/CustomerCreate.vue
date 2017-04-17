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
				<input type="text" name="ic" class="form-control" v-model="inputs.ic">

				<!-- salutation -->
				<label for="salutation">Salutation</label>
				<select name="salutation" class="form-control" v-model="inputs.salutation">
					<option value="MR">MR</option>
					<option value="MS">MS</option>
					<option value="MRS">MRS</option>
					<option value="MDM">MDM</option>
					<option value="DR">DR</option>
				</select> <br><br>

				<div class="customer-create__name">
					<!-- surname -->
					<label for="surname">Surname</label>
					<input type="text" name="surname" class="form-control" v-model="inputs.surname">

					<!-- firstname -->
					<label for="firstname">First name</label>
					<input type="text" name="firstname" class="form-control" v-model="inputs.firstname">
				</div>
			</div>

			<div class="customer-create__address">
				<h3>Address</h3>

				<!-- block -->
				<label for="block">Block / House no</label>
				<input type="text" name="block" class="form-control" v-model="inputs.block">

				<!-- unit_no -->
				<label for="unit_no">Unit Number</label>
				<input type="text" name="unit_no" class="form-control" v-model="inputs.unit_no"> <br>

				<!-- building -->
				<label for="building">Building</label>
				<input type="text" name="building" class="form-control" v-model="inputs.building"> <br>

				<!-- street -->
				<label for="street">Street</label>
				<input type="text" name="street" class="form-control" v-model="inputs.street"> <br>

				<!-- country -->
				<label for="country">Country</label>
				<select name="country" class="form-control" v-model="inputs.country">
					<option value="singapore">SINGAPORE</option>
					<option value="other">OTHER</option>
				</select>

				<!-- postcode -->
				<label for="postcode">Postcode</label>
				<input type="text" name="postcode" class="form-control" v-model="inputs.postcode">
			</div>

			<div class="customer-create__other">
				<h3>Other Information</h3>

				<!-- dob -->
				<label for="dob">DOB</label>
				<input type="date" name="dob" class="form-control" v-model="inputs.dob">

				<!-- occupation -->
				<label for="occupation">Occupation</label>
				<input type="text" name="occupation" class="form-control" v-model="inputs.occupation"> <br><br>

				<!-- gender -->
				<label for="gender">Gender</label>
				<!-- <input type="radio" name="gender" class="form-control" value="female" v-model="inputs.gender" checked> <span>Female</span>
				<input type="radio" name="gender" class="form-control" value="male" v-model="inputs.gender"> <span>Male</span> <br> -->
				<select name="gender" class="form-control" v-model="inputs.gender">
					<option value="select">SELECT ONE</option>
					<option value="female">FEMALE</option>
					<option value="male">MALE</option>
				</select> <br>


				<!-- homephone -->
				<label for="homephone">Home phone</label>
				<input type="text" name="homephone" class="form-control" v-model="inputs.homephone">

				<!-- handphone -->
				<label for="handphone">Hand phone</label>
				<input type="text" name="handphone" class="form-control" v-model="inputs.handphone"> <br>

				<!-- email -->
				<label for="email">Email</label>
				<input type="text" name="email" class="form-control" v-model="inputs.email"> <br>

				<label for="remarks">Remarks</label>
				<textarea name="remarks" class="form-control" rows="3" v-model="inputs.remarks"></textarea>
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
				emailList: [],
				customerRecord: {},
				lastID: 0,
				inputs: {
					ic: '',
					salutation: 'MR',
					surname: '',
					firstname: '',
					block: '',
					unit_no: '',
					building: '',
					street: '',
					country: 'singapore',
					postcode: '',
					dob: '',
					gender: 'select',
					homephone: '',
					handphone: '',
					email: '',
					remarks: ''
				}
			}
		},
		computed: {
			tableName() {
				return '?table=' + this.authUser.AllowedtblCustomer;
			}
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			this.inputs.dob = 'yyyy-MM-dd'; //this.date;

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
			postCustomer() {
				let form = document.getElementById('customer-create');
				let action = '/customers' + this.tableName  + '&id=' + this.lastID;
				let icElem = this.inputs.ic;
				icElem = (icElem.length > 0) ? icElem.trim() : '';

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
						axios.post(action, this.inputs) .then(response => {
							let data = response.data;

							if (data.isFail == true) {
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
								// window.setTimeout(vm.goToHome, duration);
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
