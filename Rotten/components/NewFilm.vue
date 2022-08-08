<template>
<div class="newFilm">
    <div class="card" v-for="movie in movies.slice(0, 5)" :key="movie.id" style="width: 13rem;">
  <router-link :to="`/movies/${movie.id}/read`" class="tag">
    <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Card image cap">
  </router-link> 
  <div class="card-body">
    <h5 class="card-title">{{movie.original_title }} </h5>
     <p class="card-text">{{movie.release_date }}</p>
    <p class="pop">Vote average: {{movie.vote_average }}/10</p>
  </div>
</div>
</div>
</template>

<script>

export default {
    name:"NewFilm",
        data(){
        return {
            movies: [],
        }
    },
    mounted(){
      const url = `https://api.themoviedb.org/3/movie/upcoming?&api_key=de54d62bf9e00c29e63f7cb274ff0282`

    fetch(url)
    .then((response) => response.json())
    .then ((data) => this.movies = data.results)      
   
    }
}
</script>

<style scoped>

.newFilm{
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}

.card-body{
  background-color:#beae75
}

.card{
  margin-bottom: 10%;
}

</style>