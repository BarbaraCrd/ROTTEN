<template>
<div class="Allmovies">
<div class="top">
        <div class="container">
            <Navbar/>
        </div>    
</div>
        <div class="container">
            <div class="search">
            <input type="text"        
                :value="search"
                placeholder="Search by title"
                @keyup.enter="getSearch"
                label="Search movie...."
                hide-details="auto">     
            </div>
            <div class="bouttonF">
            <button type="button" class="btn btn-danger" @click="filter('popular')">Popular</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=28')">Action</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=12')">Aventure</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=16')">Animation</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=35')">Comedy</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=80')">Crime</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=99')">Documentary</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=18')">Drama</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=10751')">Family</button>
            </div>
            <div class="bouttonF">
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=14')">Fantasy</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=36')">History</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=27')">Horror</button>   
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=10402')">Music</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=9648')">Mystery</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=878')">Science Fiction</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=10770')">TV Movie</button>        
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=53')">Thriller</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=10752')">War</button>
            <button type="button" class="btn btn-danger"  @click="filter('with_genres=37')">Western</button>  
            </div>
            <div class="allCards" v-if="!search">
                <div class="card"  v-for="(movie, index) in movies" :key="index.id" style="width: 13rem;">
                <router-link :to="`/movies/${movie.id}/read`" class="tag">
                <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" widht="13rem" height="301" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{movie.original_title }} </h5>
                        <p class="card-text">{{movie.release_date }}</p>
                        <p class="pop">Vote average: {{movie.vote_average }}/10</p>
                    </div>
                </div>
                <div class="card"  v-for="(movie, index) in moviesdb" :key="index.id" style="width: 13rem;">
                <router-link :to="`/movies/${movie.id}/readmovie`" class="tag">
                <img class="card-img-top" v-bind:src="'http://localhost:8000/' + movie.picture" widht="13rem" height="301" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{movie.title }} </h5>
                        <p class="card-text">{{movie.date }}</p>
                        <p class="pop">Vote average: /10</p>
                    </div>
                </div>
            </div>
            <div class="allCards" v-else-if="search">
                <div class="card"  v-for="(movie, index) in searchedMovies" :key="index.id" style="width: 13rem;">
                <router-link :to="`/movies/${movie.id}/read`" class="tag">
                <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" widht="13rem" height="301" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{movie.original_title }} </h5>
                        <p class="card-text">{{movie.release_date }}</p>
                        <p class="pop">Vote average: {{movie.vote_average }}/10</p>
                    </div>
                </div>
            </div>
            
        </div>


</div>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import axios from 'axios'
export default {
    name: "Allmovies",
    data(){
        return{
            value:[],
            moviesdb:[],
        }
    },
    mounted(){
      if (this.$route.query.p) {
      this.page = Number(this.$route.query.p);
    } else {
      this.page = 1;
    }
    this.getMovies();
   
    axios.get('http://localhost:8000/api/movies')
        .then(response => {
            this.moviesdb = response.data
            console.log(this.moviesdb)
        }).catch(error => {
            console.log('Error : ', error.response)
    })

    },
     computed: {
    ...mapState({
      search: (state) => state.search,
    }),
     ...mapState([
      "movies",
      "search",
      "searchedMovies",
      "selectFilter",
    ]),
     },
     methods: {
    ...mapActions(["searchMovies", "getMovies"]),
    ...mapMutations(["clear"]),
    clear2() {
      this.clear();
      this.$router.push({ path: "/movies/allmovies" });
      this.getMovies();
    },
 
    getSearch(e) {
      this.$store.commit("getSearch", e.target.value);
      this.searchMovies();
      this.$router.push({
        query: { q: e.target.value },
        path: "/movies/allmovies"
      });
    },

        filter(selected) {
      if (this.$store.state.selectFilter != selected) {
        this.$store.commit("setSelectFilter", selected);
        this.$router.push({
          query: { filter: this.$store.state.selectFilter },
        });
        this.clear();
        this.getMovies();
      } else {
        this.clear();
      }
    },
     }
}

</script>

<style scoped>
.card-body{
  background-color:#beae75
}

.card{
    margin-right: 1%;
    margin-bottom: 1%;
}

.allCards{
    margin-top: 10%;
    display: flex;
    flex-wrap: wrap;
}

.Allmovies{
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
}

.top{
    background-color: #F7E6AA;
    background-image: url('https://cdn.vectorstock.com/i/1000x1000/82/69/popcorn-seamless-pattern-vector-21598269.webp');
    background-size: 30%;
    
}

input{
    margin-top: 5%;
}

.bouttonF{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    margin-top: 1%;
}

button{
    margin-top: 1%;
}

.container{
    background-color: #F7E6AA;
}

</style>