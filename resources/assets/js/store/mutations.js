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
	setLoading(state, loading){
		state.isLoading = loading;
	},
	fetchDrives(state, drives){
		state.drives = drives;
	},
	updateDrive(state,drive){
		state.drives = [...state.drives.filter(element => element.id != drive.id),drive];
	},
	deleteDrive(state,id){
		state.drives = state.drives.filter(element => element.id != id);
	},
}