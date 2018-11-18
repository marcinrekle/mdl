export default {
	//users: state => state.users,
	//fields: state => state.fields,
	//roles: state => state.fields,
	getData: (state) => [state.users,state.fields,state.roles],
	getUserById: state => (id) => state.users.find(user => user.id === id),
	getUsersByRole: state => role => state.users.filter(user => user.roles[0].name === role),
	students: (state, getters) => getters.getUsersByRole('Student').map(user => ({'id' : user.id, 'name' : user.name})),
	students2: state => {
		console.log(state.users);
		console.log(state.users.filter(user => user.roles[0].name === 'Student').map(user => ({'id' : user.id, 'name' : user.name})))
		return state.users.filter(user => user.roles[0].name === 'Student').map(user => ({'id' : user.id, 'name' : user.name}))
	},
	isLoading: state => state.isLoading,
}