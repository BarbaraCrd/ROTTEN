<template>
    <div class="newTV">
        <div class="tvS">
            <h1> TOP 10 POPULAR TV SHOWS</h1>
            <ul id="example-1">
                <li v-for="tv in tvs.slice(0, 10)" :key="tv.id">
                 <div class="name"> {{ tv.name }}  </div> <div class="vote">  {{tv.vote_average }}/10 </div>
                </li>
            </ul>
        </div>
            <div class="movieN">
                <h1> TOP 10 RATED MOVIES</h1>
                <ul id="example-2">
                    <li v-for="movie in movies.slice(0, 10)" :key="movie.id">
                    <div class="name"> {{ movie.original_title }}  </div> <div class="vote"> {{movie.vote_average }}/10 </div>
                     </li>
                </ul>
            </div>
    </div>
</template>

<script>
export default {
    name:"newTV",
    data(){
        return{
            tvs : [],
            movies : []
        }
    },
    
    mounted(){
    const url = `https://api.themoviedb.org/3/tv/popular?&api_key=de54d62bf9e00c29e63f7cb274ff0282`

    fetch(url)
    .then((response) => response.json())
    .then ((data) => this.tvs = data.results)     

    fetch("https://api.themoviedb.org/3/movie/top_rated?&api_key=de54d62bf9e00c29e63f7cb274ff0282")
    .then((response) => response.json())
    .then ((data) => this.movies = data.results)     
    }
}
</script>

<style scoped>

li{
    display: flex;
    justify-content: space-between;
    margin-bottom: 1%;
}


h1{
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
    margin-left: 10%;
    margin-bottom: 3%;
}


.newTV{
    display: flex;
    justify-content: space-around;
    padding-bottom: 10%;
}

.movieN{
    -webkit-box-shadow: 0px 0px 15px 5px #E22E2F; 
    box-shadow: 0px 0px 15px 5px #E22E2F;
    padding-right: 30px;
    padding-top: 30px;
}

.tvS{
    -webkit-box-shadow: 0px 0px 15px 5px #E22E2F; 
    box-shadow: 0px 0px 15px 5px #E22E2F;
    padding-right: 30px;
    padding-top: 30px;
}


</style>