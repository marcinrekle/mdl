<template>
    <a href="#" @click="deleteElem" class="btn btn-danger">Usuń</a>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted delete.')
        },
    	methods: {
    		deleteElem: function(event) {
        		if(confirm('Czy na pewno chcesz usunąć ?')) $(event.target).parent().submit();
        	}
    	}
    }
</script>
