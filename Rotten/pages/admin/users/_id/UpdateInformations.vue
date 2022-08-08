<template>
    <div class="global">
  <div class="update">
      <div class="title">UPDATE INFORMATIONS</div>
      <div class="firstName">
          <div><label>First Name :</label></div>
          <input type="text" v-model="firstName" @change="changeFN($event)"> 
      </div>
      <div class="lastName">
          <div><label>Last Name :</label></div>
          <input type="text" v-model="lastName" @change="changeLN($event)">
      </div>
      <div class="email">
          <div><label>Email :</label></div>
          <input type="text" v-model="email" @change="changeE($event)">
      </div>
      <div class="uRole">
          <div><label>Role :</label></div>
          <input type="text" v-model="uRole" @change="changeU($event)">
      </div>
      <button @click="submit(id)" class="updatei">
          Submit
      </button>
       <a href="/admin/homeadmin"><button class="updatep">
          Return to user panel
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
			email: "",
			firstName: "",
			lastName: "",
            uRole:"",
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

        axios.get('http://localhost:8000/api/users')
        .then(response => {
            this.users = response.data.filter(element => element.id == this.id)
            console.log(this.users[0].firstName)
            this.firstName = this.users[0].firstName
            this.lastName = this.users[0].lastName
            this.email = this.users[0].email
            this.uRole = this.users[0].uRole
        }).catch(error => {
            console.log('Error : ', error.response)
    })
    },
    methods: {

        getAdmin(){
            this.admin = localStorage.getItem("uRole")
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
        changeU(event) {
            this.uRole = event.target.value 
        },
        submit(id) {
            axios.put('http://localhost:8000/api/users/updateadmin/' + id, {
                firstName: this.firstName,
                lastName: this.lastName,
                email: this.email,
                uRole: this.uRole,
            }).then( (response) => {
                console.log(response)
                alert("Informations updated successfully")
                this.$router.push('/admin/homeadmin')
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

.title {
    margin-top:5%;
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
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