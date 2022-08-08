<template>
<div class="mainC">
  <div class="caroussel">
    <h1> TOP 24H MOVIES</h1>
    <b-carousel
      id="carousel-1"
      v-model="slide"
      :interval="2000"
      background="#F7E6AA"
      img-width="1024"
      img-height="280"
      style="text-shadow: 1px 1px 2px #333;"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
       
    >

      <!-- Slides with custom text -->
      <div class="carou" v-for="movie in movies" v-bind:key="movie.id">
        <router-link :to="`/movies/${movie.id}/read`" class="tag">
          <b-carousel-slide v-bind:img-src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`">
          </b-carousel-slide>
        </router-link>
      </div>
    </b-carousel>
    <h1> TOP 24H TV SHOWS</h1>
        <b-carousel
      id="carousel-1"
      v-model="slide"
      :interval="2000"
      background="#F7E6AA"
      img-width="1024"
      img-height="280"
      style="text-shadow: 1px 1px 2px #333;"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
       
    >

      <!-- Slides with custom text -->
      <div class="carou" v-for="serie in series" v-bind:key="serie.id">
        <router-link :to="`/tv/${serie.id}/read`" class="tag">
        <b-carousel-slide v-bind:img-src="`https://image.tmdb.org/t/p/w500${serie.poster_path}`">
      </b-carousel-slide>
        </router-link>
      </div>
    </b-carousel>
  </div>
</div>
</template>

<script>
import axios from 'axios'
  export default {
    name: "Caroussel",
    data() {
      return {
        slide: 0,
        sliding: null,
        movies: [],
        series: []
      }
    },

    mounted(){

     const url = "https://api.themoviedb.org/3/trending/movie/day?api_key=de54d62bf9e00c29e63f7cb274ff0282"

    axios.get(url)
        .then(response => {
            this.movies = response.data.results
            console.log(this.movies)
        }).catch(error => {
            console.log('Error : ', error.response)
        }) 

    const url1 = "https://api.themoviedb.org/3/trending/tv/day?api_key=de54d62bf9e00c29e63f7cb274ff0282"

    axios.get(url1)
        .then(response => {
            this.series = response.data.results
            console.log(this.series)
        }).catch(error => {
            console.log('Error : ', error.response)
        }) 

    },
    methods: {
      onSlideStart(slide) {
        this.sliding = true
      },
      onSlideEnd(slide) {
        this.sliding = false
      }
    }
  }
</script>

<style scoped>

.caroussel{
  width: 100%;
  display: flex;
}

.mainC{
margin-left: 6%;
}

.carou{
  width: 50%;
  background-color: #F7E6AA;
}

h1{
    margin-top: 10%;
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
}

</style>