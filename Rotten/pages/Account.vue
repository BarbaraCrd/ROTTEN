<template>
<div class="global">
    <div class="top">
    <div class="container">
            <Navbar/>
    </div>
    </div>
    <div class="container">
         <div class="title">Your Informations</div>
    <div class="profile" v-for="user in users" v-bind:key="user.id">
      <div class="infos">
      <div class="firstName">
          <label>First Name :</label> {{user.firstName}}
      </div>
      <div class="lastName">
          <label>Last Name :</label> {{user.lastName}}
      </div>
      <div class="email">
          <label>Email :</label> {{user.email}}
      </div>
      </div>
      <div class="button">
      <button class="updatei"><router-link :to="`/users/${user.id}/updatei`" class="tag">
          Update your informations
      </router-link></button>
      <button class="updatep"><router-link :to="`/users/${user.id}/updatep`" class="tag">
          Update your password
      </router-link></button>
      <button @click="deleteU(user.id)" class="deletea">
          Delete your account
      </button>
    </div>
  </div>
  <div class="favorites">
      <div class="title">Your Favorites Movies</div>
        <div class="movies">
            <div class="card"  v-for="favorite in favorites" v-bind:key="favorite.id" style="width: 13rem;">
                <router-link :to="`/movies/${favorite.movie_id}/readmovie`" class="tag">
                <img class="card-img-top" v-bind:src="'http://localhost:8000/' + favorite.picture" width="13rem" height="301" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{favorite.title }} </h5>
                        <p class="card-text">{{favorite.date }}</p>
                        <p class="pop">Vote average: /10</p>
                    </div>
            </div>
            
            <div class="card" v-for="toto in totos" v-bind:key="toto.id" style="width: 13rem;">
                <router-link :to="`/movies/${toto.id}/read`" class="tag">
                <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${toto.poster_path}`" width="13rem" height="301" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title"> {{toto.original_title}}</h5>
                        <p class="card-text">{{toto.release_date}}</p>
                        <p class="pop">Vote average: {{toto.vote_average}}/10</p>
                    </div>
            </div>
        </div>
  </div>
    </div>
   
</div>
</template>

<script>
import axios from 'axios'
export default {
    name:"ProfileView",
    data() {
        return {
            users:[],
            favorites:[],
            totos: {},
            id:"",
        }
    },

    created(){
      if(process.client)
      {
      this.getLogin()
      }
    },


    mounted() {

        if (this.login == null){
            this.$router.push('/login')
        }

        axios.get('http://localhost:8000/api/users')
        .then(response => {
            this.users = response.data.filter(element => element.id == localStorage.getItem('userId'))
            console.log(this.users[0])
        }).catch(error => {
            console.log('Error : ', error.response)
        })

        axios.get('http://localhost:8000/api/favorites/' + localStorage.getItem('userId'))
        .then(response => {
            this.favorites = response.data
            console.log(this.favorites)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
       
        axios.get(`https://api.themoviedb.org/3/account/12380890/favorite/movies?api_key=de54d62bf9e00c29e63f7cb274ff0282&session_id=${localStorage.getItem('session_id')}&language=en-US&sort_by=created_at.asc&page=1`)
        .then(response => {
            this.totos = response.data.results
            console.log(this.totos)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
        


    },

    methods:{
        getLogin(){
            this.login = localStorage.getItem("userId")
        },

        deleteU(id) {
            if(confirm("Are you sure you want to delete your account ?")) {
            axios.delete('http://localhost:8000/api/destroyUser/' + localStorage.getItem('userId'))
            .then( () => {
                this.users = this.users.filter((e)=> e.id != id)
                alert("Account successfully deleted")
                this.$router.push('/')
                
             })}
        },

    }

}
</script>

<style scoped>
.global {
        background: #FCEBA7;
    	background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
		background-position: center;
		background-repeat: repeat;
		background-size: 30%;
        padding-top: 1%;
}

.profile {
    background-color: #FCEBA7;
    color:#E22E2F;
    display: flex;
    justify-content: space-between;
    
}
.infos {
    display: flex;
    flex-direction: column;
    padding-left: 15%;
}

.button {
    display: flex;
    flex-direction: column;
    width: 40%;
    padding-top: 1%;
}

.title {
    background: #FCEBA7;
	font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
    display: flex;
    justify-content: center;
    padding-top: 3%;
    margin-top: -0.5%;

}

label {
    padding-right: 3%;
    font-weight: 700;
    font-size: 18px;
    color: #E22E2F;

}

.firstName {
    padding-top:1%;
    color: black;
}

.lastName {
    padding-top:1%;
    color: black;
}

.email {
    padding-top:1%;
    color: black;
    margin-right: 10%;
}

.updatei {
    margin-top:1%;
    width: 60%;
    border-radius:5px;
    background: #FCEBA7;
    border:none;
    outline: none;
}

.updatep {
    margin-top:1%;
    width: 60%;
    border-radius:5px;
    background: #FCEBA7;
    border:none;
    outline: none;
}

.deletea {
    margin-top:1%;
    width: 60%;
    border-radius:5px;
    background: red;
    border:none;
    outline: none;
}
.movies {
    color: black;
    margin-top: 3%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding-bottom: 51.5%;
}

.favorites {
    border-radius: 10px;
    background-color: #FCEBA7;
}
.card{
    margin-bottom: 1%;
    margin-left: 1%;
}

.card-body{
  background-color:#beae75
}

.top{
    margin-top: -1%;
}
</style>