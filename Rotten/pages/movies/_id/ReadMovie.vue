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
                <img v-bind:src="'http://localhost:8000/' + movie.picture" class="card-img" widht="300" height="394" alt="movie poster">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{movie.title}}</h4>
                    <p class="card-text">{{movie.runtime}} minutes</p>
                        <p class="card-text">{{movie.date }}</p>
                        <p class="card-text">{{movie.synopsis}}</p>
                        <div v-if="avg_notes == 0">
                        <p class="pop">Vote average: /10</p></div>
                        <div v-else>
                        <p class="pop">Vote average: {{(avg_notes/nb_votes).toFixed(1)}} /10</p></div>
                        <div ref="ratingEl" class="vue-stars" :class="{ readonly: readonly, notouch: notouch }" :style="mapCssProps">
		<input :id="name + '0'" :checked="value === 0" :name="name" type="radio" value="0" />
		<template v-for="x in max">
			<label :key="'l' + x" :for="name + x">
				<span class="active">
					<slot name="activeLabel">{{ getActiveLabel(x) }}</slot>
				</span>
				<span class="inactive">
					<slot name="inactiveLabel">{{ getInactiveLabel(x) }}</slot>
				</span>
			</label>
			<input
				:id="name + x"
				:key="'i' + x"
				:checked="value === x"
				:name="name"
				:disabled="readonly"
				:value="x"
				type="radio"
				@change="updateInput($event.target.value)"
			/>
		</template>
        
	</div>
    <div>
                        <button class="add" @click="Add()">Add to Favorites</button>
                        <button class="remove" @click="destroy(favorite.id)">Remove from Favorites</button>
                        
                        </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        	<div class='container'>
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Post your comment</label>
                        <textarea v-model="com_content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>  
                </form>
                <button class="postCo" @click="PostComment()">Submit</button>
                <h1 class="urCom">  COMMENTS </h1>
                <div class="comments" v-for="comment in comments" v-bind:key="comment.id">
                    <div class="com"> 
                    <div class="content_cont">
                        <p class="author"> From {{comment.firstName}} :</p>
                        <p class="content"> {{comment.com_content}}</p>
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
            movie: [],
            picture:"",
            title:"",
            date:"",
            synopsis:"",
            runtime:"",
            favorite:[],
            avg_notes: "",
            nb_votes:"",
        }
    },
        	props: {
		max: { type: Number, required: false, default: 10 },
		value: { type: Number, required: false, default: 0 },
		name: { type: String, required: false, default: "rating" },
		char: { type: String, required: false, default: "★" },
		inactiveChar: { type: String, required: false, default: null },
		readonly: { type: Boolean, required: false, default: false },
		activeColor: { type: String, required: false, default: null },
		inactiveColor: { type: String, required: false, default: null },
		shadowColor: { type: String, required: false, default: null },
		hoverColor: { type: String, required: false, default: null },
	},
	computed: {
		ratingChars() {
			return Array.from(this.char)
           
		},
		inactiveRatingChars() {
			/* Default to ratingChars if no inactive characters have been provided */
			return this.inactiveChar ? Array.from(this.inactiveChar) : this.ratingChars
		},
		notouch() {
			/* For iPhone specifically but really any touch device, there is no true hover state, disables any pseudo-hover activity. */
			return typeof document !== "undefined" && !("ontouchstart" in document.documentElement)
		},
		mapCssProps() {
			const result = {}
			if (this.activeColor) result["--active-color"] = this.activeColor
			if (this.inactiveColor) result["--inactive-color"] = this.inactiveColor
			if (this.shadowColor) result["--shadow-color"] = this.shadowColor
			if (this.hoverColor) result["--hover-color"] = this.hoverColor
			return result
		},

        
	},

    created(){
      if(process.client)
      {
      this.getLogin()
      }
    },

    beforeMount(){
        axios.get(`http://localhost:8000/api/getcomments`)
		.then(response => {
        this.comments = response.data.data.filter(element => element.movie_id == this.id)
        console.log(this.comments1)
        }).catch(error => {
        console.log('Error : ', error.response)
        })
    },

    mounted(){
        if (this.login == null){
            this.$router.push('/login')
        }
        this.id = this.$route.params.id
        console.log(this.id)
        axios.get('http://localhost:8000/api/movies/' + this.id)
        .then(response => {
            this.movie = response.data.data
            console.log(this.movie)
        }).catch(error => {
            console.log('Error : ', error.response)
        })

        axios.get('http://localhost:8000/api/favorites/' + localStorage.getItem("userId"))
        .then(response => {
            this.favorite = response.data[0]
            console.log(this.favorite)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
        
         axios.get('http://localhost:8000/api/notes')
        .then(response => {
            this.notes = response.data.filter(element => element.movie_id == this.id )
            this.avg_notes = this.notes[0].avg_notes
            this.nb_votes = this.notes[0].nb_votes
            console.log(this.notes)
        }).catch(error => {
            console.log('Error : ', error.response)
        })
        

    },

    methods: {

        getLogin(){
            this.login = localStorage.getItem("userId")
        },

        Add() {
            axios.post('http://localhost:8000/api/addfavorite', {
                movie_id: this.id,
                user_id: localStorage.getItem("userId")
            }).then( (response) => {
                console.log(response)
                alert('Added successfully to Favorites')
                this.$router.go()
            })
        },

        destroy(id) {
            axios.delete('http://localhost:8000/api/destroyfav/' + id)
            .then( () => {
                alert("Favorite successfully deleted")
                this.$router.go()
        })
        },
        
        	updateInput(v) {
			this.$emit("input", parseInt(v, 10))
            console.log(v)
            if(this.notes.length == 0) { 
                axios.post('http://localhost:8000/api/addnote', {
                movie_id: this.id,
                nb_votes: 1,
                avg_notes: v }).then( (response) => {
                console.log(response)
            })
            } 
            else { 
                let total = Number(this.notes[0].avg_notes) + Number(v)
                console.log(total)
                axios.put('http://localhost:8000/api/updatenote/' + this.id , {
                movie_id: this.id,
                nb_votes: this.notes[0].nb_votes + 1,
                avg_notes: total,
                }).then( (response) => {
                console.log(response)
                this.$router.go()
                })
            }
            this.vote = "Vote sended/updated !"
            
            
		},
		getActiveLabel(x) {
			const s = this.ratingChars
			return s[Math.min(s.length - 1, x - 1)]
		},
		getInactiveLabel(x) {
			const s = this.inactiveRatingChars
			return s[Math.min(s.length - 1, x - 1)]
		},

		PostComment(){
             axios.post(`http://localhost:8000/api/postcomments/${this.id}`, {
                com_content: this.com_content,
				user_id : localStorage.getItem("userId"),
            }).then( (response) => {
                console.log(response)
                alert('Comment sended')
            })
		}        
    }
}
</script>

<style scoped>

form{
	margin-top: -15%;
}

.read{
    background-image: url('https://www.zupimages.net/up/22/19/6uxo.png');
    background-size: 30%;
}

.container{
	background-color: #F7E6AA;
	padding-bottom: 10%;
}

.card{
    margin-top: -10%;
    background-color: #BEAE75;
    -webkit-box-shadow: 0px 0px 15px 5px #BEAE75;
    box-shadow: 0px 0px 15px 5px #BEAE75;
}

.add {
    border-radius:5px;
    background: rgb(181, 240, 181);
    outline: none;
}

.remove {
    border-radius:5px;
    background: #FCEBA7;
    outline: none;
}
.vue-stars {
	display: inline-flex;
	flex-flow: row nowrap;
	align-items: flex-start center;
	line-height: 1em;
}

.vue-stars label {
	display: block;
	padding: 0.125em;
	width: 1.2em;
	text-align: center;
	color: #fd0;
	text-shadow: 0 0 0.3em #ff0;
}

.vue-stars input,
.vue-stars label .inactive,
.vue-stars input:checked ~ label .active,
.vue-stars.notouch:not(.readonly):hover label .inactive,
.vue-stars.notouch:not(.readonly) label:hover ~ label .active {
	display: none;
}

.vue-stars input:checked ~ label .inactive,
.vue-stars.notouch:not(.readonly):hover label .active,
.vue-stars.notouch:not(.readonly) label:hover ~ label .inactive {
	display: inline;
}

.vue-stars.notouch:not(.readonly):hover label {
	color: #dd0;
	text-shadow: 0 0 0.3em #ff0;
}

.vue-stars input:checked ~ label,
.vue-stars.notouch:not(.readonly) label:hover ~ label {
	color: #999;
	text-shadow: none;
}

@supports (color: var(--prop)) {
	.vue-stars label {
		color: var(--active-color, #fd0);
		text-shadow: 0 0 0.2em var(--shadow-color, #ff0);
	}
	.vue-stars.notouch:not(.readonly):hover label {
		color: var(--hover-color, #dd0);
		text-shadow: 0 0 0.2em var(--shadow-color, #ff0);
	}
	.vue-stars input:checked ~ label,
	.vue-stars.notouch:not(.readonly) label:hover ~ label {
		color: var(--inactive-color, #999);
	}
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

.postCo{
	margin-bottom: 2%;
	background-color: #BEAE75;
	border: none;
	border-radius: 10px;
	width: 150px;
	margin-left: 42%;
}


.postCo:hover{
	background-color: #E2314A;
	transition: 0.5s;
}
</style>