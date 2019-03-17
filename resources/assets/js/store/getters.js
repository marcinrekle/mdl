export default {
	//users: state => state.users,
	//fields: state => state.fields,
	//roles: state => state.fields,
	getData: (state) => [state.users,state.fields,state.roles],
	getUserById: state => (id) => state.users.find(user => user.id === id),
	getUsersByRole: state => role => state.users.filter(user => user.roles[0].name === role),
	students: (state, getters) => getters.getUsersByRole('Student').map(user => ({'id' : user.id, 'name' : user.name})),
	drives: (state) => state.drives,
	isLoading: state => state.isLoading,
	getDriveByDate: state => date => state.drives.filter(drive => drive.day === date),
}