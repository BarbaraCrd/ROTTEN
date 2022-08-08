<template>
  <div class="global">
  <div class="update">
      <div class="firstName">
          <label>First Name :</label>
          <input type="text" v-model="firstName" @change="changeFN($event)"> 
      </div>
      <div class="lastName">
          <label>Last Name :</label>
          <input type="text" v-model="lastName" @change="changeLN($event)">
      </div>
      <div class="email">
          <label>Email :</label>
          <input type="text" v-model="email" @change="changeE($event)">
      </div>
      <button @click="submit()" class="updatei">
          Submit
      </button>
        <button class="updatep"><router-link :to="'/account'" class="tag">
          Return to your account
      </router-link></button>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name:"UpdateIView",
    data() {
        return {
            users:[],
            firstName:"",
            lastName:"",
            email:"",
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
            console.log(this.users[0].firstName)
            this.firstName = this.users[0].firstName
            this.lastName = this.users[0].lastName
            this.email = this.users[0].email
        }).catch(error => {
            console.log('Error : ', error.response)
    })
    },

    methods:{
        getLogin(){
            this.login = localStorage.getItem("userId")
        },

        changeFN(event) {
            this.firstName = event.target.value 
        },
        changeLN(event) {
            this.lasttName = event.target.value 
        },
        changeE(event) {
            this.email = event.target.value 
        },
        submit() {
            axios.put('http://localhost:8000/api/users/updatei/' + localStorage.getItem('userId'), {
                firstName: this.firstName,
                lastName: this.lastName,
				email: this.email,
            }).then( (response) => {
                console.log(response)
                alert("Informations updated successfully")
                this.$router.go()
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
        padding-bottom: 14.5% ;
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
    margin-top: 10%;
    -webkit-box-shadow: 0px 0px 15px 5px #BEAE75; 
    box-shadow: 0px 0px 15px 5px #BEAE75;
}

label {
    margin-right: 3%;
}

.firstName {
    margin-top:10%;
    margin-left:15%;
}

.lastName {
    margin-top:3%;
    margin-left:15%;
}

.email {
    margin-top:3%;
    margin-left:8%;
}

.updatei {
    margin-top:4%;
    width: 45%;
    border-radius:5px;
    background: rgb(181, 240, 181);
    border:none;
    outline: none;
}

.updatep {
    margin-top:3%;
    width: 100%;
    border-radius:5px;
    background: #FCEBA7;
    border:none;
    outline: none;
}
</style>