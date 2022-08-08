<template>
<div class="home">
<div class="top">
        <div class="container">
            <Navbar/>
        </div>    
</div>
        <div class="container">
            <div class="carou">
                <Caroussel/>
            </div>
            <div class="newFilm">
                <h1 class="newTitle">
                   NEW & UPCOMING MOVIES
                </h1>
                <NewFilm/>
            </div>
            <div class="newTv">
                <newTV/>
            </div>
        </div>


</div>


</template>

<script>

import Navbar from '../components/Navbar.vue'
import Caroussel from '../components/Caroussel.vue'
import newTV from '../components/newTV.vue'
import NewFilm from '../components/NewFilm.vue'
import axios from 'axios'
export default {
name:"Home",
components: {Navbar, Caroussel, NewFilm, newTV},
beforeMount(){

			axios.post('https://api.themoviedb.org/3/authentication/session/new?api_key=de54d62bf9e00c29e63f7cb274ff0282', {
				request_token: localStorage.getItem('TMDBREAL')
			}).then( (response) => {
				console.log(response)
                localStorage.setItem('session_id', response.data.session_id)
                
			})

           
},

}


</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');

.top{

    background-color: #BEAE75;
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
  
}

.home{

    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
    font-family: "Poppins";

}

.container{
    background-color: #F7E6AA;
}

.newTitle{
    margin-top: 10%;
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
    margin-left: 10%;
    margin-bottom: 5%;
}

.carou{
    padding-top: 10%;
}





</style>