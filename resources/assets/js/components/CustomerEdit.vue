<template>
	<div class="Customer__edit-overlay">
		<div class="Customer__edit-scroll">
			<div class="Customer__edit">
				<button type="button" class="btn btn-danger" @click.prevent="$emit('isedited')">x</button>

				<h2>Edit Record</h2>

				<form method="POST" id="customer-edit">
					<!-- sanitize against attacks -->
					<input type="hidden" name="_token" :value="token">
					<input type="hidden" name="_method" value="PUT">

					<div class="customer-create__primary-info">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- ic -->
								<label for="ic">IC</label>
								<input type="text" name="ic" class="form-control" v-model="record.IC">
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- salutation -->
								<label for="salutation">Salutation</label>
								<select name="salutation" class="form-control" v-model="record.Salutation">
									<option value="MR">MR</option>
									<option value="MS">MS</option>
									<option value="MRS">MRS</option>
									<option value="MDM">MDM</option>
									<option value="DR">DR</option>
								</select> <br>
							</div>
						</div>

						<div class="customer-create__name">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
									<!-- surname -->
									<label for="surname">Surname</label>
									<input type="text" name="surname" class="form-control" v-model="record.Surname">
								</div>

								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
									<!-- firstname -->
									<label for="firstname">Firstname</label>
									<input type="text" name="firstname" class="form-control" v-model="record.FirstName">
								</div>
							</div>
						</div>
					</div>

					<div class="customer-create__address">
						<h3>Address</h3>

						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- block -->
								<label for="block">Block / House no</label>
								<input type="text" name="block" class="form-control" v-model="record.Block">
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- unit_no -->
								<label for="unit_no">Unit Number</label>
								<input type="text" name="unit_no" class="form-control" v-model="record.Unit"> <br>
							</div>
						</div>

						<!-- building -->
						<label for="building">Building</label>
						<input type="text" name="building" class="form-control" v-model="record.Building"> <br>

						<!-- street -->
						<label for="street">Street</label>
						<input type="text" name="street" class="form-control" v-model="record.Street"> <br>

						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- country -->
								<label for="country">Country</label>
								<select name="country" class="form-control" v-model="record.Country">
									<option value="SINGAPORE">SINGAPORE</option>
									<option value="OTHER">OTHER</option>
								</select>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- postcode -->
								<label for="postcode">Postcode</label>
								<input type="text" name="postcode" class="form-control" v-model="record.Postcode">
							</div>
						</div>
					</div>

					<div class="customer-create__other">
						<h3>Other Information</h3>

						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- dob -->
								<label for="dob">DOB</label>
								<input type="date" name="dob" class="form-control" :value="record.DOB" v-model="record.DOB">
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- occupation -->
								<label for="occupation">Occupation</label>
								<input type="text" name="occupation" class="form-control" v-model="record.Occupation">
							</div>
						</div> <br>

						<!-- gender -->
						<label for="gender">Gender</label><br>
						<input type="radio" name="gender" value="Female" checked v-model="record.Gender"> <span>Female</span>
						<input type="radio" name="gender" value="Male" v-model="record.Gender"> <span>Male</span> <br><br>


						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- homephone -->
								<label for="homephone">Home phone</label>
								<input type="text" name="homephone" class="form-control" v-model="record.HomePhone">
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
								<!-- handphone -->
								<label for="handphone">Hand phone</label>
								<input type="text" name="handphone" class="form-control" v-model="record.HandPhone"> <br>
							</div>
						</div>

						<!-- email -->
						<label for="email">Email</label>
						<input type="text" name="email" class="form-control" v-model="record.Email"> <br>

						<label for="remarks">Remarks</label>
						<textarea name="remarks" class="form-control" rows="3" v-model="record.Remark"></textarea>
					</div>

					<!-- Error - component -->
					<error v-if="isError" :errors="errors"></error>

					<div class="customer-create__buttons">
						<button type="submit" class="btn btn-info" @click.prevent="updateCustomer">Update</button>
						<button type="button" class="btn btn-danger" @click.prevent="closeForm">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import error from './Error.vue';
	// import { DateClass } from './class/DateClass.js';

	export default {
		components: { error },
		props: ['auth', 'token', 'customer', 'ic'],
		data() {
			return {
				authUser: {},
				record: {},
				errors: [],
				isError: false,
				customerRecord: {},
				icList: []
			}
		},
		computed: {
			
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			this.record = this.customer;
			this.icList = this.ic;
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
			updateCustomer(event) {
				let record = this.record;
				let action = 'customers/' + record.CustID + '/?table=' + this.authUser.AllowedtblCustomer.trim();
				let ic = $('input[name=ic]').val().trim().toUpperCase();

				// change update button text to updating
				event.target.innerHTML = 'Updating...';

				// check if ic is null
				ic = (ic.length > 0) ? ic : '';

				// check if ic exist
				if (this.icList.length > 0 && this.icList.indexOf(ic) != -1) {
					this.errors = [];
					event.target.innerHTML = 'Update';

					// notify that the ic exist.
					noty({
						layout: 'bottomLeft',
						theme: 'relax', // or relax
						type: 'error', // success, error, warning, information, notification
						text: `IC Number is already exists.`,
						timeout: 5000,
					});
				} else {
					axios.put(action, record).then(response => {
						let data = response.data;

						event.target.innerHTML = 'Update';

						if (data.isFail) {
							this.errors = data.errors;
							this.isError = true;
						} else {
							this.isError = false;
							this.customerRecord = data.records;
							this.icList.push(data.records.IC);

							let vm = this;
							let time = 2000;

							// close after 5sec
							setTimeout(function() {
								vm.$emit('isedited');
							}, time);

							// notify that new record save.
							noty({
								layout: 'bottomLeft',
								theme: 'relax', // or relax
								type: 'success', // success, error, warning, information, notification
								text: `Customer successfully updated.`,
								timeout: time,
							});
						}
					});
				}
			},
			closeForm() {
				this.$emit('isedited');
			},
		}
	}
</script>