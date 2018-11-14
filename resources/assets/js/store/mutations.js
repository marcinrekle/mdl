export default {
	fetchUsers(state, users){
		state.users = users;
	},
	fetchFields(state, fields){
		state.fields = fields;
	},
	fetchRoles(state, roles){
		state.roles = roles;
	},
}