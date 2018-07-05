<template>
    <div id="editUserModal" class="modal" v-if>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    Edycja {{user.name}}
                </div>
                <div class="modal-body">
                    <h1>Test</h1>    
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
                    avatar:'',
                    email:'',
                    confirmed:'',
                    status:'',
                    attrs : {
                    }
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