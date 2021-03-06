export default {
	fetchDataOld({ commit }, { self }) {
		self.$http({
            url: 'user',
            method: 'GET',
        })
        .then((res) => {
            commit('fetchUsers', res.data.users);
            commit('fetchFields', res.data.fields);
            commit('fetchRoles', res.data.roles);
            //self.getData();
        }, (res) => {
            console.log('error '+res);
        });
	},
	fetchData({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'user',
                method: 'GET',
            })
            .then((res) => {
                commit('fetchUsers', res.data.users);
                commit('fetchFields', res.data.fields);
                commit('fetchRoles', res.data.roles);
                commit('setLoading',false);
                resolve();
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },fetchDrives({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'drive',
                method: 'GET',
            })
            .then((res) => {
                commit('fetchDrives', res.data.drives);
                commit('setLoading',false);
                self.driveToCal('today',1);
    	        resolve();
    	    })
    	    .catch((error) => {
    	        console.log(error.statusText);
    	    })
    	})
    },fetchHours({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'hour?page='+self.page,
                method: 'GET',
            })
            .then((res) => {
                commit('fetchHours', res.data.paginator);
                //commit('fetchHours', res.data.hours);
                commit('setLoading',false);
                //self.driveToCal('today',1);
                resolve();
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },fetchPayments({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'payment?page='+self.page,
                method: 'GET',
            })
            .then((res) => {
                commit('fetchPayments', res.data.paginator);
                commit('fetchCostNames', res.data.costNames);
                commit('setLoading',false);
                resolve();
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },storeUser({ commit }, { self }){
        self.processing = true;
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'user',
                method: 'POST',
                data: self.user
            })
            .then((res) => {
                commit('addUser',res.data.user);
                self.processing = false;
                self.close();
                resolve();
            })
            .catch((error) => {
                self.processing = false;
                console.log(error.statusText);
            })
        })
    },fetchRoles({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'role',
                method: 'GET',
            })
            .then((res) => {
                commit('fetchRoles', res.data.roles);
                commit('setLoading',false);
                resolve();
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },fetchPerms({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: '/role/permission',
                method: 'GET',
            })
            .then((res) => {
                commit('fetchPerms', res.data.permissions);
                commit('setLoading',false);
                resolve(self.roleWithPerms = res.data.roleWithPerms);
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },
    fetchPermissions({ commit }, { self }) {
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: '/permission',
                method: 'GET',
            })
            .then((res) => {
                commit('fetchPerms', res.data.permissions);
                commit('setLoading',false);
                resolve();
            })
            .catch((error) => {
                console.log(error.statusText);
            })
        })
    },storeRolePerms({ commit }, { self }){
        self.processing = true;
        return new Promise((resolve, reject) => {
            console.log(self.perms);
            self.$http({
                url: 'role/'+self.role+'/permissionUpdate',
                method: 'PATCH',
                data: self.perms
            })
            .then((res) => {
                self.$parent.roleWithPerms = res.data.roleWithPerms;
                self.processing = false;
                self.close();
                resolve();
            })
            .catch((error) => {
                self.processing = false;
                console.log(error.statusText);
            })
        })
    },storeRole({ commit }, { self }){
        self.processing = true;
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'role',
                method: self.add ? 'POST' : 'PATCH',
                data: self.role
            })
            .then((res) => {
                commit(self.add ? 'addRole' : 'updateRole',res.data.role);
                self.processing = false;
                self.close();
                resolve();
            })
            .catch((error) => {
                self.processing = false;
                console.log(error.statusText);
            })
        })
    },fetchStudentById({ commit }, { self }){
        //self.processing = true;
        commit('setLoading',true);
        return new Promise((resolve, reject) => {
            self.$http({
                url: 'student',
                method: 'GET',
                data: self.student.id
            })
            .then((res) => {
                //commit(self.add ? 'addRole' : 'updateRole',res.data.role);
                //self.processing = false;
                //self.close();
                commit('setLoading',false);
                commit('fetchStudent', res.data.student);
                commit('fetchCostNames', res.data.costNames);
                resolve();
            })
            .catch((error) => {
                //self.processing = false;
                commit('setLoading',false);
                console.log(error.statusText);
            })
        })
    },fetchServices({ commit }){
        //self.processing = true;
        commit('setLoading',true);
        axios.get('service')
            .then(res => {
                commit('setLoading',false);
                commit('fetchServices', res.data.services);
                resolve();
            })
            .catch(err => {
                //self.processing = false;
                commit('setLoading',false);
                console.log(err.statusText);
            })
    },deleteService( {commit} , service ){
        console.log(service);
        axios.delete('service/'+service.id)
            .then(res => {
                console.log(res);
                if(res.data.msg === 'Ok'){
                    console.log('Poszlo');
                    //commit('deleteService',service.id);
                }
            }).catch(err => {
                console.log(err);
            })  
    },deleteEntry( { commit }, data){
        console.log(commit);
        console.log(data);
        axios.delete(data.model.toLowerCase()+'/'+data.obj.id)
            .then(res => {
                if (res.data.msg === 'Ok') {
                    console.log('delete'+data.model);
                    commit('delete'+data.model, data.obj.id);
                }
            }).catch(err => {
                console.log(err);
            })

    }
}