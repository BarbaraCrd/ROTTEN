<template>
  <div class="global1">
  <div class="create">
      <div class="title">CREATE A USER</div>
      <div class="firstName">
          <label>First Name :</label>
          <div><input type="text" v-model="firstName" ></div>
      </div>
      <div class="lastName">
          <label>Last Name :</label>
          <div><input type="text" v-model="lastName" ></div>
      </div>
      <div class="email">
          <label>Email :</label>
          <div><input type="text" v-model="email" ></div>
      </div>

      <div class="password">
          <label>Password :</label>
          <div><input type="password" v-model="password" ></div>
      </div>

      <div class="password_conf">
          <label>Password Confirmation :</label>
          <div><input type="password" v-model="confirm_password" ></div>
      </div>

      <div class="urole">
          <label>Role :</label>
          <div><input type="text" v-model="uRole" ></div>
      </div>
      <button @click="submit()" class="updatei">
          Create
      </button>
       <a href="/admin/homeadmin"><button class="updatep">
          Return to User's List
      </button></a>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
		return {
			email: "",
			password: "",
			firstName: "",
			lastName: "",
			confirm_password: "",
            uRole:"",
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
        
        submit() {
            axios.post('http://localhost:8000/api/register', {
                firstName: this.firstName,
                lastName: this.lastName,
                email: this.email,
                password: this.password,
                confirm_password: this.confirm_password,
                uRole: this.uRole,
            }).then( (response) => {
                console.log(response)
                alert('User created successfully')
                this.$router.push('/admin/homeadmin')
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

.title {
    font-size: 24px;
    color: #E22E2F;
    font-weight: 700;
    margin-top: 10%;
}

.firstName {
    margin-top:8%;
}

.lastName {
    margin-top:3%;
}

.email {
    margin-top:3%;
}

.password {
    margin-top:3%;
}

.password_conf {
    margin-top:3%;
}

.urole {
    margin-top:3%;
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