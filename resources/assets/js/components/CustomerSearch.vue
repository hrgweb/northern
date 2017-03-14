<template>
	<div class="customer-search">
		<h2>Search for Customer 
			<b>[{{ tblCustomer }}]</b>
		</h2> <hr>

		<!-- <pre>{{ filterIcNoCustomers }}</pre> -->

		<div class="customer-search__controls">
			<form method="GET" role="form">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						<label for="ic_no">IC #</label>
						<input type="text" class="form-control" id="ic_no" name="ic_no" v-model="icNo">
					</div>
				
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" id="first_name" name="first_name">
					</div>

					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" id="last_name" name="last_name">
					</div>
				</div>

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<div class="form-group">
						<label for="handphone_no">Handphone #</label>
						<input type="text" class="form-control" id="handphone_no" name="handphone_no">
					</div>

					<div class="form-group">
						<label for="homephone_no">Home Phone #</label>
						<input type="text" class="form-control" id="homephone_no" name="homephone_no">
					</div>

					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="text" class="form-control" id="email" name="email">
					</div>	
				</div>					
			</form>
		</div>

		<div v-if="customers.length <= 0">
			<br><h2 class="text-center">FETCHING CUSTOMERS DATA.... PLEASE WAIT....</h2>
		</div>
		<div class="customer-search__records" v-else>
			<table class="table table-bordered table-hover">
				<caption>
					<h3>
						Customer Records
						<span class="label label-danger">{{ customers.length }}</span>
					</h3> 
				</caption>
				<thead>
					<tr>
						<th>CustID</th>
						<th>IC</th>
						<th>Country</th>
						<th>Building</th>
						<th>Block</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Postcode</th>
						<th>Street</th>
						<th>System</th>
						<th>Email</th>
						<th>Gender</th>
						<th>Occupation</th>
						<th>Salutation</th>
						<th>Unit</th>
					</tr>
				</thead>
				<tbody v-if="filterIcNoCustomers.length > 0">
					<tr v-for="customer in filterIcNoCustomers">
						<td>{{ customer.CustID }}</td>
						<td>{{ customer.IC }}</td>
						<td>{{ customer.Country }}</td>
						<td>{{ customer.Building }}</td>
						<td>{{ customer.Block }}</td>
						<td>{{ customer.Firstname }}</td>
						<td>{{ customer.Surname }}</td>
						<td>{{ customer.Postcode }}</td>
						<td>{{ customer.Street }}</td>
						<td>{{ customer.System }}</td>
						<td>{{ customer.Email }}</td>
						<td>{{ customer.Gender }}</td>
						<td>{{ customer.Occupation }}</td>
						<td>{{ customer.Salutation }}</td>
						<td>{{ customer.Unit }}</td>
					</tr>
				</tbody>
				<tbody v-else>
					<tr>
						<td colspan="15"><h2 class="text-center">No results found for <em>"{{ icNo }}"</em></h2></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['auth'],
		data() {
			return {
				authUser: {},
				customers: [],
				tblCustomer: '',
				icNo: '',
			}
		},
		computed: {
			filterIcNoCustomers() {
				let search = this.icNo;

				return this.customers.filter(elem => elem.IC.match(search));
			}
		},
		created() {
			this.authUser = JSON.parse(this.auth);
			this.allCustomer();
		},
		methods: {
			allCustomer() {
				let tblCustomer = this.authUser.AllowedtblCustomer		

				axios.get('/customers/allCustomer/' + tblCustomer).then(response => {
					let data = response.data;

					this.customers = data.records;
					this.tblCustomer = data.table;
				});
			}
		}
	}
</script>