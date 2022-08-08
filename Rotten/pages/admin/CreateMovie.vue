<template>
  <div class="global1">
  <div class="create">
      <div class="title1">CREATE A MOVIE</div>
      <div class="title">
          <label>Title :</label>
          <div><input type="text" v-model="title" ></div>
      </div>
      <div class="synopsis">
          <label>Synopsis :</label>
          <div><textarea v-model="synopsis" cols="23" row="3"></textarea></div>
      </div>
      <div class="genre">
          <label>Genre :</label>
          <div><input type="text" v-model="genre" ></div>
      </div>

      <div class="date">
          <label>Date :</label>
          <div><input type="text" v-model="date" ></div>
      </div>

      <div class="runtime">
          <label>Runtime :</label>
          <div><input type="text" v-model="runtime" ></div>
      </div>

      <div class="director">
          <label>Director :</label>
          <div><input type="text" v-model="director" ></div>
      </div>

      <div class="picture">
          <label>Picture :</label>
            <img :src="previewImage" class="uploading-image" />
          <div><input type="file" @change="uploadImage" class="custom-input" accept="image/png/jpg"></div>
      </div>
      <button @click="submit()" class="updatei">
          Create
      </button>
       <a href="/admin/movies"><button class="updatep">
          Return to Movies's List
      </button></a>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
		return {
            movies:[],
			title: "",
			synopsis: "",
			genre: "",
			date: "",
            runtime:"",
			director: "",
            picture:"",
            previewImage:"",
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
    },

    methods: {

        getAdmin(){
            this.admin = localStorage.getItem("uRole")
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

        submit() {
            //axios.defaults.headers.post['Authorization'] = `Bearer ${localStorage.getItem('jwt')}`
            axios.post('http://localhost:8000/api/storemovie', {
                title: this.title,
                synopsis: this.synopsis,
                genre: this.genre,
                date: this.date,
                runtime: this.runtime,
                director: this.director,
                picture: this.picture,
            }).then( (response) => {
                console.log(response)
                alert('Movie created successfully')
                this.$router.push('/admin/movies')
            })
        },
    }

}

</script>

<style scoped>

.global1 {
        padding-top: 5%;
        background-color: #FCEBA7;
    	background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
		background-position: center;
		background-repeat: repeat;
		background-size: 30%;
        padding-bottom: 6% ;
}

.create {
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
    width: 35%;
    border-radius:5px;
    background: rgb(181, 240, 181);
    border:none;
    outline: none;
}

.updatep {
    margin-top:20px;
    margin-left:-12%;
    width: 124%;
    border-radius:5px;
    background: #FCEBA7;
    border:none;
    outline: none;
}

</style>