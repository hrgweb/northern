<template>
	<div class="customer-create">
		<form method="POST" class="form-inline" id="customer-create" role="form" @submit.prevent="postCustomer">
			<legend>Enter new customer details</legend>

			<!-- sanitize against attacks -->
			<input type="hidden" name="_token" :value="token">

			<div class="customer-create__primary-info">
				<!-- id -->
				<label for="id">ID</label>
				<input type="text" name="id" class="form-control">

				<!-- ic -->
				<label for="ic">IC</label>
				<input type="text" name="ic" class="form-control">

				<!-- salutation -->
				<label for="salutation">Salutation</label>
				<select name="salutation" class="form-control">
					<option value="mr">Mr</option>
					<option value="ms">Ms</option>
					<option value="mrs">Mrs</option>
					<option value="mdm">Mdm</option>
					<option value="dr">Dr</option>
				</select> <br>

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
				<button type="submit" class="btn btn-info">Save</button>
				<button type="button" class="btn btn-danger">Close</button>
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
				icList: [],
				emailList: [],
				customerRecord: {},
			}
		},
		created() {
			this.authUser = JSON.parse(this.auth);

			// http request
			this.loadIc();
			// this.loadEmails();
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
			loadIc() {
				let action = '/customers/loadIc/' + this.authUser.AllowedtblCustomer.trim();

				axios.get(action).then(response => this.icList = this.columnResultConvertToArray(response.data, 'IC'));
			},
			loadEmails() {
				let action = '/customers/loadEmails/' + this.authUser.AllowedtblCustomer.trim();

				axios.get(action).then(response => this.emailList = this.columnResultConvertToArray(response.data, 'Email'));
			},
			setDate() {
				return $('input[type=date]').val('2017-03-17');
			},
			postCustomer() {
				let form = document.getElementById('customer-create');
				let action = '/customers/?table=' + this.authUser.AllowedtblCustomer;
				const data = new FormData(form);
				let ic = $('input[name=ic]').val().trim().toUpperCase();
				// let email = $('input[name=email]').val().trim().toUpperCase();

				// check if ic exist
				if (this.icList.indexOf(ic) != -1) {
					this.errors = [];

					// notify that the ic exist.
					noty({
						layout: 'bottomLeft',
						theme: 'relax', // or relax
						type: 'error', // success, error, warning, information, notification
						text: `IC Number is already exists.`,
						timeout: 5000,
					});
				} else {
					axios.post(action, data).then(response => {
						let data = response.data;

						if (data.isFail) {
							this.errors = data.errors;
							this.isError = true;
						} else {
							this.isError = false;
							this.customerRecord = data.records;
							this.icList.push(data.records.IC);

							// clear inputs and set date
							form.reset();
							this.setDate();

							// notify that new record save.
							noty({
								layout: 'bottomLeft',
								theme: 'relax', // or relax
								type: 'success', // success, error, warning, information, notification
								text: `New customer successfully added.`,
								timeout: 5000,
							});
						}
					});
				}
			}
		}
	}
</script>