<template>
	<div class="Customer__purchase-overlay">
		<div class="Customer__purchase-scroll">
			<div class="Customer__purchase">
				<button type="button" class="btn btn-danger" @click.prevent="$emit('ishistory')">x</button>
				<h2 class="text-center">Customer</h2>

				<div class="Customer__purchase-info">
					<b>Current Customer >> &nbsp;&nbsp; ID : </b>
					<span style="margin-right: 1em;">{{ customer.CustID }}</span>

					<b>Name : </b>
					<span>{{ customer.Surname }}, {{ customer.FirstName }}</span>
				</div>

				<div class="Customer__purchase-body">
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding-right: 0;">
							<div class="left-panel">
								<!-- Sort -->
								<select style="margin-bottom: 0.5em;" class="form-control" v-model="sort">
									<option value="StaffName">STAFF NAME</option>
									<option value="ReceiptNo">RECEIPT NO</option>
									<option value="SaleDate">SALE DATE</option>
								</select>

								<!-- Customer -->
								<ul class="records">
									<li v-if="isLoading">{{ msg }}</li>
									<li v-for="(sale, index) in sales" v-else>
										<a href="#" @click.prevent="showReceipt(sale, index)">
											<b>
												{{ sale.ReceiptNo }} :
												{{ sale.SaleDate }} :
												{{ sale.TrayNo }} :
												{{ sale.StaffName }}
											</b>
										</a>
									</li>
								</ul>

								<!-- Dispense -->
								<ul class="dispense">
									<li v-for="dispense in dispenses">
										<b>
											{{ dispense.ClassName }} :
											{{ dispense.DispID }}
										</b>

										<!-- Sight Test -->
										<ul class="sigt-test">
											<li>
												<b>
													SIGHT TEST : 
													{{ dispense.STID }} :
													{{ dispense.OrderDate }}
												</b>
											</li>
										</ul>
									</li>
								</ul>

								<!-- ST -->
								<ul class="st-detail">
									<li v-for="st in sts">
										<b>
											ST : {{ st.STID }} :
											{{ st.STDate }} :
											{{ st.StaffName }}
										</b>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" v-if="receiptInfo">
							<div class="Customer__purchase-receipt">
								<h3>Receipt Information</h3>
								<p>
									Receipt: <span>{{ receipt.ReceiptNo }}</span> &nbsp;&nbsp;&nbsp;
									Date/Time: <span>{{ receipt.SaleDate }}</span> &nbsp;&nbsp;&nbsp;
									Staff: <span>{{ receipt.StaffName }}</span> &nbsp;&nbsp;&nbsp;
									Job: <span>{{ receipt.TrayNo }}</span> &nbsp;&nbsp;&nbsp; <br>
								</p>

								<p>
									Amount: <span>{{ receipt.Subtotal }}</span> &nbsp;&nbsp;&nbsp;
									Deposit: <span>{{ receipt.Deposit }}</span> &nbsp;&nbsp;&nbsp;
									Paid by: <span>{{ receipt.PmtMethod }}</span> &nbsp;&nbsp;&nbsp;
									Balance: <span>{{ receipt.Balance }}</span> &nbsp;&nbsp;&nbsp; <br>
								</p><br>

								<!-- Purchase Items -->
								<h3>Purchase Items</h3>
								<table class="table">
									<thead>
										<tr>
											<th>Barcode</th>
											<th>Description</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<tr v-if="isLoadingItems">
											<td class="tmp" colspan="4">{{ msgItem }}</td>
										</tr>
										<tr v-for="item in items" v-else>
											<td>{{ item.Barcode }}</td>
											<td>{{ item.Description }}</td>
											<td>{{ item.Selling }}</td>
											<td>{{ item.TranTotal }}</td>
										</tr>
									</tbody>
								</table>

								<div class="text-center lens-tmp" v-if="isLoadingLens">
									{{ msgLen }}
								</div>
								<div v-else>
									<!-- Spectacle Lens -->
									<div v-if="spectacleObj.length > 0">
										<div class="lens" v-for="(len, index) in spectacleObj">
											<h4>
												<span>{{ len.ClassName }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ ++index }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ len.OrderDate }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ len.DispID }}</span> &nbsp;&nbsp;&nbsp;
											</h4>
											<table class="table">
												<thead>
													<tr>
														<th>Sight Test</th>
														<th>V/A</th>
														<th>Dispense</th>
														<th>ADD+</th>
														<th>PD</th>
														<th>HT</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<b>Right</b> &nbsp;&nbsp;
															<!-- {{ len.SPHRRX }}{{ len.CYLRRX }}X{{ len.AXISRRX }} -->
														</td>
														<td>{{ len.VA5 }}</td>
														<td>
															{{ len.SPHRRX }}{{ len.CYLRRX }}X{{ len.AXISRRX }}
														</td>
														<td>{{ len.ADDRX }}</td>
														<td>{{ len.PDRRX }}</td>
														<td>{{ len.HTRRX }}</td>
													</tr>
													<tr>
														<td>
															<b>Left</b> &nbsp;&nbsp;
															<!-- {{ len.SSPHRRX }}{{ len.SCYLRRX }}X{{ len.SAXISRRX }} -->
														</td>
														<td>{{ len.VA6 }}</td>
														<td>
															<!-- {{ len.SSPHRLX }}{{ len.SCYLRLX }}X{{ len.SAXISRLX }} -->
															{{ len.SPHRLX }}{{ len.CYLRLX }}X{{ len.AXISRLX }}
														</td>
														<td>{{ len.ADDRLX }}</td>
														<td>{{ len.PDRLX }}</td>
														<td>{{ len.HTRLX }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<!-- Contact Lens -->
									<div v-if="contactObj.length > 0">
										<div class="lens" v-for="(len, index) in contactObj">
											<h4>
												<span>{{ len.ClassName }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ ++index }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ len.OrderDate }}</span> &nbsp;&nbsp;&nbsp;
												<span>{{ len.DispID }}</span> &nbsp;&nbsp;&nbsp;
											</h4>
											<table class="table">
												<thead>
													<tr>
														<th>Sight Test</th>
														<th>V/A</th>
														<th>Dispense</th>
														<th>ADD+</th>
														<th>PD</th>
														<th>HT</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<b>Right</b> &nbsp;&nbsp;
															<!-- {{ len.SPHRRX }}{{ len.CYLRRX }}X{{ len.AXISRRX }} -->
														</td>
														<td>{{ len.VA5 }}</td>
														<td>
															{{ len.SPHRRX }}{{ len.CYLRRX }}X{{ len.AXISRRX }}
														</td>
														<td>{{ len.ADDRX }}</td>
														<td>{{ len.PDRRX }}</td>
														<td>{{ len.HTRRX }}</td>
													</tr>
													<tr>
														<td>
															<b>Left</b> &nbsp;&nbsp;
															<!-- {{ len.SSPHRRX }}{{ len.SCYLRRX }}X{{ len.SAXISRRX }} -->
														</td>
														<td>{{ len.VA6 }}</td>
														<td>
															<!-- {{ len.SSPHRLX }}{{ len.SCYLRLX }}X{{ len.SAXISRLX }} -->
															{{ len.SPHRLX }}{{ len.CYLRLX }}X{{ len.AXISRLX }}
														</td>
														<td>{{ len.ADDRLX }}</td>
														<td>{{ len.PDRLX }}</td>
														<td>{{ len.HTRLX }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['auth', 'customer'],
		data() {
			return {
				sales: [],
				receipt: {},
				receiptInfo: false,
				items: [],
				isLoading: true,
				isLoadingItems: true,
				isLoadingLens: true,
				msg: 'Fetching Receipt...',
				msgItem: 'Fetching Items...',
				msgLen: 'Fetching Lens...',
				indexBefore: -1,
				lens: [],
				clickCounter: 0,
				spectacleObj: [],
				contactObj: [],
				isSpectacle: false,
				isContact: false,
				dispenses: [],
				sts: [],
				sort: 'ReceiptNo',
			}
		},
		computed: {
			custID() {
				return this.customer.CustID;
			},
			tableName() {
				return '/?table=' + this.auth.AllowedtblCustomer.trim();
			},			
		},
		watch: {
			sort() {
		    	return this.sales.sort((a,b) => {
			      	let result = [];
			        
			      	if(this.sort == 'ReceiptNo') {
			        	result = a.ReceiptNo < b.ReceiptNo
			        }
			        
			        if(this.sort == 'StaffName') {
			        	result = a.StaffName < b.StaffName
			        }
			        
			        if(this.sort == 'SaleDate') {
			        	result = a.SaleDate < b.SaleDate
			        }
			        
			        return result;
		      });
		    },
		},
		mounted() {
			this.allPurchase();
			this.dispenseLeft();
			this.stLeft();
		},
		methods: {
			prepareQuery(url) {
				axios.get(url).then(response => {
					let data = response.data;

					// switch() {

					// }

					// check if there is data
					if (data.length > 0) {
						this.isLoading =  false;
					} else if(data.length == 0) {
						this.msg = 'No purchased history.';
						this.isLoading =  true;
					}

					this.sales = data;
				});
			},
			allPurchase() {
				let url = '/purchases/'+this.custID+this.tableName;

				axios.get(url).then(response => {
					let data = response.data;

					// check if there is data
					if (data.length > 0) {
						this.isLoading =  false;
					} else if(data.length == 0) {
						this.msg = 'No purchased history.';
						this.isLoading =  true;
					}

					this.sales = data;
				});
			},
			defaultMsg() {
				this.msg = 'Fetching Receipt...',
				this.msgItem = 'Fetching Items...',
				this.msgLen = 'Fetching Lens...',
				this.receiptInfo = true;
				this.isLoadingItems = true;
				this.isLoadingLens = true;
			},
			loadItemsAndLens() {
				this.salesTransaction();
				this.dispenseRight();
			},
			showReceipt(sale, index) {
				this.receipt = sale;

				// check if customer click purchase item
				if (this.indexBefore != index) {
					this.loadItemsAndLens();
					this.defaultMsg();
					this.clickCounter++;
				} 

				this.indexBefore = index;
			},
			salesTransaction() {
				let url = '/purchases/transactions/'+this.receipt.ReceiptNo+this.tableName;

				axios.get(url).then(response => {
					let data = response.data;

					// check if there is data
					if (data.length > 0) {
						this.isLoadingItems =  false;
					} else if(data.length == 0) {
						this.msgItem = 'No purchased items.';
						this.isLoadingItems =  true;
					}

					this.items = data;
				})
			},
			dispenseRight() {
				let url = '/purchases/dispenseRight/'+this.receipt.SaleID+this.tableName;

				axios.get(url).then(response => {
					let data = response.data;

					// check if there is data
					if (data.length > 0) {
						this.isLoadingLens =  false;
					} else if(data.length == 0) {
						this.msgLen = 'No found lens.';
						this.isLoadingLens =  true;
					}

					this.lens = data;		
					this.countContactSpectacleLens(); // count contact and spectacle lens
				});
			},
			countContactSpectacleLens() {
				// spectacle lens
				this.spectacleObj = this.lens.filter(len => {
					return (len.ClassName.trim().toLowerCase() == 'spectacle lens');
				});

				// contact lens
				this.contactObj = this.lens.filter(len => {
					return (len.ClassName.trim().toLowerCase() == 'contact lens');
				});

				// spectacle obj is > 0
				this.isSpectacle = (this.spectacleObj.length > 0) ?  true : false;

				// contact obj is > 0
				this.isContact = (this.contactObj.length > 0) ?  true : false;
			},
			dispenseLeft() {
				let url = '/purchases/dispenseLeft/'+this.custID+this.tableName;

				axios.get(url).then(response => {
					this.dispenses = response.data;
				});
			},
			stLeft() {
				let url = '/purchases/stLeft/'+this.custID+this.tableName;

				axios.get(url).then(response => {
					this.sts = response.data;
				});
			}
		}
	}
</script>