<template>
<div class="global">
  <div class="update">
      <div class="title1">UPDATE MOVIE</div>
      <div class="title">
          <div><label>Title :</label></div>
          <input type="text" v-model="title" @change="changeT($event)"> 
      </div>
      <div class="synopsis">
          <div><label>Synopsis :</label></div>
          <textarea v-model="synopsis" cols="23" row="3"  @change="changeS($event)"></textarea>
      </div>
      <div class="genre">
          <div><label>Genre :</label></div>
          <input type="text" v-model="genre" @change="changeG($event)">
      </div>
      <div class="date">
          <div><label>Date :</label></div>
          <input type="text" v-model="date" @change="changeD($event)">
      </div>
      <div class="runtime">
          <div><label>Runtime :</label></div>
          <input type="text" v-model="runtime" @change="changeR($event)">
      </div>
      <div class="director">
          <div><label>Director :</label></div>
          <input type="text" v-model="director" @change="changeDir($event)">
      </div>
      <div class="picture">
          <div><label>Picture :</label></div>
          <img :src="previewImage" class="uploading-image" />
          <input type="file" @change="uploadImage">
      </div>
      <button @click="submit(id)" class="updatei">
          Submit
      </button>
       <a href="/admin/movies"><button class="updatep">
          Return to Movie's List
      </button></a>
  </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    name:'UpdateInformations',
        data() {
		return {
            id:"",
			title: "",
			synopsis: "",
			genre: "",
            date:"",
            runtime:"",
            director:"",
            picture:"",
            previewImage:"",
		}
	},
    created() {
        this.id = this.$route.params.id
        console.log(this.id)
        
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
            this.movies = response.data.filter(element => element.id == this.id)
            console.log(this.movies[0].title)
            this.title = this.movies[0].title
            this.synopsis = this.movies[0].synopsis
            this.genre = this.movies[0].genre
            this.date = this.movies[0].date
            this.runtime = this.movies[0].runtime
            this.director = this.movies[0].director
            this.picture = this.movies[0].picture
        }).catch(error => {
            console.log('Error : ', error.response)
    })
    },
    methods: {

        getAdmin(){
            this.admin = localStorage.getItem("uRole")
        },

        changeT(event) {
            this.title = event.target.value 
        },
        changeS(event) {
            this.synopsis = event.target.value 
        },
        changeG(event) {
            this.genre = event.target.value 
        },
        changeD(event) {
            this.date = event.target.value 
        },
        changeR(event) {
            this.runtime = event.target.value 
        },
        changeDir(event) {
            this.director = event.target.value 
        },

        uploadImage(e) {

            const image = e.target.files[0];
            const reader = new FileReader();

            this.createBase64Image(image)
            reader.readAsDataURL(image);

            reader.onload = e =>{
            this.previewImage = e.target.result;
            console.log(this.previewImage);
            };

        },
        fileSelected(event) {
            //console.log(event.target.files[0])
            const selectedImage = event.target.files[0]
            this.createBase64Image(selectedImage)
            //console.log(this.post_picture)
        },

        createBase64Image(fileObject) {

            const reader = new FileReader();
            reader.onload = (e) => {
                this.picture = e.target.result;
                this.uploadImage;
            };

            reader.readAsDataURL(fileObject);
        },
        submit(id) {
            axios.put('http://localhost:8000/api/updatemovie/' + id, {
                title: this.title,
                synopsis: this.synopsis,
                genre: this.genre,
                date: this.date,
                runtime: this.runtime,
                director: this.director,
                picture: this.picture,
            }).then( (response) => {
                console.log(response)
                alert("Movie updated successfully")
                this.$router.push('/admin/movies')
            })
        },
    }
}
</script>

<style scoped>

.global {
        padding-top: 5%;
        background-color: #FCEBA7;
    	background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
		background-position: center;
		background-repeat: repeat;
		background-size: 30%;
        padding-bottom: 6% ;
}

.update {
    background-color: #FCEBA7;
    color:#E22E2F;
    display:flex;
    margin-left: 38.5%;
    flex-direction: column;
    width: 28%;
    height: 400px;
    border-radius: 10px;
    align-items: center;
    -webkit-box-shadow: 0px 0px 15px 5px #BEAE75; 
    box-shadow: 0px 0px 15px 5px #BEAE75;
    padding-bottom: 40%;
}

label {
    margin-right: 3%;
}

.title1 {
    
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
}

.title {
    margin-top:8%;
}

.synopsis {
    margin-top:3%;
}

.genre {
    margin-top:3%;
}

.date {
    margin-top:3%;
}

.runtime {
    margin-top:3%;
}

.direcor {
    margin-top:3%;
}

.picture {
    margin-top:3%;
}

.uploading-image {
    width: 150px;
}
.updatei {
    margin-top:8%;
    width: 34%;
    border-radius:5px;
    background: rgb(181, 240, 181);
    border:none;
    outline: none;
}

.updatep {
    margin-top:5%;
    width: 120%;
    margin-left:-10%;
    border-radius:5px;
    background: #FCEBA7;
    border:none;
    outline: none;
}
</style>