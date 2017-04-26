<template>
	<div class="Collection__form">
		<div class="Collection__title">
			<h2 class="text-center">Collection Form</h2>
		</div>

		<div class="Collection__inputs">
			<!-- Receipt -->
			<div class="form-group">
				<label for="receipt">Receipt Number</label>
				<input type="text" class="form-control" id="receipt" list="receipts" v-model="inputs.receipt" @keyup.enter="saveCollection">
				<datalist id="receipts">
					<option v-for="receipt in receipts" :value="receipt.Receipt">{{ receipt.Receipt }}</option>
				</datalist>
			</div>

			<!-- Auto close -->
			<div class="form-group">
				<input type="checkbox" id="close" v-model="inputs.close" :checked="inputs.close"><br>
				<label for="close">Auto Close</label>
			</div>

			<!-- Date -->
			<div class="form-group">
				<label for="dateCollection">Date of collection</label>
				<input type="text" class="form-control" id="dateCollection" disabled="disabled" v-model="inputs.dateCollection">
			</div>

			<!-- Staff -->
			<div class="form-group">
				<label for="staff">Staff</label>
				<select class="form-control" id="staff" v-model="inputs.staff">
					<option value="select">SELECT STAFF</option>
					<option v-for="staff in staffs" :value="staff.StaffName">{{ staff.StaffName }}</option>
				</select>
			</div>

			<!-- Amount -->
			<div class="form-group">
				<label for="amount">Amount</label>
				<input type="number" class="form-control" id="amount" v-model="inputs.amount" @focus="focusInputText">
			</div>

			<!-- Payment -->
			<div class="form-group">
				<label for="payment">Payment Method</label>
				<select class="form-control" id="payment" v-model="inputs.payment">
					<option value="select">SELECT PAYMENT</option>
					<option v-for="payment in payments" :value="payment">{{ payment.PmtMethod }}</option>
				</select>
			</div>

			<!-- Actions -->
			<div class="form-group group-btn">
				<!-- <button type="button" class="btn btn-info" @click="newCollection">New</button> -->
				<button type="button" class="btn btn-success" @click="saveCollection">Save</button>
				<button type="button" class="btn btn-danger" @click="backToHome">Close</button>
			</div>
		</div>

		<div class="Collection__body">
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<table class="table table-bordered table-hover" id="receipt-box">
					<thead>
						<tr>
							<th>Receipt</th>
							<th>Amount</th>
							<th>Paid by</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(list, index) in receiptBox" @click.stop="receiptItemClick">
							<td>{{ list.ReceiptNo }}</td>
							<td>{{ list.PmtAmount }}</td>
							<td>{{ list.PmtMethod }}</td>
							<td class="text-center">
								<button type="button" class="btn btn-warning" @click.stop.self="receiptItemRemove(list, index)">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<table class="table table-bordered table-hover" id="receipt-table">
					<thead>
						<tr>
							<th>Item</th>
							<th>Brand</th>
							<th>Descriptions</th>
							<th>Price</th>
							<th>Qty</th>
							<th>Total</th>
						</tr>
					</thead>

					<!-- show receipt -->
					<!-- 1 -->
					<tbody v-if="receiptStatusText === 'none'">
						<tr><td colspan="6" class="empty">TRANSACTION DETAILS</td></tr>
					</tbody>
					<!-- 2 -->
					<tbody v-else-if="receiptStatusText === 'receipt'">
						<tr><td colspan="6" class="empty">FETCHING TRANSACTION</td></tr>
					</tbody>
					<!-- 3 -->
					<tbody v-else>
						<tr>
							<td></td><td></td>
							<td><span>Sale ID</span></td>
							<td><b>{{ receiptShowBox.SaleID }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Receipt No</span></td>
							<td><b>{{ receiptShowBox.ReceiptNo }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Customer</span></td>
							<td>
								<b>
									{{ receiptShowBox.FirstName }}
									{{ receiptShowBox.Surname }}
								</b>
							</td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Address</span></td>
							<td>
								<b>
									{{ receiptShowBox.Block }}
									{{ receiptShowBox.Unit }}
									{{ receiptShowBox.Building }}
									{{ receiptShowBox.Street }}
									{{ receiptShowBox.PostCode }}
								</b>
							</td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>D.O.B</span></td>
							<td><b>{{ receiptShowBox.DOB }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Phone No</span></td>
							<td><b>{{ receiptShowBox.HandPhone }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Sale Date</span></td>
							<td><b>{{ receiptShowBox.SaleDate }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Sale Time</span></td>
							<td><b>{{ receiptShowBox.SaleTime }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Collection Date</span></td>
							<td><b>{{ receiptShowBox.CollectDate }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Staff</span></td>
							<td><b>{{ receiptShowBox.StaffName }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Tray No</span></td>
							<td><b>{{ receiptShowBox.TrayNo }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Sale Amount</span></td>
							<td><b>{{ receiptShowBox.Subtotal }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Deposit</span></td>
							<td><b>{{ receiptShowBox.Deposit }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>Balance</span></td>
							<td><b>{{ receiptShowBox.Balance }}</b></td>
							<td></td><td></td>
						</tr>

						<!-- show items -->
						<tr v-if="receiptStatusText === 'receipt'">
							<td colspan="6" class="empty">{{ itemMsg }}</td>
						</tr>
						<tr v-for="(item, index) in items" v-else>
							<td>{{ ++index }}</td>
							<td>{{ item.Brand }}</td>
							<td>{{ item.FullDescription }}</td>
							<td>{{ item.Selling }}</td>
							<td>{{ item.Qty }}</td>
							<td>{{ item.TranTotal }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['date', 'auth'],
		data() {
			return {
				receipts: [],
				staffs: [],
				staffID: 0,
				payments: [],
				receiptBox: [],
				receiptShowBox: {},
				items: [],
				receiptStatusText: 'none',
				itemMsg: 'FETCHING ITEMS',
				isTypeReceipt: false,
				receiptNoClick: 0,
				inputs: {
					receipt: '',
					close: 'checked',
					dateCollection: '',
					staff: 'select',
					amount: 0,
					payment: 'select'
				},
			}
		},
		mounted() {
            // setting up data
            this.inputs.dateCollection = this.date;

            // fire http(s) request
            this.staffList();
            this.paymentMethod();
        },
        computed: {
        	tableName() {
       			return '?table=' + this.auth.AllowedtblCustomer;
        	}
        },
        watch: {
        	receiptShowBox() {
        		this.staffID = this.receiptShowBox.StaffID;
        	},
        	auth() {
            	this.receiptList();
            	this.receiptTable();
        	}
        },
        methods: {
        	receiptList() {
            	let url = '/collections/receiptList' + this.tableName;
        		axios.get(url).then(response => this.receipts = response.data);
        	},
        	staffList() {
        		axios.get('/collections/staffList').then(response => this.staffs = response.data);
        	},
        	paymentMethod() {
        		axios.get('/collections/paymentMethod').then(response => this.payments = response.data);
        	},
        	focusInputText() {
        		let doc = document;
        		doc.querySelector('#amount').select();
                // doc.querySelector('#receipt').select();
            },
            newCollection() {
            	this.inputs = {
            		receipt: '',
            		close: 'checked',
            		dateCollection: this.date,
            		staff: 'select',
            		amount: 0,
            		payment: 'select'
            	};
            },
            saveCollection() {
            	// check if rececipt # is already keyed
            	if (this.isReceiptKeyedAlready() > 0) {
            		// notify that receipt already keyed.
                    noty({
                    	layout: 'bottomLeft',
                        theme: 'relax', // or relax
                        type: 'error', // success, error, warning, information, notification
                        text: 'This receipt is already on the list.',
                        timeout: 5000,
                    });
            	} else {
	                // make sure user input receipt #, choose staff and payment to pass the validation
	                if (this.inputs.receipt.length > 0 && 
	                	this.inputs.staff != 'select' &&
	                	this.inputs.payment != 'select'
	                	/*this.inputs.amount > parseInt(0, 10)*/) {
	                    this.prepareData();     // post data
	            	} else {
	                    // notify that validation fails.
	                    noty({
	                    	layout: 'bottomLeft',
	                        theme: 'relax', // or relax
	                        type: 'error', // success, error, warning, information, notification
	                        text: `Make sure you enter receipt number, select staff and payment method.`,
	                        timeout: 5000,
	                    });
	                }
            	}
            },
            backToHome() {
            	window.location.href = '/home';
            },
            receiptTable() {
            	let url = '/collections/receiptTable' + this.tableName;
            	axios.get(url).then(response => this.receiptBox = response.data);
            },
            prepareData() {
            	let vm = this;

            	this.receiptStatusText = 'receipt';
                this.receiptNoClick = this.inputs.receipt;

                // notify on saving.
                noty({
                	layout: 'bottomLeft',
                    theme: 'relax', // or relax
                    type: 'information', // success, error, warning, information, notification
                    text: `Saving new record to database.`,
                    timeout: 5000,
                });

                // show transaction receipt and items
            	this.showTransaction().then(() => {
            		let url = '/collections' + this.tableName;
            		const data = {
            			SaleID: this.receiptShowBox.SaleID,
            			ReceiptNo: this.inputs.receipt,
            			StaffID: this.staffID,
            			PmtMethodID: this.inputs.payment.PmtMethodID,
            			PmtAmount: this.inputs.amount,
            			Posted: 0,
            			BranchID: Math.floor(this.receiptShowBox.BranchID),
            			OtherSale: 0,
            		};

                    // store to collection table
	                axios.post(url, data).then(response => {
	                	let result = response.data.result;

	                	// is request is returning success response
	                	if (response.data.isSuccess) {
	                        // map the result
	                        this.receiptBox.push(result.map(item => {
	                        	return {
	                        		SaleID: item.SaleID,
	                        		ReceiptNo: item.ReceiptNo,
	                        		PmtAmount: numeral(item.PmtAmount.toLocaleString()).format('0,0.00'),
	                        		PmtMethod: vm.inputs.payment.PmtMethod
	                        	}
	                        }));

	                        // notify that saving colleciton is success.
		                    noty({
		                    	layout: 'bottomLeft',
		                        theme: 'relax', // or relax
		                        type: 'success', // success, error, warning, information, notification
		                        text: `1 record successfully saved.`,
		                        timeout: 5000,
		                    });

		                    // reset fields
		                    this.newCollection();
	                	}

	                	// result of the map
	                    this.receiptBox = _.flatten(this.receiptBox);
	                });
                });
            },
            showTransaction() {
            	let url = '/collections/showTransaction/' + this.inputs.receipt + this.tableName;

                this.showItems(); // fire items
                return axios.get(url).then(response => {
                	this.receiptStatusText = 'result';
                	this.receiptShowBox = _.head(response.data);
                });
            },
            showItems() {
            	let url = '/collections/showItems/' + this.inputs.receipt + this.tableName;

            	this.receiptStatusText = 'receipt';
            	axios.get(url).then(response => {
            		this.receiptStatusText = 'result';
            		this.items = response.data;
            	});
            },
            receiptItemClick(e) {
            	let receipt = parseInt(e.target.parentNode.cells[0].innerHTML, 10);
            	this.inputs.receipt = (receipt != undefined || receipt != null) ? receipt : 0;

            	// check if row of receipt is already click
            	this.inputs.receipt != this.receiptNoClick && this.showTransaction();

            	this.receiptNoClick = this.inputs.receipt;
            },
            receiptItemRemove(args, index) {
            	let url = '/collections/receiptItemRemove' + this.tableName + '&receipt=' + args.ReceiptNo + '&saleid=' + args.SaleID;

            	axios.delete(url).then(response => {
            		// check if response is success
            		if (response.data.isSuccess) {
            			this.receiptBox.splice(index, 1);

            			// notify when deleted.
		                noty({
		                	layout: 'bottomLeft',
		                    theme: 'relax', // or relax
		                    type: 'warning', // success, error, warning, information, notification
		                    text: `1 record successfully deleted.`,
		                    timeout: 5000,
		                });
            		}
            	});
            },
            isReceiptKeyedAlready() {
            	let result = this.receiptBox.filter(item => item.ReceiptNo == this.inputs.receipt);

            	return result.length;
            }
        }
    }
</script>
