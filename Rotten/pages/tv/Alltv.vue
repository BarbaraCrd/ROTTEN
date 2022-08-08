<template>
<div class="Alltv">
<div class="top">
        <div class="container">
            <Navbar/>
        </div>    
</div>
        <div class="container">

            <div class="allCards">
                <div class="card" v-for="tv in tvs" :key="tv.id" style="width: 13rem;">
                <router-link :to="`/tv/${tv.id}/read`" class="tag">
                <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`" alt="Card image cap">
                 </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{tv.name }} </h5>
                        <p class="card-text">{{tv.first_air_date }}</p>
                        <p class="pop">Vote average: {{tv.vote_average }}/10</p>
                    </div>
                </div>
                <div class="card" v-for="tv in tvs1" :key="tv.id" style="width: 13rem;">
                <router-link :to="`/tv/${tv.id}/read`" class="tag">
                <img class="card-img-top" v-bind:src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`" alt="Card image cap">
                </router-link> 
                    <div class="card-body">
                        <h5 class="card-title">{{tv.name }} </h5>
                        <p class="card-text">{{tv.first_air_date}}</p>
                        <p class="pop">Vote average: {{tv.vote_average }}/10</p>
                    </div>
                </div>
            </div>               
        </div>


</div>
</template>

<script>
export default {
    name: "Alltv",
    data(){
    return{
        tvs:[],
        tvs1:[]
    }
    },
    mounted(){


    fetch("https://api.themoviedb.org/3/tv/popular?api_key=de54d62bf9e00c29e63f7cb274ff0282&language=en-US&page=1")
    .then((response) => response.json())
    .then ((data) => this.tvs = data.results)  
    fetch("https://api.themoviedb.org/3/tv/popular?api_key=de54d62bf9e00c29e63f7cb274ff0282&language=en-US&page=2")    
    .then((response) => response.json())
    .then ((data) => this.tvs1 = data.results)  
   
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
    padding-top: 10%;
    display: flex;
    flex-wrap: wrap;
}

.Alltv{
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
}

.top{
    background-color: #F7E6AA;
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
}

.container{
    background-color: #F7E6AA;
}
</style>