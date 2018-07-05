<template>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
       <users />
       <UserEditForm v-show="ShowUserEditForm" @close="ShowUserEditForm = false" />
    </main>
</template>
<script>
    import UserEditForm from './UserEditForm.vue';
    import Users from './dashboard/users/Users.vue';
    export default{
        components: {
            Users,
            UserEditForm
        },
		data() {
			return {
				users: [],
                notify: [],
                ShowUserEditForm : false
			}
		},
		mounted() {
            this.getUsers();
        },
		methods: {
			getUsers(){
				this.$http({
                    url: 'user',
                    method: 'GET',
                })
                .then((res) => {
                    this.users = res.data.users;
                }, (res) => {
                    console.log('error'+res);
                });
			},
            deleteUser(user) {
                let confirmed = confirm('Skasowac '+user.name+' ?');
                if(confirmed){
                    this.$http({
                        url: 'user/'+user.id,
                        method : 'DELETE'
                    })
                    .then((res) => {
                        this.notify = res.data.message;
                        console.log(res.data.message);
                    }, (res) => {
                    console.log('error : '+res);
                });
                }
            },
            showUserEditForm(user){
                let cuser = this.$children[0].user;
                console.log(cuser);
                console.log(user);
                for(let key in cuser) {
                    cuser[key] = (key == 'attrs' ? user[key].values : user[key]);
                }
                console.log(cuser);
            }
		}
	}
</script>