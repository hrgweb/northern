<template>
	<div class="customer-search">
		<h2>Search for Customer 
			<b>[{{ table }}]</b>
		</h2>

		<div class="customer-search__controls">
			<form method="GET" role="form">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group">
						<label for="ic_no">IC #</label>
						<input type="text" class="form-control" id="ic_no" name="ic_no" v-model="icNo" @focus="columnToSearch" autofocus>
					</div>
				
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" id="first_name" name="first_name" v-model="firstname" @focus="columnToSearch">
					</div>
				</div>

				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" id="last_name" name="last_name" v-model="lastname" @focus="columnToSearch">
					</div>

				
					<div class="form-group">
						<label for="handphone_no">Handphone #</label>
						<input type="text" class="form-control" id="handphone_no" name="handphone_no" v-model="handPhoneNo" @focus="columnToSearch">
					</div>
				</div>
				
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<div class="form-group">
						<label for="homephone_no">Home Phone #</label>
						<input type="text" class="form-control" id="homephone_no" name="homephone_no" v-model="homePhoneNo" @focus="columnToSearch">
					</div>

					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="text" class="form-control" id="email" name="email" v-model="email" @focus="columnToSearch">
					</div>
				</div>
			</form>
		</div>

		<div v-if="customers.length <= 0">
			<br><h2 class="text-center">FETCHING CUSTOMER DATA.... PLEASE WAIT</h2>
		</div>
		<div class="customer-search__records" v-else>
			<table class="table table-bordered table-hover">
				<caption>
					<h3>
						Customer Records
						<span class="label label-danger">{{ filterCustomersByColumn.length }}</span>
					</h3> 
				</caption>
				<thead>
					<tr>
						<!-- <th>CustID</th> -->
						<th>IC</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Hand Phone No</th>
						<th>Home Phone No</th>
						<th>Email</th>
						<th>Country</th>
						<th>Building</th>
						<th>Block</th>
						<th>Postcode</th>
						<th>Street</th>
						<th>Gender</th>
						<th>Salutation</th>
						<!-- <th>Unit</th> -->
						<!-- <th>System</th> -->
						<!-- <th>Occupation</th> -->
						<th>Action</th>
					</tr>
				</thead>
				<tbody v-if="filterCustomersByColumn.length > 0">
					<tr v-for="(customer, index) in filterCustomersByColumn" @click="setIndex(index)">
						<!-- <td>{{ customer.CustID }}</td> -->
						<td>{{ customer.IC }}</td>
						<td>{{ customer.FirstName }}</td>
						<td>{{ customer.Surname }}</td>
						<td>{{ customer.HandPhone }}</td>
						<td>{{ customer.HomePhone }}</td>
						<td>{{ customer.Email }}</td>
						<td>{{ customer.Country }}</td>
						<td>{{ customer.Building }}</td>
						<td>{{ customer.Block }}</td>
						<td>{{ customer.Postcode }}</td>
						<td>{{ customer.Street }}</td>
						<td>{{ customer.Gender }}</td>
						<td>{{ customer.Salutation }}</td>
						<!-- <td>{{ customer.Unit }}</td> -->
						<!-- <td>{{ customer.System }}</td> -->
						<!-- <td>{{ customer.Occupation }}</td> -->
						<td colspan="2">
							<button type="button" class="btn btn-warning" @click="editRecord(customer)">Edit</button>
							<button type="button" class="btn btn-info" @click="purchaseRecord(customer)">History</button>
						</td>
					</tr>
				</tbody>
				<tbody v-else>
					<tr>
						<td colspan="15"><h2 class="text-center">No result found.</h2></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['auth', 'customers', 'table'],
		data() {
			return {
				authUser: {},
				// customers: [],
				// tblCustomer: '',
				icNo: '',
				firstname: '',
				lastname: '',
				handPhoneNo: '',
				homePhoneNo: '',
				email: '',
				columnToUse: '',
				recordIndex: 0,
			}
		},
		created() {
			this.authUser = this.auth;
		},
		computed: {
			filterCustomersByColumn() {
				let records = [];

				switch(this.columnToUse.trim()) {
					case 'ic_no':
						records = this.customers.filter(elem => elem.IC.match(new RegExp(this.icNo, 'i')));
						break;
					case 'first_name':
						records = this.customers.filter(elem => elem.FirstName.match(new RegExp(this.firstname, 'i')));
						break;
					case 'last_name':
						records = this.customers.filter(elem => elem.Surname.match(new RegExp(this.lastname, 'i')));
						break;
					case 'handphone_no':
						records = this.customers.filter(elem => elem.HandPhone.match(new RegExp(this.handPhoneNo, 'i')));
						break;
					case 'homephone_no':
						records = this.customers.filter(elem => elem.HomePhone.match(new RegExp(this.homePhoneNo, 'i')));
						break;
					case 'email':
						records = this.customers.filter(elem => elem.Email.match(new RegExp(this.email, 'i')));
						break;
				}

				return records;
			}
		},
		methods: {
			columnToSearch(event) {
				let column = event.target.attributes.id.value;

				switch(column.trim()) {
					case 'ic_no':
						this.columnToUse = 'ic_no';
						break;
					case 'first_name':
						this.columnToUse = 'first_name';
						break;
					case 'last_name':
						this.columnToUse = 'last_name';
						break;
					case 'handphone_no':
						this.columnToUse = 'handphone_no';
						break;
					case 'homephone_no':
						this.columnToUse = 'homephone_no';
						break;
					case 'email':
						this.columnToUse = 'email';
						break;
				}
			},
			editRecord(customer) {
				this.$emit('isedited', customer);
			},
			setIndex(index) {
				this.recordIndex = index;
			},
			purchaseRecord(customer) {
				this.$emit('ishistory', customer);
			}
		}
	}
</script>