export default {
	fetchUsers(state, users){
		state.users = users;
	},
	fetchFields(state, fields){
		state.fields = fields;
	},
	fetchRoles(state, roles){
		state.roles = roles;
	},fetchPerms(state, permissions){
		state.permissions = permissions;
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
	fetchHours(state, hours){
		state.hours = hours;
	},
	updateHourInDrive(state,hour){
		let drive = state.drives.find(element => element.id == hour.drive_id);
		let h = drive.hours.find(element => element.id == hour.id);
		h.count = hour.count;
	},
	updateHour(state,hour){
		state.hours.data = [...state.hours.data.filter(element => element.id != hour.id),hour];
		//drive.hours.find(element => element.id == hour.id) = hour;
	},
	updateUser(state,user){
		state.users = [...state.users.filter(element => element.id != user.id),user];
	},
	addUser(state,user){
		state.users.push(user);
	},
	addRole(state,role){
		state.roles.push(role);
	},
	updateRole(state,role){
		state.roles = [...state.roles.filter(element => element.id != role.id),role];
	},
	fetchPayments(state, payments){
		state.payments = payments;
	},
	fetchCostNames(state, costNames){
		state.costNames = costNames;
	},
	fetchStudent(state, student){
		state.student = student;
	},
}