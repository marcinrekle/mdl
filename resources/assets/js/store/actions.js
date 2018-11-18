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
    }
}