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
	updateHourInDrive(state,hour){
		let drive = state.drives.find(element => element.id == hour.drive_id);
		let h = drive.hours.find(element => element.id == hour.id);
		h.count = hour.count;
	},
	fetchHours(state, hours){
		state.hours = hours;
	},
	updateHour(state,hour){
		state.hours = [...state.hours.filter(element => element.id != hour.id),hour];
		//drive.hours.find(element => element.id == hour.id) = hour;
	},
	fetchPayments(state, payments){
		state.payments = payments;
	},
	fetchCostNames(state, costNames){
		state.costNames = costNames;
	},
}