<template>
       <div class="container">
            <Navbar/>
             <div class="kpidbperso">
                DATABASE MOVIES KPI

                <div class="nbmovies">
                    TOTAL OF MOVIES IN DB
                    {{movies}}
                </div>
                <div class="avgfav">
                    AVERAGE FAVORITES MOVIES PER USERS
                    {{favorites/users}}
                </div>
                <div class="avgvote">
                    AVERAGE VOTES PER USERS
                    {{sum/users}}
                </div>
            </div>
       </div>
</template>

<script>
import axios from 'axios'
export default {

    data() {
        return {
            users:[],
            favorties:[],
            notes:[],
            sum:"",
        }
    },
    mounted() {

        axios.get('http://localhost:8000/api/movies')
        .then(response => {
            this.movies = response.data.length
            console.log(response.data.length)
        }).catch(error => {
            console.log('Error : ', error.response)
        })

        axios.get('http://localhost:8000/api/users')
        .then(response => {
            this.users = response.data.length
            console.log(this.users)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
        
        axios.get('http://localhost:8000/api/favorites')
        .then(response => {
            this.favorites = response.data.length
            console.log(this.favorites)
        }).catch(error => {
            console.log('Error : ', error.response)
        })

        axios.get('http://localhost:8000/api/notes')
        .then(response => {
            this.notes = response.data
            let sum = 0
            for (let i=0; i<this.notes.length; i++) {
                sum += this.notes[i].nb_votes;
                return sum
            } 
            console.log(sum)
            console.log(this.notes[0].nb_votes)
        }).catch(error => {
            console.log('Error : ', error.response)
        })

    },
}
</script>

<style>

</style>