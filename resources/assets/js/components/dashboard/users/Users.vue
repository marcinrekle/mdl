<template>
	<div class="card">
    	<div class="card-header">
    	    <h1>Dash</h1>
    	    <b>Username:</b> {{ $auth.user().name }}
    	    </div>
    	<div class="card-body">
    	    <table class="table table-striped">
    	        <tr>
    	            <th>Id</th>
    	            <th>Imie nazwisko</th>
    	            <th>email</th>
    	            <th>Rola</th>
    	            <th>Akcje</th>
    	        </tr>
    	        <tr 
    	            v-for="user in users" 
    	            :key="user.id"
    	        >
    	            <td>{{ user.id }}</td>
    	            <td>{{ user.name }}</td>
    	            <td>{{ user.email }}</td>
    	            <td v-for="role in user.roles">{{ role.display_name }}</td>
    	            <td>
    	                <button type="button" class="btn btn-sm btn-primary" @click="showUserEditForm(user)">
    	                    <i class="fa fa-edit"></i>
    	                </button>
    	                <button type="button" class="btn btn-sm btn-danger" @click="deleteUser(user)">
    	                    <i class="fa fa-trash"></i>
    	                </button>
    	            </td>
    	        </tr>
    	    </table>
    	</div>
	</div>	
</template>
<script>
	import UserEditForm from './UserEditForm.vue';
	export default{
		data() {
			return {
				users: [],
				ShowUserEditForm : false
			}
		}
	}
</script>
<style>

</style>