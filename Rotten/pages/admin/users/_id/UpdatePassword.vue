<template>
   <div class="global">
  <div class="update">
      <div class="title">UPDATE PASSWORD</div>
      <div class="password">
          <label>Password :</label>
          <div><input type="password" v-model="password"></div>
      </div>
      <div class="confirm_password">
          <label>Password Confirmation :</label>
          <div><input type="password" v-model="confirm_password" ></div>
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
    name: "UpdatePassword",
    data() {
        return {
            id:"",
            password: "",
            confirm_password: "",
        }
    },

    created(){
      if(process.client)
      {
      this.getAdmin()
      }
    },

    mounted() {
        this.id = this.$route.params.id
        console.log(this.id)

        if (this.admin == 0){
            this.$router.push('/home')
        }

    },
    methods: {

        getAdmin(){
            this.admin = localStorage.getItem("uRole")
        },
        
        submit(id) {
            axios.put('http://localhost:8000/api/users/updatep/' + id, {
                password: this.password,
                confirm_password: this.confirm_password,
            }).then( (response) => {
                console.log(response)
                alert("Password updated successfully")
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
    margin-top:10%;
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

.password {
    margin-top:8%;
}

.confirm_password {
    margin-top:3%;
}

.updatei {
    margin-top:8%;
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