<template>
	<div class="Customer__edit-overlay">
		<div class="Customer__edit-scroll">
			<div class="Customer__edit">
				<button type="button" class="btn btn-danger" @click.prevent="$emit('isedited')">x</button>

				<h2>Edit Record</h2>

				<!-- <pre>{{ record }}</pre> -->

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
							<select name="salutation" class="form-control">
								<option :value="record.Salutation">{{ record.Salutation }}</option>
								<option value="mr">Mr</option>
								<option value="ms">Ms</option>
								<option value="mrs">Mrs</option>
								<option value="mdm">Mdm</option>
								<option value="dr">Dr</option>
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
							<select name="country" class="form-control">
								<option :value="record.Country">{{ record.Country }}</option>
								<option value="singapore">Singapore</option>
								<option value="other">Other</option>
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
							<input type="date" name="dob" class="form-control">
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 split_input">
							<!-- occupation -->
							<label for="occupation">Occupation</label>
							<input type="text" name="occupation" class="form-control" v-model="record.Occupation">
						</div>
					</div> <br>

					<!-- gender -->
					<label for="gender">Gender</label> <b>{{ record.Gender }}</b><br>
					<input type="radio" name="gender" value="female" checked v-model="record.sex"> <span>Female</span>
					<input type="radio" name="gender" value="male" v-model="record.sex"> <span>Male</span> <br><br>


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
					<textarea name="remarks" class="form-control" rows="3"></textarea>
				</div>

				<!-- Error - component -->
				<!-- <error v-if="isError" :errors="errors"></error> -->

				<div class="customer-create__buttons">
					<button type="submit" class="btn btn-info" @click.prevent="updateCustomer">Save</button>
					<button type="button" class="btn btn-danger" @click.prevent="closeForm">Close</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import error from './Error.vue';

	export default {
		components: { error },
		props: ['auth', 'date', 'token', 'customer'],
		data() {
			return {
				authUser: {},
				record: {
					sex: ''
				}
			}
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			this.record = this.customer;
		},
		methods: {
			updateCustomer() {
				console.log(this.record);
			},
			closeForm() {
				this.$emit('isedited');
			}
		}
	}
</script>