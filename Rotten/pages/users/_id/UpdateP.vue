<template>
    <div class="global">
  <div class="update">
      <div class="password">
          <label>Password :</label>
          <input type="password" v-model="password"> 
      </div>
      <div class="confirm_password">
          <label>Password Confirmation :</label>
          <input type="password" v-model="confirm_password" >
      </div>
      <button @click="submit()" class="updatei">
          Submit
      </button>
       <button class="updatep"><router-link :to="`/account`" class="tag">
          Return to your account
      </router-link></button>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name:"UpdatePView",
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
    },
    methods: {
        getLogin(){
            this.login = localStorage.getItem("userId")
        },

        submit() {
            axios.put('http://localhost:8000/api/users/updatep/' + localStorage.getItem('userId'), {
                password: this.password,
                confirm_password: this.confirm_password,
            }).then( (response) => {
                console.log(response)
                alert("Password updated successfully")
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

.password {
    margin-top:15%;
    margin-left: 14%;

}

.confirm_password {
    margin-top:3%;
    margin-left: 30%;
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