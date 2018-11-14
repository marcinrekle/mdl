export default {
	fetchData({ commit }, { self }) {
		self.$http({
            url: 'user',
            method: 'GET',
            })
            .then((res) => {
                commit('fetchUsers', res.data.users);
                commit('fetchFields', res.data.fields);
                commit('fetchRoles', res.data.roles);
                self.getData();
            }, (res) => {
                console.log('error '+res);
        });
	}
}