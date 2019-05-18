<template>

  <v-app id="inspire">
    <v-layout>
      <v-flex xs8 offset-xs2 sm6 offset-sm3 md4 offset-md4>
        <br>
        <v-card>
          <v-img
            contain
            class="white--text"
            height="300px"
            :src="require('@/assets/retroCafe.jpg')"
          >
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>
          <v-card-title class="justify-center">
            <div class="mx-5">
              <span class="title blue--text">{{name}}</span><br>
              <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn large round depressed :color="color" class="mx-auto" @click="colchange">Check place</v-btn>
            
          </v-card-actions>
        </v-card>
<!-- 
         <br>
        <v-card>
          <v-img
            contain
            class="white--text"
            height="300px"
            :src="require('@/assets/friendsCafe.jpg')"
          >
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>
          <v-card-title class="justify-center">
            <div class="mx-5">
              <span class="title blue--text">{{name}}</span><br>
              <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn large round depressed :color="color" class="mx-auto" @click="colchange">Check place</v-btn>
            
          </v-card-actions>
        </v-card>

         <br>
        <v-card>
          <v-img
            contain
            class="white--text"
            height="300px"
            :src="require('@/assets/meruCafe.jpg')"
          >
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>
          <v-card-title class="justify-center">
            <div class="mx-5">
              <span class="title blue--text">{{name}}</span><br>
              <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn large round depressed :color="color" class="mx-auto" @click="colchange">Check place</v-btn>
            
          </v-card-actions>
        </v-card>

        <br>
        <v-card>
          <v-img
            contain
            class="white--text"
            height="300px"
            :src="require('@/assets/cornichePalas.jpg')"
          >
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>
          <v-card-title class="justify-center">
            <div class="mx-5">
              <span class="title blue--text">{{name}}</span><br>
              <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn large round depressed :color="color" class="mx-auto" @click="colchange">Check place</v-btn>
            
          </v-card-actions>
        </v-card>

        <br>
        <v-card>
          <v-img
            contain
            class="white--text"
            height="300px"
            :src="require('@/assets/harmonyCafe.jpg')"
          >
            <v-container fill-height fluid>
              <v-layout fill-height>
                <v-flex xs12 align-end flexbox>
                </v-flex>
              </v-layout>
            </v-container>
          </v-img>
          <v-card-title class="justify-center">
            <div class="mx-5">
              <span class="title blue--text">{{name}}</span><br>
              <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn large round depressed :color="color" class="mx-auto" @click="colchange">Check place</v-btn>
            
          </v-card-actions>
        </v-card> -->
      </v-flex>
    </v-layout>
  </v-app>

</template>

<script>
import PlacesService from "../PlacesService"

export default {
    name: 'PlacesComponent',
    data() {
        return{
        list:null,
        name:"",
        rating: 3,
        color:"grey lighten-2"
        }
    },
    methods:{
        colchange(){
        this.color = this.color === "blue"?"grey lighten-2":"blue";
        },
         getPlaces: function(){
           this.data = PlacesService.getPlaces().then((data) => {
            console.log(data)
          })
        }
      },
       mounted: function () {
        this.getPlaces();
    }
    
}
</script>