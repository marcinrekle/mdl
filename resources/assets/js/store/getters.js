export default {
	getUsers: state => {
		return state.users;
	},
	getFields: state => {
		return state.fields;
	},
	getRoles: state => {
		return state.roles;
	},
	getData: (state, getters) => {
		return [state.users,state.fields,state.roles];
	},
}