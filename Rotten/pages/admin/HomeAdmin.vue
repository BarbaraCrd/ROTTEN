<template>
 <div class="admin">
        <div class="container">
            <Navbar/>
            <div class="boutonP">
                <button class="btn movies" @click="movies()"><span>MOVIES PANEL</span></button>
                <button class="btn users" @click="users()"><span>USERS PANEL</span></button>
            </div>

        </div> 
        <div class="container us">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2><b>USERS </b>LIST</h2>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-success" @click="createu()"><span>Create New User</span></button>					
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="column">ID</td>
                            <td class="column">FIRST NAME</td>
                            <td class="column">LAST NAME</td>
                            <td class="column">EMAIL</td>
                            <td class="column">PASSWORD</td>
                            <td class="column">ROLE</td>
                            <td class="column">ACTIONS</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" v-bind:key="user.id">
                            <td>{{user.id}}</td>
                            <td>{{user.firstName}}</td>
                            <td>{{user.lastName}}</td>
                            <td>{{user.email}}</td>
                            <td><button class="updatep"><router-link :to="`/admin/users/${user.id}/updatepassword`" class="tag">UPDATE PASSWORD</router-link></button></td>
                            <td>{{user.uRole}}</td>
                            <td class="actions">
                                <button class="update"><router-link :to="`/admin/users/${user.id}/updateinformations`" class="tag">UPDATE</router-link></button>
                                <button class="delete" @click="deleteu(user.id)">DELETE</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name:"HomeAdmin",
    data() {
        return {
            users:[],
        }
    },

    created(){
      if(process.client)
      {
      this.getAdmin()
      }
    },

    mounted() {

        if (this.admin == 0){
            this.$router.push('/home')
        }

        axios.get('http://localhost:8000/api/users')
        .then(response => {
            this.users = response.data
            this.nbusers = response.data.length
            console.log(response.data.length)
        }).catch(error => {
            console.log('Error : ', error.response)
    })


    },

    methods: {

        getAdmin(){
            this.admin = localStorage.getItem("uRole")
        },

        createu() {
            this.$router.push('/admin/createuser')
        },

        movies() {
            this.$router.push('/admin/movies')
        },

        users() {
            this.$router.push('/admin/homeadmin')
        },

        deleteu(id) {
            if(confirm("Are you sure you want to delete this user ?")) {
            axios.delete('http://localhost:8000/api/destroyUser/' + id)
            .then( () => {
                this.users = this.users.filter((e)=> e.id != id)
                alert("User successfully deleted")
                this.$router.push('/admin/homeadmin')
                
            })}
        }
    }

}
</script>

<style scoped>

.admin{
        background-color: #FCEBA7;
    	background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
		background-position: center;
		background-repeat: repeat;
		background-size: 30%;
        
}

.us{
    margin-top: 8%;
    background-color: #FCEBA7;
    display:flex;
    flex-direction: column;
    width: 1110px;
    height: auto;
    border-radius: 10px;
    border-style:solid;
    border-width: 3px;
    border-color: #E22E2F;
    padding-bottom: 25% ;
}

.row {
    margin-top:2%;
    margin-bottom:2%;
    color: #E22E2F;

}
table {
    color: #000000;
}

.btn {
    margin-left: -5.5%;
}
.column {
    font-weight: bold;
    color: #E22E2F;
}

.movies {
    border-radius:5px;
    background: #FCEBA7;
    border-style:solid;
    border-width: 3px;
    border-color: #E22E2F;
    color: #E22E2F;
    font-weight: bold;
    outline: none;
    width: 30%;
    height:100px;
    text-decoration: none;

}

.users{
    border-radius:5px;
    background: #FCEBA7;
    border-style:solid;
    border-width: 3px;
    border-color: #E22E2F;
    color: #E22E2F;
    font-weight: bold;
    outline: none;
    width: 30%;
    height:100px;
    text-decoration: none;
}
.updatep {

    border-radius:5px;
    background: #FCEBA7;
    border:solid, 1px;
    border-color: #E22E2F;
    outline: none;
    text-decoration: none;
}

.update {

    border-radius:5px;
    margin-right: 5%;
    background: #FCEBA7;
    border:solid, 1px;
    border-color: #E22E2F;
    outline: none;
    text-decoration: none;
}

.delete {
    
    border-radius:5px;
    background: #E22E2F;
    border:solid, 1px;
    border-color: #E22E2F;
    outline: none;
}

.tag {
    text-decoration: none;
    text-decoration-color: #1f2029;
    color: #1f2029;
}

.boutonP{
    background-color: #FCEBA7;
    display: flex;
    justify-content: space-around;
    padding-left: 5%;
    padding-top: 5%;
    padding-bottom: 10%;
    margin-bottom: -20%;
}

</style>