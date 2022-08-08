<template>
    <div class="navbar1">
  <b-navbar toggleable="lg">
    <b-navbar-brand href="/home"><img class="logo" src="~/static/logo.png"></b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="/home">Home</b-nav-item>
        <b-nav-item href="/movies/allmovies">Movies</b-nav-item>
        <b-nav-item href="/tv/alltv">TV Shows</b-nav-item>
          <b-nav-item v-if="this.login == null" href="/login">Login</b-nav-item>
          <b-nav-item v-if="this.login !== null" @click=logout()>Logout</b-nav-item>
          <b-nav-item v-if="this.login !== null" href="/account">Profile</b-nav-item>
        <div v-if="this.admin == 1">
          <b-nav-item href="/admin/Homeadmin">Admin</b-nav-item>
        </div>  
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
</template>

<script>
export default {
    name: "Navbar",
    created(){
      if(process.client)
      {
      this.getLogin()
      this.getAdmin()
      }

    },

    methods:{
   getLogin(){
    this.login = localStorage.getItem("userId")
    },

    getAdmin() {
      this.admin = localStorage.getItem("uRole")
    },

    logout()  {
    if (window.confirm('Sure you want to logout?')) {
        localStorage.clear()
        this.$router.push("/login")

    }   
  },


    }
}
</script>

<style scoped>

.navbar1{
 background-color: #BEAE75;
 display: flex;
 flex-direction:row
}

.nav-link{
      color:black!important;
      font-weight: 800;
}

.cent{
    display: flex;
}

em{
    margin-left: 800%;
}

.logo{
  width: 20%;
}



</style>