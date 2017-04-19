<template>
    <div class="Collection__form">
        <div class="Collection__title">
            <h2 class="text-center">Collection Form</h2>
        </div>

        <div class="Collection__inputs">
            <!-- Receipt -->
            <div class="form-group">
                <label for="receipt">Receipt Number</label><br>
                <input type="text" class="form-control" id="receipt" v-model="inputs.receipt">
            </div>

            <!-- Auto close -->
            <div class="form-group">
            <input type="checkbox" id="close" v-model="inputs.close" :checked="inputs.close"><br>
                <label for="close">Auto Close</label>
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="dateCollection">Date of collection</label><br>
                <input type="text" class="form-control" id="dateCollection" v-model="inputs.receipt">
            </div>

            <!-- Staff -->
            <div class="form-group">
                <label for="staff">Staff</label><br>
                <select class="form-control" id="staff" v-model="inputs.staff">
                    <option value="select">SELECT STAFF</option>
                </select>
            </div>

            <!-- Amount -->
            <div class="form-group">
                <label for="amount">Amount</label><br>
                <input type="text" class="form-control" id="amount" v-model="inputs.amount">
            </div>

            <!-- Payment -->
            <div class="form-group">
                <label for="payment">Payment Method</label><br>
                <select class="form-control" id="payment" v-model="inputs.payment">
                    <option value="select">SELECT PAYMENT</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="form-group">
                <button type="button" class="btn btn-info">New</button>
                <button type="button" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-danger">Close</button>
            </div>
        </div>

        <div class="Collection__body">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                inputs: {
                    close: 'checked',
                    staff: 'select',
                    payment: 'select'
                }
            }
        }
    }
</script>
