<template>
    <div id="editUserModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Edycja {{user.name}}
                    <button type="button" class="close" @click="ShowUserEditForm = false">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form" autocomplete="off" @submit.prevent="update" method="post"> 
                        <div class="form-group">
                            <label for="name">Imie Nazwisko</label>
                            <input type="name" id="name" class="form-control" placeholder="Jan Nowak" v-model="user.name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="user.email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Adres</label>
                            <input type="input" id="address" class="form-control" placeholder="ul. Polna 123" v-model="user.attrs.address" required>
                            <label for="phone">Telefon</label>
                            <input type="input" id="phone" class="form-control" placeholder="123456789" v-model="user.attrs.phone" required>
                            <label for="cost_course">Koszt kursu</label>
                            <input type="number" id="cost_course" class="form-control" placeholder="1400">
                            <label for="cost_course">Koszt lekarza</label>
                            <input type="number" id="cost_doctor" class="form-control" placeholder="200" v-model="user.attrs.cost_doctor" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>   
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
    export default{
		data() {
			return {
				user: {
                    id:'',
                    name:'',
                    email:'',
                    attrs : [],
                    roles:[],
                    avatar:'',
                    confirmed:'',
                    status:'',
                },
                error: [],
			}
		},
		mounted() {
            console.log('edituserform');
        },
		methods: {
			userEdit(user){
                user.id = 8;
                user.name = "Brat Szwagra";
				this.$http({
                    url: 'user'+user.id,
                    method: 'PATCH',
                    data: user
                })
                .then((res) => {
                    this.users = res.data.user;
                }, (res) => {
                    console.log('error'+res);
                });
			},
            
		}
	}
</script>
<style>
    .modal {
        display:block;
    }
</style>