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
                            <h2><b>MOVIES </b>LIST</h2>
                        </div>
                        <div class="col-sm-6">					
                            <button class="btn btn-success" @click="createm()"><span>Create New Movie</span></button>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="column">ID</td>
                            <td class="column">TITLE</td>
                            <td class="column">SYNOPSIS</td>
                            <td class="column">GENRE</td>
                            <td class="column">DATE</td>
                            <td class="column">RUNTIME</td>
                            <td class="column">DIRECTOR</td>
                            <td class="column">PICTURE</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="movie in movies" v-bind:key="movie.id">
                            <td>{{movie.id}}</td>
                            <td>{{movie.title}}</td>
                            <td>{{movie.synopsis}}</td>
                            <td>{{movie.genre}}</td>
                            <td>{{movie.date}}</td>
                            <td>{{movie.runtime}} min</td>
                            <td>{{movie.director}}</td>
                            <td>{{movie.picture}}</td>
                            <td class="actions">
                                <button class="update"><router-link :to="`/admin/movies/${movie.id}`" class="tag">UPDATE</router-link></button>
                                <button class="delete" @click="deleteu(movie.id)">DELETE</button>
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
            movies:[],
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

        axios.get('http://localhost:8000/api/movies')
        .then(response => {
            this.movies = response.data
            console.log(response.data.length)
        }).catch(error => {
            console.log('Error : ', error.response)
        })

    },

    methods: {
        getAdmin(){
            this.admin = localStorage.getItem("uRole")
        },

        createm() {
            this.$router.push('/admin/createmovie')
        },

        movies() {
            this.$router.push('/admin/movies')
        },

        users() {
            this.$router.push('/admin/homeadmin')
        },

        deleteu(id) {
            if(confirm("Are you sure you want to delete this movie ?")) {
            axios.delete('http://localhost:8000/api/deletemovie/' + id)
            .then( () => {
                this.movies = this.movies.filter((e)=> e.id != id)
                alert("Movie successfully deleted")
                this.$router.push('/admin/movies')
                
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

.us {
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