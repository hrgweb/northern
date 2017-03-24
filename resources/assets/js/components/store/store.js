import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
	state: {
		icList: [],
		customers: [],
		tblCustomer: '',
		authUser: {},
	},
	getters: {

	},
	mutations: {
		REPLACE_NULL_WITH_EMPTY_STRING(state, data=[]) {
			state.customers = data.map(elem => {
				let nullValue = '';

				return {
					CustID: elem.CustID,
					IC: (elem.IC != null) ? elem.IC : nullValue,
					FirstName: (elem.FirstName != null) ? elem.FirstName : nullValue,
					Surname: (elem.Surname != null) ? elem.Surname : nullValue,
					HandPhone: (elem.HandPhone != null) ? elem.HandPhone : nullValue,
					HomePhone: (elem.HomePhone != null) ? elem.HomePhone : nullValue,
					Email: (elem.Email != null) ? elem.Email : nullValue,
					Country: elem.Country,
					Building: elem.Building,
					Block: elem.Block,
					Postcode: elem.Postcode,
					Street: elem.Street,
					Gender: (elem.Gender == 'M') ? 'Male' : 'Female',
					Salutation: elem.Salutation,
					Unit: elem.Unit,
					System: elem.System,
					Occupation: elem.Occupation,
					Remark: elem.Remark,
					DOB: elem.DOB
				};
			});
		},
		SET_TABLE_NAME(state, table) {
			state.tblCustomer = table;
		},
		SET_IC_LIST(state, customers) {
			state.icList = _.flatten(customers.map(elem => {
				let newList = [];

				newList.push(elem.IC);

				return newList;
			}));

			return state.icList;
		},
		SET_AUTH_USER(state, user) {
			state.authUser = user;
		}
	},
	actions: {
		ALL_CUSTOMER(context, table) {
			return axios.get('/customers/allCustomer/' + table).then(response => {
				let data = response.data;

				context.commit('REPLACE_NULL_WITH_EMPTY_STRING', data.records);
				context.commit('SET_TABLE_NAME', data.table);
				context.commit('SET_IC_LIST', data.records);

				return data;
			});
		},
		
	}
});