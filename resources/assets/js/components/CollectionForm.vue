<template>
	<div class="Collection__form">
		<div class="Collection__title">
			<h2 class="text-center">Collection Form</h2>
		</div>

		<div class="Collection__inputs">
			<!-- Receipt -->
			<div class="form-group">
				<label for="receipt">Receipt Number</label>
				<input type="text" class="form-control" id="receipt" list="receipts" v-model="inputs.receipt" @keyup.enter="showTransaction">
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
						<tr v-for="(list, index) in receiptBox" @click.stop="receiptItemClick(list, $event)">
							<td>{{ list.ReceiptNo }}</td>
							<td>{{ list.PmtAmount }}</td>
							<td>{{ list.PmtMethod }}</td>
							<td class="text-center">
								<button 
									type="button" 
									class="btn btn-warning" 
									@click.stop.self="receiptItemRemove(list, index)"
									:disabled="isDeleteButtonEnable"
								>
									Delete
								</button>
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

						<tr>
							<td></td><td></td>
							<td>
								<span>&nbsp;&nbsp; Sub-deposit</span>
								<em>{{ collectedPaidDate }}</em>
							</td>
							<td><b>{{ collection.SubAmount }}</b></td>
							<td></td><td></td>
						</tr>

						<tr>
							<td></td><td></td>
							<td><span>&nbsp;&nbsp; Remaining Balance</span></td>
							<td>
								<b style="font-size: 1.7em; color: #f55e5e;">{{ remainingBalance }}</b> &nbsp;&nbsp;
								<em>{{ paidBy }}</em>
							</td>
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
				collection: {
					'CollectionPaidDate': null,
					'SubAmount': '',
					'PaymentMethod': null,
					'RemainingBalance': null
				},
				isCollected: false,
				isDeleteButtonEnable: false,
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
        	},
        	collectedPaidDate() {
        		return (
        				this.collection.CollectionPaidDate != null || 
        				this.collection.CollectionPaidDate != undefined
        				) ? this.collection.CollectionPaidDate : '';
        	},
        	remainingBalance() {
        		return (
        				this.collection.RemainingBalance == null || 
        				this.collection.RemainingBalance == undefined ||
        				this.collection.RemainingBalance == ''
        				) ? this.receiptShowBox.Balance : this.collection.RemainingBalance;
        	},
        	paidBy() {
        		return (
						this.collection.PaymentMethod != null || 
        				this.collection.PaymentMethod != undefined
        				) ? '<<< Paid by ' + this.collection.PaymentMethod : '';
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
            	let isEmptyReceipt = (document.querySelector('input#receipt').value.length > 0) ? false : true;

            	// check if balance is paid
            	if (this.isReceiptPaid()) {
					// notify that receipt is paid.
                    noty({
                    	layout: 'bottomLeft',
                        theme: 'relax', // or relax
                        type: 'error', // success, error, warning, information, notification
                        text: 'This receipt is already paid.',
                        timeout: 5000,
                    });
            	} else {
            		// make sure user input receipt #, choose staff and payment to pass the validation
	                if (isEmptyReceipt === false && 
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
	                        // text: `Make sure you enter receipt number`,
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
            	let url = '/collections' + this.tableName;
        		const data = {
        			// for insert
        			SaleID: this.receiptShowBox.SaleID,
        			ReceiptNo: this.inputs.receipt,
        			StaffID: this.staffID,
        			PmtMethodID: this.inputs.payment.PmtMethodID,
        			PmtAmount: this.inputs.amount,
        			Posted: 0,
        			BranchID: Math.floor(this.receiptShowBox.BranchID),
        			OtherSale: 0,
        			// for update
        			// Balance: parseFloat(this.receiptShowBox.Balance) - parseFloat(this.inputs.amount)
        			Balance: this.mainBalance()
        		};

            	// notify on saving.
                noty({
                	layout: 'bottomLeft',
                    theme: 'relax', // or relax
                    type: 'information', // success, error, warning, information, notification
                    text: `Saving new record to database.`,
                    timeout: 5000,
                });

                // store to collection table
            	axios.post(url, data).then(response => {
                	let result = response.data.result;

                	// is request is returning success response
                	if (response.data.isInserted && response.data.isUpdated) {
        				// set collection object & update the balance
		        		this.collection.CollectionPaidDate = this.inputs.dateCollection;
		        		this.collection.PaymentMethod = this.inputs.payment.PmtMethod;
		        		this.collection.SubAmount = numeral(this.inputs.amount.toLocaleString()).format('0,0.00');
		            	this.collection.RemainingBalance = numeral(data.Balance.toLocaleString()).format('0,0.00');

		            	// that means collection is collected
		            	this.isCollected = true;

                        // map the result
                        this.receiptBox.push(result.map(item => {
                        	return {
                        		CollectId: response.data.CollectId,
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

	                    // result of the map
                    	this.receiptBox = _.flatten(this.receiptBox);
                	}
                });
            },
            showTransaction() {
            	let url = '/collections/showTransaction/' + this.inputs.receipt + this.tableName;

            	this.receiptStatusText = 'receipt';
                this.receiptNoClick = this.inputs.receipt;

                this.showItems(); // fire items
                return axios.get(url).then(response => {
                	let data = _.head(response.data);
                	let parseBalance = parseFloat(data.Balance);

                	this.receiptShowBox = data;
 					this.receiptStatusText = 'result';
 					this.isDeleteButtonEnable = false;

                	// set the the amount base on the left balance
                	this.inputs.amount = numeral(parseBalance).format('0,0.00');
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
            receiptItemClick(list, e) {
            	let receipt = parseInt(e.target.parentNode.cells[0].innerHTML, 10);
            	this.inputs.receipt = (receipt != undefined || receipt != null) ? receipt : 0;
            	this.collection.CollectionPaidDate = list.CollectDate;
            	this.collection.SubAmount = list.PmtAmount;
            	this.collection.PaymentMethod = list.PmtMethod;

            	// check if row of receipt is already click
            	if (this.inputs.receipt != this.receiptNoClick) {
            		this.showTransaction();
 					this.isDeleteButtonEnable = true;
            	}

            	this.receiptNoClick = this.inputs.receipt;
            },
            receiptItemRemove(args, index) {
            	this.inputs.receipt = document.querySelector('input#receipt').value;

            	if (this.inputs.receipt.length > 0) {
            		let url = '/collections/receiptItemRemove' + this.tableName + 
            			'&collectid=' + args.CollectId + 
            			'&receipt=' + args.ReceiptNo + 
            			'&saleid=' + args.SaleID +
            			'&balance=' + this.addBalanceWhenReceiptRemove(args.PmtAmount);

            		// notify that receipt is deleting.
	                noty({
	                	layout: 'bottomLeft',
	                    theme: 'relax', // or relax
	                    type: 'error', // success, error, warning, information, notification
	                    text: `Deleting receipt.....`,
	                    timeout: 5000,
	                });

            		axios.delete(url).then(response => {
            			let data = response.data;

	            		// check if response is success
	            		if (data.isUpdated == true && data.isDeleted == true) {
	            			this.receiptBox.splice(index, 1);

	            			// notify when deleted.
			                noty({
			                	layout: 'bottomLeft',
			                    theme: 'relax', // or relax
			                    type: 'success', // success, error, warning, information, notification
			                    text: `1 receipt successfully deleted.`,
			                    timeout: 5000,
			                });
	            		}
	            	});
            	} else {
            		// notify that receipt # is empty
	                noty({
	                	layout: 'bottomLeft',
	                    theme: 'relax', // or relax
	                    type: 'error', // success, error, warning, information, notification
	                    text: `Please enter or select receipt number first.`,
	                    timeout: 5000,
	                });
            	}
            },
            addBalanceWhenReceiptRemove(subdeposit) {
            	if (this.isCollected) {
            		this.collection.RemainingBalance = numeral(parseFloat(this.collection.RemainingBalance) + parseFloat(subdeposit)).format('0,0.00');
            		return this.collection.RemainingBalance;
            	} else {
            		this.receiptShowBox.Balance = numeral(parseFloat(this.receiptShowBox.Balance) + parseFloat(subdeposit)).format('0,0.00');;
            		return this.receiptShowBox.Balance;
            	}
            },
            mainBalance() {
				let result = 0;

            	if (this.isCollected)
            		result = parseFloat(this.collection.RemainingBalance) - parseFloat(this.inputs.amount)
            	else 
            		result = parseFloat(this.receiptShowBox.Balance) - parseFloat(this.inputs.amount)

            	return result;
            },
            isReceiptPaid() {
            	return (this.mainBalance() < 0) ? true : false;
            }
        }
    }
</script>
