export default {
	//users: state => state.users,
	//fields: state => state.fields,
	//roles: state => state.fields,
	getData: (state) => [state.users,state.fields,state.roles],
	getUserById: state => (id) => state.users.find(user => user.id === id),
	getUsersByRole: state => role => state.users.filter(user => user.roles[0].name === role),
	getUsersByRole2: state => role => {
	},
}