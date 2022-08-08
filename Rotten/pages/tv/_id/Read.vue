<template>
<div class="read">
    <div class="top">
      <div class="container">
            <Navbar/>
      </div> 
        <div class="container">
            <div class="card mb-3" style="max-width: 800px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                <img v-bind:src="`https://image.tmdb.org/t/p/w500${this.tv.poster_path}`" class="card-img" alt="movie poster">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{this.tv.name}}</h4>
                    <p class="card-text">{{this.tv.number_of_episodes}} episode(s) {{this.tv.number_of_seasons}} season(s)</p>
                    <p class="card-text"></p>
                    <p class="card-text">{{this.tv.release_date }}</p>
                    <p class="card-text">{{this.tv.overview}}</p>
                    <p class="pop">Vote average: {{this.tv.vote_average }}/10</p>
                </div>
                </div>
            </div>
            </div>
            <h1 class="urCom">  COMMENTS </h1>
                <div class="comments" v-for="comment in comments" v-bind:key="comment.id">
                    <div class="com"> 
                        <div class="content_cont">
                        <p class="author"> From {{comment.author}} :</p>
						<p class="content"> {{comment.content}}</p>
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
    name: "Read",
    data(){
        return{
            tv: [],
            
        }
    },

    created(){
      if(process.client)
      {
      this.getLogin()
      }
    },

    mounted(){

        if (this.login == null){
            this.$router.push('/login')
        }

        this.id = this.$route.params.id
        console.log(this.id)
        const url = `https://api.themoviedb.org/3/tv/${this.id}?api_key=de54d62bf9e00c29e63f7cb274ff0282&language=en-US`
        fetch(url)
            .then((response) => response.json())
            .then ((data) => this.tv = data)

    		axios.get(`https://api.themoviedb.org/3/tv/${this.id}/reviews?api_key=de54d62bf9e00c29e63f7cb274ff0282&language=en-US&page=1`)
        .then(response => {
            this.comments = response.data.results
            console.log(this.comments)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
        

    },

    methods: {
        getLogin(){
            this.login = localStorage.getItem("userId")
        },
    }
}
</script>

<style scoped>


.read{
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
}

.card{
    margin-top: -10%;
    background-color: #BEAE75;
    -webkit-box-shadow: 0px 0px 15px 5px #BEAE75; 
    box-shadow: 0px 0px 15px 5px #BEAE75;
    
}

.urCom{

	font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
}

.comments{
	-webkit-box-shadow: 0px 0px 15px 5px #BEAE75; 
    box-shadow: 0px 0px 15px 5px #BEAE75;
    padding-right: 30px;
    padding-top: 30px;
	margin-bottom: 3%;
	background-color: #BEAE75;
}

.content{
	text-align: center;
	padding: 5px 5px 5px 5px;
	margin-bottom: 1%;
}

.author{
	padding-left: 10px;
}

.container{
	background-color: #F7E6AA;
    padding-bottom: 10%;
}
</style>